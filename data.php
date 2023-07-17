<div style="background-color: #03234b;">
    <div style="float: right; margin: 10px 10px 20px 20px;">
        <img src="epu2qqrv.png" alt="ST">
    </div>
    <div style="background-color: #03234b; margin: 0; overflow-x: hidden; overflow-y: auto; padding: 0;">
        <h1 style="color: white; text-align: center;">SPC SYSTEM : DATA Sample</h1>
    </div>
    </div>
<form method="get">
  <div class="form-row">
    <label>Afficher</label>
    <input type="number" name="limit" min="1" max="100" value="20">
    <label>lignes</label>

    <label>Date:</label>
    <input type="date" name="date_debut">
    <label>et</label>
    <input type="date" name="date_fin">
  </div>
  <div class="form-row">
    <label>Ligne:</label>
    <select name="ligne">
      <option value="">Toutes</option>
      <?php
        include "db.php";
        // Récupérer la liste des lignes distinctes de la table
        $ligne_resultat = mysqli_query($connexion, "SELECT DISTINCT ligne FROM pieces_supprimees ORDER BY ligne ASC");
        while ($ligne = mysqli_fetch_array($ligne_resultat)) {
            echo "<option value=\"".$ligne['ligne']."\">".$ligne['ligne']."</option>";
        }
      ?>
    </select>

    <label>Step:</label>
    <select name="step">
      <option value="">Toutes</option>
      <?php
        // Récupérer la liste des steps distincts de la table
        $step_resultat = mysqli_query($connexion, "SELECT DISTINCT step FROM pieces_supprimees ORDER BY step ASC");
        while ($step = mysqli_fetch_array($step_resultat)) {
            echo "<option value=\"".$step['step']."\">".$step['step']."</option>";
        }
      ?>
    </select>
  </div>
  <div class="form-row">
    <label>Machine:</label>
    <select name="alias">
      <option value="">Tous</option>
      <?php
        // Récupérer la liste des alias distincts de la table
        $alias_resultat = mysqli_query($connexion, "SELECT DISTINCT alias FROM pieces_supprimees ORDER BY alias ASC");
        while ($alias_ligne = mysqli_fetch_array($alias_resultat)) {
            echo "<option value=\"".$alias_ligne['alias']."\">".$alias_ligne['alias']."</option>";
        }
      ?>
    </select>
 
    <label>Lot ID:</label>
    <input type="text" name="lot_id">
  </div>
  <div class="form-row">
    <input type="submit" value="Afficher">
  </div>
</form>


<?php
// Connexion à la base de données
include "db.php";

// Récupérer le nombre de lignes à afficher à partir des données envoyées par le formulaire
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

// Récupérer les dates de début et de fin à partir des données envoyées par le formulaire
$date_debut = isset($_GET['date_debut']) ? $_GET['date_debut'] : '';
$date_fin = isset($_GET['date_fin']) ? $_GET['date_fin'] : '';

// Ajouter une condition à la requête SQL pour filtrer les résultats en fonction des dates spécifiées
$where_clause = '';
if (!empty($date_debut) && !empty($date_fin)) {
    $where_clause = "WHERE date_heur1 BETWEEN '$date_debut 00:00:00' AND '$date_fin 23:59:59'";
}

// Récupérer l'alias à partir des données envoyées par le formulaire
$alias = isset($_GET['alias']) ? $_GET['alias'] : '';

// Ajouter une condition à la requête SQL pour filtrer les résultats en fonction de l'alias spécifié
if (!empty($alias)) {
    if (!empty($where_clause)) {
        $where_clause .= " AND alias='$alias'";
    } else {
        $where_clause = "WHERE alias='$alias'";
    }
}

// Récupérer la ligne à partir des données envoyées par le formulaire
$ligne = isset($_GET['ligne']) ? $_GET['ligne'] : '';

// Ajouter une condition à la requête SQL pour filtrer les résultats en fonction de la ligne spécifiée
if (!empty($ligne)) {
    if (!empty($where_clause)) {
        $where_clause .= " AND ligne='$ligne'";
    } else {
        $where_clause = "WHERE ligne='$ligne'";
    }
}

// Récupérer l'étape (step) à partir des données envoyées par le formulaire
$step = isset($_GET['step']) ? $_GET['step'] : '';

// Ajouter une condition à la requête SQL pour filtrer les résultats en fonction de l'étape spécifiée
if (!empty($step)) {
    if (!empty($where_clause)) {
        $where_clause .= " AND step='$step'";
    } else {
        $where_clause = "WHERE step='$step'";
    }
}

// Récupérer l'ID du lot à partir des données envoyées par le formulaire
$lot_id = isset($_GET['lot_id']) ? $_GET['lot_id'] : '';

// Ajouter une condition à la requête SQL pour filtrer les résultats en fonction de l'ID du lot spécifié
if (!empty($lot_id)) {
    if (!empty($where_clause)) {
        $where_clause .= " AND lot_id='$lot_id'";
    } else {
        $where_clause = "WHERE lot_id='$lot_id'";
    }
}

$resultat = mysqli_query($connexion, "SELECT * FROM pieces_supprimees $where_clause ORDER BY date_heur1 DESC LIMIT $limit");

// Vérifier si la requête a retourné des résultats
if (mysqli_num_rows($resultat) > 0) {
    // Stocker les résultats dans un tableau
    $resultats_array = array();
    while ($ligne = mysqli_fetch_array($resultat)) {
        $resultats_array[] = $ligne;
    }

    // Afficher les résultats dans une table HTML en inversant l'affichage
    echo '<table>';
    echo "<caption>ALL DATA</caption>";
    echo "<thead><tr><th>date/heure(IN)</th><th>Lot ID</th><th>Ligne</th><th>Step</th><th>Alias</th><th>RTP</th><th>Event</th><th>Emplacement</th><th>Résultat</th><th>name</th><th>date\heure (OUT)</th></tr></thead>";
    echo "<tbody>";

    $count = 0;
    foreach ($resultats_array as $ligne) {
        if (++$count > $limit) {
            break;
        }
        echo "<tr class='" . ($ligne['confirmation'] == 'In control' ? 'ok' : 'ko') . "'>";
        echo "<td>".$ligne['date_heur']."</td><td>".$ligne['lot_id']."</td><td>".$ligne['ligne']."</td><td>".$ligne['step']."</td><td>".$ligne['alias']."</td><td>".$ligne['rtp']."</td><td>".$ligne['event']."</td><td>".$ligne['emplacement']."</td><td>".$ligne['confirmation']."</td><td>".$ligne['username']."</td><td>".$ligne['date_heur1']."</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "Aucun résultat trouvé.";
}

// Fermer la connexion avec la base de données
mysqli_close($connexion);
?>

<style>
table {
  border-collapse: separate;
  border-spacing: 0px 5px;
  width: 50%;
  margin: auto;
}

th, td {
  text-align: left;
  padding: 8px;
  font-family: Arial, sans-serif;
  font-size: 14px;
}

th {
  background-color: #333;
  color: #fff;
  font-size: 16px;
}

tr.ok {
  background-color: lightgreen;
}

tr.ko {
  background-color: #FF4F4B;
}

form {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
  background-color: #f2f2f2;
  border-radius: 5px;
}

.form-row {
  display: flex;
  flex-direction: row;
  align-items: center;
  margin: 10px 0;
}

.form-row label {
  margin-right: 10px;
}

input[type="number"],
input[type="date"],
input[type="text"],
select {
  margin: 0 10px;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #45a049;
}

</style>
