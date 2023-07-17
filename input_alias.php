<!DOCTYPE html>
<html>
<head>
	<title>machine</title>
</head>
<body>
	<h1>machine</h1>
	<form method="post" action="input_alias.php">
        <label for="ligne">ligne :</label>
		<select id="ligne" name="ligne">
                <option value="TSSOP">TSSOP</option>
                <option value="SO8 SSHD">SO8 SSHD</option>
                <option value="SO14 SSHD">SO14 SSHD</option>
            </select><br><br>
		<label for="step">step :</label>
                <select id="step" name="step">
                <option value="Wire Bond">Wire Bond</option>
                <option value="Plasma">Plasma</option>
                <option value="Die Attach">Die Attach</option></select> <br><br>
           
		<label for="alias">alias :</label>
        <input type="text" name="alias" id="alias" required><br><br>
		<input type="submit" name="submit" value="Envoyer">
	</form>
</body>

<?php
// Connexion à la base de données
// Connexion à la base de données
include "db.php";

// Récupération des données du formulaire
$ligne = mysqli_real_escape_string($connexion, $_POST['ligne']);
$step = mysqli_real_escape_string($connexion, $_POST['step']);
$alias = mysqli_real_escape_string($connexion, $_POST['alias']);


// Insertion des données dans la base de données
$insert_query = "INSERT INTO tabl (ligne, step, alias) VALUES ('$ligne', '$step', '$alias')";
if (mysqli_query($connexion, $insert_query)) {
	echo "Données insérées avec succès";
} else {
	echo "Erreur lors de l'insertion des données : " . mysqli_error($connexion);
}

// Fermeture de la connexion
mysqli_close($connexion);
?>
</html>
