<?php

include('bdd.php');
include('auth.php');

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title> page d'accueil </title>
</head>
<body>

    <?php $_GET['page'] = "index"; include('header.php') ?>

    <main>
        <?php if ($userConnected) : ?>
        <h1>Bonjour, <?php echo $user['prenom'] . " " . $user['nom'] ?></h1>
        
        <?php if ($user['login'] == 'admin') : ?>
        <a href="admin.php">Voir les utilisateurs</a>
        <?php endif; ?>
    
        <?php else: ?>
        <h1 class="title">Bienvenue à module-connexion</h1>
        <p class="subtitle">Connectez-vous pour acceder au site</p>
        <img class="emoji" src="hajar_emoji.jpg" alt="Emoji de Hajar" />
        <?php endif; ?>

    </main>

    <?php include('footer.php') ?>
</body>
</html>