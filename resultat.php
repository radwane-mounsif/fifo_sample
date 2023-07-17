<?php
// Inclusion du fichier de connexion à la base de données
include('db.php');

// Récupération des valeurs distinctes de la colonne "ligne" du tableau 1
$query = "SELECT DISTINCT ligne FROM tabl";
$result = mysqli_query($connexion, $query);

$lignes = array();
while ($row = mysqli_fetch_assoc($result)) {
    $lignes[] = $row['ligne'];
}

// Récupération des valeurs distinctes de la colonne "step" du tableau 1
$query = "SELECT DISTINCT step FROM tabl";
$result = mysqli_query($connexion, $query);

$steps = array();
while ($row = mysqli_fetch_assoc($result)) {
    $steps[] = $row['step'];
}

// Affichage des listes déroulantes pour la recherche par ligne et par step
echo "<form method='get' action='time.php'>";
echo "<label for='ligne'>Recherche par ligne :</label>";
echo "<select name='ligne' id='ligne'>";
foreach ($lignes as $ligne) {
    echo "<option value='$ligne'>$ligne</option>";
}
echo "</select>";

echo "<br>";

echo "<label for='step'>Recherche par step :</label>";
echo "<select name='step' id='step'>";
foreach ($steps as $step) {
    echo "<option value='$step'>$step</option>";
}
echo "</select>";

echo "<br>";

echo "<input type='submit' value='Rechercher'>";
echo "</form>";

// Fermeture de la connexion à la base de données
mysqli_close($connexion);
?>
