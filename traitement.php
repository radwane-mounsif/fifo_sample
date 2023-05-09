<?php
// Connexion à la base de données
include "db.php";

// Récupération des données du formulaire
$lot_id = mysqli_real_escape_string($connexion, $_POST['lot_id']);
$alias = mysqli_real_escape_string($connexion, $_POST['alias']);
$rtp = mysqli_real_escape_string($connexion, $_POST['rtp']);
$emplacement = mysqli_real_escape_string($connexion, $_POST['emplacement']);


// Insertion des données dans la base de données
$insert_query = "INSERT INTO pieces (lot_id, alias, rtp, emplacement, date_heur) VALUES ('$lot_id', '$alias', '$rtp', '$emplacement',NOW())";
if (mysqli_query($connexion, $insert_query)) {
	// Redirection vers la page "input_data.php" si l'insertion des données est réussie
	header("Location: input_data.php");
	exit();
} else {
	echo "Erreur lors de l'insertion des données : " . mysqli_error($connexion);
}

// Fermeture de la connexion
mysqli_close($connexion);
?>
