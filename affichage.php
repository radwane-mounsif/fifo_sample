<?php
include "db.php";

session_start();

if (isset($_GET['session_id'])) {
    $user_id = $_GET['session_id'];

    // Vérifier si l'utilisateur existe dans la base de données
    $result = mysqli_query($connexion, "SELECT id, username FROM user_spc WHERE id='$user_id'");
    if (mysqli_num_rows($result) == 0) {
        header("Location: login_spc.php");
        exit();
    }

    // Récupérer le nom d'utilisateur de l'utilisateur actuel
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];

} else {
    header("Location: login_spc.php");
    exit();
}


// Récupération des données de la base de données
$select_query = "SELECT date_heur, lot_id, alias, rtp, emplacement FROM pieces";
$resultat = mysqli_query($connexion, $select_query);

// Affichage des données dans deux tableaux en fonction de la valeur du paramètre RTP
if (mysqli_num_rows($resultat) > 0) {
    // Tableau des pièces ayant RTP : Oui
    echo "<h2>RTP : Oui (priority 1)</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Date/Heure</th><th>LOT_ID</th><th>Alias</th><th>RTP</th><th>Emplacement</th><th>Action</th></tr>";
    while ($row = mysqli_fetch_assoc($resultat)) {
      if ($row['rtp'] == 'oui') {
        echo "<tr><td>" . $row['date_heur'] . "</td><td>" . $row['lot_id'] . "</td><td>" . $row['alias'] . "</td><td>" . $row['rtp'] . "</td><td>" . $row['emplacement'] . "</td><td><a href='details.php?lot_id=" . $row['lot_id'] . "&alias=" . $row['alias'] . "&rtp=" . $row['rtp'] . "&emplacement=" . $row['emplacement'] . "&date_heur=" . $row['date_heur'] . "&username=" . $username . "'>Voir Détails</a></td></tr>";
      }
    }
    echo "</table>";

    // Tableau des pièces ayant RTP : Non
    mysqli_data_seek($resultat, 0);
    echo "<h2>RTP : Non (priority 2)</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Date/Heure</th><th>LOT_ID</th><th>Alias</th><th>RTP</th><th>Emplacement</th><th>Action</th></tr>";
    while ($row = mysqli_fetch_assoc($resultat)) {
      if ($row['rtp'] == 'non') {
        echo "<tr><td>" . $row['date_heur'] . "</td><td>" . $row['lot_id'] . "</td><td>" . $row['alias'] . "</td><td>" . $row['rtp'] . "</td><td>" . $row['emplacement'] . "</td><td><a href='details.php?lot_id=" . $row['lot_id'] . "&alias=" . $row['alias'] . "&rtp=" . $row['rtp'] . "&emplacement=" . $row['emplacement'] . "&date_heur=" . $row['date_heur'] . "&username=" . $username . "'>Voir Détails</a></td></tr>";
      }
    }    
    echo "</table>";
} else {
    echo "<div style='text-align:center; padding:50px; background-color:blue; color:white; border: 2px solid white;'><h1>Aucune donnée à afficher</h1></div>";
}

// Fermeture de la connexion
mysqli_close($connexion);
?>
<meta http-equiv="refresh" content="10">
<style>
/* Set the font family and size for the entire page */
body {
  font-family: Arial, sans-serif;
  font-size: 14px;
}

/* Style the table headers */
th {
  background-color: #dddh;
  font-weight: bold;
  text-align: left;
  padding: 10px;
}

/* Style the table rows */
td {
  padding: 10px;
}

/* Set the background color for the two sections */
h2:first-of-type {
  background-color: #f9f9f9;
  padding: 10px;
}

h2:last-of-type {
  background-color: #f2f2f2;
  padding: 10px;
}

/* Set the width of the table to 100% and add some margin and padding */
table {
  width: 100%;
  margin: 10px 0;
  border-collapse: collapse;
}

/* Set the background color of the links on hover */
a:hover {
  background-color: #ddd;
}
@media screen and (max-width: 600px) {
  /* Make the table columns stack vertically on smaller screens */
  table, thead, tbody, th, td, tr {
    display: block;
  }

  /* Hide the table headers */
  thead tr {
    position: absolute;
    top: -9999px;
    left: -9999px;
  }

  /* Add some padding to the table cells */
  td {
    padding: 10px;
  }

  /* Set the width of the table to 100% */
  table {
    width: 100%;
  }
}


</style>
