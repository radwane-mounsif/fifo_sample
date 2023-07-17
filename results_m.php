<?php
// Inclure le fichier de connexion à la base de données
require_once('db.php');

// Vérifier si les paramètres ligne et step ont été passés en paramètres dans l'URL
if(isset($_GET['ligne']) && isset($_GET['step'])) {
  // Récupérer la ligne et le step depuis l'URL
  $ligne = $_GET['ligne'];
  $step = $_GET['step'];

  // Requête SQL pour sélectionner les valeurs distinctes de ligne et step dans la table pieces_supprimees
  $query = "SELECT DISTINCT ligne, step FROM pieces_supprimees";
  $result = mysqli_query($connexion, $query);

  $lignes = array();
  $steps = array();

  while ($row = mysqli_fetch_assoc($result)) {
    $lignes[] = $row['ligne'];
    $steps[] = $row['step'];
  }

  // Requête SQL pour sélectionner les enregistrements correspondant à la ligne et au step
  $sql = "SELECT date_heur, lot_id, rtp, emplacement, confirmation, date_heur1 FROM pieces_supprimees WHERE ligne='$ligne' AND step='$step'";

  // Exécuter la requête
  $result = mysqli_query($connexion, $sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Résultats pour Ligne <?php echo $ligne; ?> - Step <?php echo $step; ?></title>
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
<div style="background-color: #03234b;">
    <div style="float: right;margin: 10px ">
        <img src="epu2qqrv.png" alt="ST">
    </div>
    <div style="background-color: #03234b; margin: 0; overflow-x: hidden; overflow-y: auto; padding: 0;">
        <h1 style="color: white; text-align: center;">SPC SYSTEM : Ligne <?php echo $ligne; ?> - Step <?php echo $step; ?></h1>
    </div>
</div>

<?php
 // ...
if(mysqli_num_rows($result) > 0) {
  // Stocker les résultats dans un tableau
  $rows = array();
  while($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  // Afficher les résultats en sens inverse
  echo "<table>";
  echo "<tr><th>Date/Hour (IN)</th><th>Lot ID</th><th>Staut</th><th>Date/Hour (OUT)</th></tr>";
  for($i = count($rows) - 1; $i >= 0; $i--) {
    $row = $rows[$i];
    echo "<tr>";
    echo "<td>".$row['date_heur']."</td>";
    echo "<td>".$row['lot_id']."</td>";
    echo "<td>".$row['confirmation']."</td>";
    echo "<td>".$row['date_heur1']."</td>";
    echo "</tr>";
  }
  echo "</table>";
}
// ...

?>
</body>
</html>
<?php
} else {
  // Rediriger vers la page de connexion si les paramètres ligne et step n'ont pas été passés en paramètres dans l'URL
  header("Location: login.php");
  exit();
}
?>
