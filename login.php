<?php
// Inclure le fichier de connexion à la base de données
require_once('db.php');

// Requête SQL pour récupérer les valeurs distinctes de ligne et step depuis la table pieces_supprimees
$query = "SELECT DISTINCT ligne, step FROM pieces_supprimees";
$result = mysqli_query($connexion, $query);

$lignes = array();
$steps = array();

while ($row = mysqli_fetch_assoc($result)) {
  $lignes[] = $row['ligne'];
  $steps[] = $row['step'];
}

// Vérifier si le formulaire a été soumis
if(isset($_POST['ligne']) && isset($_POST['step'])) {
  $ligne = $_POST['ligne'];
  $step = $_POST['step'];

  // Rediriger vers la page results_m.php en passant la ligne et le step en paramètres dans l'URL
  header("Location: results_m.php?ligne=$ligne&step=$step");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Check Statut of Machine</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 16px;
      background-color: #f2f2f2;
    }
    h1 {
      color: #333;
    }
    label {
      display: block;
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 10px;
    }
    select {
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
      width: 20em; /* set a width of 20 em units */
      box-sizing: border-box;
    }
    button[type="submit"] {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
  </style>
</head>
<body>
   <div style="background-color: #03234b;">
    <div style="float: right; margin: 10px 10px 20px 20px;">
        <img src="epu2qqrv.png" alt="ST">
    </div>
    <div style="background-color: #03234b; margin: 0; overflow-x: hidden; overflow-y: auto; padding: 0;">
        <h1 style="color: white; text-align: center;">SPC SYSTEM : Check Statut of Machine</h1>
    </div>
</div>
  
  <form method="post">
    <label for="ligne">Ligne :</label>
    <select name="ligne">
      <?php foreach ($lignes as $ligne) { ?>
        <option value="<?php echo $ligne; ?>"><?php echo $ligne; ?></option>
      <?php } ?>
    </select>

    <label for="step">Step :</label>
    <select name="step">
      <?php foreach ($steps as $step) { ?>
        <option value="<?php echo $step; ?>"><?php echo $step; ?></option>
      <?php } ?>
    </select>

    <button type="submit">Rechercher</button>
  </form>
</body>
</html>
