<!DOCTYPE html>
<html>
<head>
	<title>machine</title>
</head>
<body>
	<h1>machine</h1>
	<form method="post" action="input_alias.php">
		<label for="step">step :</label>
		<input type="text" name="step" id="step" required><br><br>
		<label for="alias">alias :</label>
		<input type="text" name="alias" id="alias" required><br><br>
		<input type="submit" name="submit" value="Envoyer">
	</form>
</body>
</html>
<?php
// Connexion à la base de données
// Connexion à la base de données
include "db.php";

// Récupération des données du formulaire
$step = mysqli_real_escape_string($connexion, $_POST['step']);
$alias = mysqli_real_escape_string($connexion, $_POST['alias']);


// Insertion des données dans la base de données
$insert_query = "INSERT INTO tabl (step, alias) VALUES ('$step', '$alias')";
if (mysqli_query($connexion, $insert_query)) {
	echo "Données insérées avec succès";
} else {
	echo "Erreur lors de l'insertion des données : " . mysqli_error($connexion);
}

// Fermeture de la connexion
mysqli_close($connexion);
?>
