<?php
// Connexion à la base de données
include "db.php";

// Récupération de la valeur du step depuis la requête GET
$step = $_GET['step'];

// Requête SQL pour récupérer les valeurs d'event correspondantes au step donné
$sql = "SELECT event FROM step_event_nortp WHERE step = '$step'";
$result = mysqli_query($connexion, $sql);

// Tableau pour stocker les valeurs d'event
$nonRtpOptions = array();

// Parcours des résultats de la requête et ajout des valeurs d'event au tableau
while ($row = mysqli_fetch_assoc($result)) {
    $nonRtpOptions[] = $row['event'];
}

// Fermeture de la connexion
mysqli_close($connexion);

// Retourne les valeurs d'event au format JSON
echo json_encode($nonRtpOptions);
?>
