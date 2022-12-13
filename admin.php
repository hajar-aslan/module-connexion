<?php   


include('bdd.php');
include('auth.php');

if (!isset($_SESSION['id'])){
  header('Location: connexion.php');
}


// recuper dans la session le 'id' de l'utilisateur comme 'user_id'
$user_id = $_SESSION['id'];

// 
$query = "SELECT `id` FROM `utilisateurs` WHERE login = 'admin'";
$resultat = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($resultat);


// var_dump($admin);

$admin_id = $admin['id'];

// echo "admin id is " . json_decode($admin_id);
// echo "user id is " . json_decode($user_id);

// si le id de cet utilisateur n'est pas egale a celui de l'admin (c'est-a-dire: 1) 
if ($user_id != $admin_id) {
    // redirige le vers la page d'acceuil 
    header('Location: index.php');
}


$users_only_query = "SELECT * FROM `utilisateurs` WHERE id != '$admin_id'";

$users = mysqli_fetch_all(mysqli_query($conn, $users_only_query));

// var_dump($users);



mysqli_close($conn);

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title> Admin </title>
</head>
<body>
    <?php $_GET['page'] = "admin"; include('header.php') ?>

    <main>
        <h2>Liste des utilisateurs</h2>
        <table>
            <thead>
                <tr>
                    <td>login</td>
                    <td>prenom</td>
                    <td>nom</td>
                    <td>password</td>
                </tr>
            </thead>
            <tbody>
        
                <?php 
    
                    foreach ($users as $user) {
                        echo "
                        <tr>
                            <td>" . $user[1] . "</td>
                            <td>" . $user[2] . "</td>
                            <td>" . $user[3] . "</td>
                            <td>" . $user[4] . "</td>
                        </tr>
        
                        ";
                    }
                
                ?>
    
            </tbody>
        </table>
    </main>

    <?php include('footer.php') ?>

</body>
</html>