<?php
// Inclure le fichier de connexion à la base de données
require_once('db.php');

// Vérifier si le nom de la machine a été passé en paramètre dans l'URL
if(isset($_GET['nom_machine'])) {
  // Récupérer le nom de la machine depuis l'URL
  $nom_machine = $_GET['nom_machine'];

  // Requête SQL pour sélectionner les paramètres correspondant au nom de machine connecté
  $sql = "SELECT date_heur, lot_id, rtp, emplacement, confirmation, date_heur1 FROM pieces_supprimees WHERE alias='$nom_machine'";

  // Exécuter la requête
  $result = mysqli_query($connexion, $sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Résultats pour <?php echo $nom_machine; ?></title>
  <style>
  table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  border: 1px solid black;
  padding: 8px;
  text-align: center;
}

th {
  background-color: #ddd;
}


  </style>
</head>
<body>
  <h1>Résultats pour <?php echo $nom_machine; ?></h1>
  <?php
    // Vérifier si la requête a renvoyé des résultats
    if(mysqli_num_rows($result) > 0) {
      // Afficher les résultats sous forme de tableau
      echo "<table>";
      echo "<tr><th>Date\ heure (IN)</th><th>Lot ID</th><th>RTP</th><th>Emplacement</th><th>Confirmation</th><th>Date\heure (out)</th></tr>";
      $rows = array();
while($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}

$rows = array_reverse($rows);

foreach ($rows as $row) {
    echo "<tr>";
    echo "<td>".$row['date_heur']."</td>";
    echo "<td>".$row['lot_id']."</td>";
    echo "<td>".$row['rtp']."</td>";
    echo "<td>".$row['emplacement']."</td>";
    echo "<td>".$row['confirmation']."</td>";
    echo "<td>".$row['date_heur1']."</td>";
    echo "</tr>";
}

    } else {
      // Afficher un message d'erreur si la requête n'a renvoyé

}
?>
<meta http-equiv="refresh" content="10">
</body>
</html>
<?php
} else {
  // Rediriger vers la page de connexion si le nom de machine n'a pas été passé en paramètre dans l'URL
  header("Location: login.php");
  exit();
}
?>