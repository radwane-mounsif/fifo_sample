<?php
// Connexion à la base de données
include "db.php";

// Récupération des valeurs de ligne et step depuis la requête GET
$ligne = mysqli_real_escape_string($connexion, $_GET['ligne']);
$step = mysqli_real_escape_string($connexion, $_GET['step']);

// Requête pour récupérer les alias correspondants à la ligne et au step
$sql = "SELECT alias FROM tabl WHERE ligne = '$ligne' AND step = '$step'";
$result = mysqli_query($connexion, $sql);

// Création d'un tableau pour stocker les alias
$aliases = array();

// Parcours des résultats et ajout des alias au tableau
while ($row = mysqli_fetch_assoc($result)) {
    $aliases[] = $row['alias'];
}

// Fermeture de la connexion
mysqli_close($connexion);

// Renvoi des données au format JSON
echo json_encode($aliases);
?>
