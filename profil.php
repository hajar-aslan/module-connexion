

  <?php 
  
  require ('bdd.php');
  require ('auth.php');


  if (!isset($_SESSION['id'])) {
    header('Location: index.php');
  }
  
  $user_id = $_SESSION['id'];

  $user_result = mysqli_query($conn, "SELECT `login`, `prenom`, `nom` FROM `utilisateurs` WHERE id = '$user_id'");

  $user = mysqli_fetch_assoc($user_result);


 // echo json_decode($user_id);

  $user_login = $user['login'];
  $user_prenom = $user['prenom'];
  $user_nom = $user['nom'];

  // var_dump($user);

  ?>

  <?php // essaie de traitement de base de donnée mais ne fonctionne pas
  /*try{
    //On se connecte à la BDD
    $user = $_POST['login'];
    $pass = $_POST['password'];
    $dbco = new PDO("mysql:host=$serveur;dbname=$dbname",$user,$pass);
    $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    echo "connecté à la base de donnée!";

    //On renvoie l'utilisateur vers la page de remerciement
    // header("Location:form-merci.html");
}
catch(PDOException $e){
    echo 'Impossible de traiter les données. Erreur : '.$e->getMessage();
}*/




// verification que toute les données soit presentent
/*if (isset ($_POST['valider'])) {
    if (isset($_POST['login']) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['password']) && isset($_POST['confirmation']) ){
        if (!empty($_POST['login']) && !empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['password']) && !empty($_POST['confirmation']) ){
            
            // Traitement des informations 
            $login= htmlspecialchars($_POST['login']);
            $prenom= htmlspecialchars($_POST['prenom']);
            $nom= htmlspecialchars($_POST['nom']);
            $password= htmlspecialchars($_POST['password']);
            $confirmation= htmlspecialchars($_POST['confirmation']);
            
            echo "Bonjour $prenom $nom";

            
            }
            if ($password == $confirmation) {

                $sth = $dbco->prepare("INSERT INTO `utilisateurs` (`login`, `prenom`, `nom`, `password`) VALUES(?, ?, ?, ?)");
                $sth->execute(array($login, $prenom, $nom, $password));

                var_dump($sth);

                header('Location: connexion.php');
        
            }
 
            

            $dbco = null; //deconnexion de la base de donnée 

        }

    }*/
    ?>
            





<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title> Profil </title>
</head>
<body>

    <?php $_GET['page'] = "profil"; include('header.php') ?>
    
    <main>
        <?php
            if(isset($_GET['erreur'])){
                $err = $_GET['erreur'];
                if($err==1){
                    echo "<p style='color:red'>Utilisateur déjà créé, ou login déjà pris</p>";
                }
                if($err==2){
                    echo "<p style='color:red'>Mots de passe différents</p>";
                }
                if($err==3){
                    echo "<p style='color:red'>Veuillez remplir tous les champs</p>";
                }
            }
        ?>
        <?php
        if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['confirmation'])){
            $login = mysqli_real_escape_string($conn,htmlspecialchars($_POST['login']));
            $password = mysqli_real_escape_string($conn,htmlspecialchars($_POST['password']));
            $confirmation = mysqli_real_escape_string($conn,htmlspecialchars($_POST['confirmation']));
            $prenom = mysqli_real_escape_string($conn,htmlspecialchars($_POST['prenom']));
            $nom = mysqli_real_escape_string($conn,htmlspecialchars($_POST['nom']));

            if($login !== "" && $password !== "" && $confirmation !== "" && $prenom !== "" && $nom !== ""){
                if($password == $confirmation){
                    $requete = "SELECT count(*) FROM utilisateurs where login = '".$login."'";
                    $exec_requete = $conn -> query($requete);
                    $reponse      = mysqli_fetch_array($exec_requete);
                    $count = $reponse['count(*)'];

                    if($count==0 || $login == $user_login){
                        $password = password_hash($password, PASSWORD_DEFAULT);
                        $requete = "UPDATE `utilisateurs` SET `login` = '$login', `prenom` = '$prenom', `nom` = '$nom', `password` = '$password' WHERE id = '$user_id'";
                        $exec_requete = $conn -> query($requete);
                        echo "<p style='color:green'>Profil modifié</p>";

                        // header('Location: connexion.php');
                    }
                    else{
                        header('Location: profil.php?erreur=1'); // utilisateur déjà existant
                    }
                }
                else{
                    header('Location: profil.php?erreur=2'); // mot de passe différent
                }
            }
            else{
                header('Location: profil.php?erreur=3'); // utilisateur ou mot de passe vide
            }
        }

        mysqli_close($conn); // fermer la connexion

        ?>

        <form action="" method="post"> <!-- ceation le login-->
        
            <h2 class="titre"> Modifier Profil </h2>
        
            <label> Login </label>  <!-- creation la case de login -->
            <input type="text" name="login" id="login" placeholder=" Votre Login...." value="<?php echo $user_login ?>" <?php echo $user_login == "admin" ? 'disabled' : '' ?>><br> 
        
            <label> Prenom  </label>  <!-- creation la case de prenom -->
            <input type="text" name="prenom" id="prenom" placeholder=" Votre Prénom...." value="<?php echo $user_prenom ?>"><br> 
        
            <label> Nom </label>  <!-- creation la case de Nom -->
            <input type="text" name="nom" id="nom" placeholder=" Votre Nom...." value="<?php echo $user_nom ?>"><br> 
        
            <label> Mot de passe </label> <!-- creation la case de mot de passe -->
            <input type="password" name="password" id="password" placeholder=" Votre mot de passe ...."><br>
        
            <label> Confirmation de mot de passe </label> 
            <input type="password" name="confirmation" id="confirmation" placeholder=" confirmation de mot de passe...."><br>
        
            <button name="valider"> Modifier Profil </button>   
        </form>
    </main>
   
   
   
    <?php include('footer.php') ?>


</body>
</html>