<?php
$host = "fdb1030.awardspace.net";
$user = "4284983_user";
$password = "2v43JszP6eAfU@e";
$dbname = "4284983_user";

$connexion = mysqli_connect($host, $user, $password, $dbname);

// Vérification de la connexion
if (!$connexion) {
    die("La connexion a échoué : " . mysqli_connect_error());
}
?>
