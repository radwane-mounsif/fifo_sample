<!DOCTYPE html>
<html>
<head>
	<title>Vérification ligne</title>
</head>
<body>
	<h1>Vérification ligne</h1>
	<form method="get" action="input_data.php">
		<label for="ligne">Entrez une ligne :</label>
		<input type="text" name="ligne" id="ligne" required>
		<input type="submit" name="submit" value="Vérifier">
	</form>
</body>
</html>

<?php
// Vérifier si la variable 'ligne' est définie dans l'URL
if(isset($_GET['ligne'])){
    // Récupérer la valeur de 'ligne' depuis l'URL
    $ligne = $_GET['ligne'];

    // Connexion à la base de données
    include "db.php";

    // Vérifier si la ligne existe dans la table 'tabl'
    $sql = "SELECT COUNT(*) FROM tabl WHERE ligne = '$ligne'";
    $result = mysqli_query($connexion, $sql);
    $row = mysqli_fetch_row($result);

    // Si la ligne existe, rediriger vers la page input_data avec la valeur de 'ligne' dans l'URL
    if($row[0] > 0){
        header("Location: input_data.php?ligne=$ligne");
        exit;
    } else {
        echo "La ligne $ligne n'existe pas.";
    }

    // Fermeture de la connexion
    mysqli_close($connexion);
}
?>
