<?php
// Connexion à la base de données
include "db.php";
// Requête pour récupérer les données dans la colonne "alias"
$sql = "SELECT alias FROM tabl";

// Exécution de la requête
$resultat2 = mysqli_query($connexion, $sql);

// Vérification des résultats
if (mysqli_num_rows($resultat2) > 0) {
    // Création de la liste déroulante HTML
    echo '<select name="choix">';
    while ($row = mysqli_fetch_assoc($resultat2)) {
        echo '<option value="' . $row['alias'] . '">' . $row['alias'] . '</option>';
    }
    echo '</select>';
} else {
    echo 'Aucun résultat trouvé.';
}

// Fermeture de la connexion
mysqli_close($connexion);
?>
