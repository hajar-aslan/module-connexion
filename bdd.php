<?php 

$db_hostname = "localhost";
$db_username = "root";
$db_password = "";
$db_database = "moduleconnexion";


$conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

if (!$conn) {
    die("erreur de connexion a la base de donner $db_database => " . mysqli_connect_error() );
}

// echo "connexion à la base de donnée réussit!!";


?>