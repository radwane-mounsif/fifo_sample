<?php
// Connexion à la base de données
include "db.php";

// Récupération des paramètres de l'URL
$lot_id = $_GET['lot_id'];
$alias = $_GET['alias'];
$rtp = $_GET['rtp'];
$emplacement = $_GET['emplacement'];
$date_heur = $_GET['date_heur'];
$username = $_GET['username'];

// Vérification de l'envoi du formulaire de confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération de la confirmation
    $confirmation = $_POST['confirmation'];

    // Insertion des données supprimées et de la confirmation dans la table "pieces_supprimees_etat"
    $insert_query = "INSERT INTO pieces_supprimees (date_heur, lot_id, alias, rtp, emplacement, confirmation, username, date_heur1) VALUES ('$date_heur','$lot_id', '$alias', '$rtp', '$emplacement', '$confirmation', '$username', NOW() )";
    if (mysqli_query($connexion, $insert_query)) {
        echo "<script>alert('The results were successfully sent.'); window.location.href='affichage.php';</script>";
    } else {
        echo "Error " . mysqli_error($connexion);
    }

}

// Affichage des paramètres de la pièce sélectionnée et du formulaire de confirmation
echo "<h2>Details</h2>";
echo "<p>Lot ID : " . $lot_id . "</p>";
echo "<p>Alias : " . $alias . "</p>";
echo "<p>RTP : " . $rtp . "</p>";
echo "<p>Emplacement : " . $emplacement . "</p>";
echo "<p>Date/Heure : " . $date_heur . "</p>";
echo "<p>name operator SPC : ". $username . "</p>";

echo "<h2>Result</h2>";
echo "<form method='post' onsubmit='return validateConfirmation()'>";
echo "<label for='ok'>OK</label>";
echo "<input type='radio' name='confirmation' value='ok' id='ok' required>";
echo "<label for='ko'>KO</label>";
echo "<input type='radio' name='confirmation' value='ko' id='ko' required><br>";
echo "<input type='submit' value='send'>";
echo "</form>";

// Suppression de la ligne sélectionnée de la table "pieces"
$delete_query = "DELETE FROM pieces WHERE lot_id='$lot_id'";
if (mysqli_query($connexion, $delete_query)) {
    echo "";
} else {
    echo "Error " . mysqli_error($connexion);
}

?>

<script>
function validateConfirmation() {
    var radios = document.getElementsByName("confirmation");
    var formValid = false;

    var i = 0;
    while (!formValid && i < radios.length) {
        if (radios[i].checked) {
            formValid = true;
        }
        i++;
    }

    if (!formValid) {
        alert("Please select OK or KO");
    }

    return formValid;
}
</script>


<style>

  h2 {
    color: blue;
    font-size: 24px;
  }
  
  label {
    display: block;
    margin-top: 10px;
  }
  
  input[type='radio'] {
    margin-right: 10px;
  }
  
  input[type='submit'] {
    margin-top: 20px;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  .button {
			margin: 10px;
			padding: 10px 20px;
			border: none;
			border-radius: 5px;
			font-size: 18px;
			font-weight: bold;
			cursor: pointer;}
</style>
