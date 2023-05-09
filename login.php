<?php
// Inclure le fichier de connexion à la base de données
require_once('db.php');

// Vérifier si le formulaire a été soumis
if(isset($_POST['nom_machine'])) {
  // Récupérer le nom de la machine depuis le formulaire
  $nom_machine = $_POST['nom_machine'];

  // Requête SQL pour vérifier si le nom de machine existe dans la colonne alias de la table tabl
  $sql = "SELECT * FROM tabl WHERE alias='$nom_machine'";

  // Exécuter la requête
  $result = mysqli_query($connexion, $sql);

  // Vérifier si la requête a renvoyé des résultats
  if(mysqli_num_rows($result) > 0) {
    // Rediriger vers la page results_m.php en passant le nom de la machine en paramètre dans l'URL
    header("Location: results_m.php?nom_machine=$nom_machine");
    exit();
  } else {
    // Afficher un message d'erreur si le nom de machine n'existe pas
    echo "Le nom de machine '$nom_machine' n'existe pas dans la base de données.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>login</title>
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
    input[type="text"] {
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
  <h1>login</h1>
  <form method="post">
    <label for="nom_machine">Alias :</label>
    <input type="text" name="nom_machine" required>
    <button type="submit">log in</button>
  </form>
</body>
</html>
