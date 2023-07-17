<?php
// Inclusion du fichier de connexion à la base de données
include('db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Machines</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: white;
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        select {
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-right: 10px;
        }

        input[type="submit"] {
            padding: 8px 15px;
            background-color: #4CAF50;
            border: none;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #4CAF50;
            color: #fff;
            font-weight: bold;
            text-align: left;
            padding: 8px;
        }

        td {
            padding: 8px;
        }

        .machine-row {
            background-color: #f9f9f9;
        }

        .machine-row-red {
            background-color: #ffe6e6;
            color: #cc0000;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
    <div style="background-color: #03234b;">
    <div style="float: right; margin: 10px 10px 20px 20px;">
        <img src="epu2qqrv.png" alt="ST">
    </div>
    <div style="background-color: #03234b; margin: 0; overflow-x: hidden; overflow-y: auto; padding: 0;">
        <h1 style="color: white; text-align: center;"><h1>Machines</h1></h1>
    </div>
    </div> <br>
        
        
        <?php
        // Récupération des machines distinctes du tableau 1
        $query = "SELECT DISTINCT alias FROM tabl";
        $result = mysqli_query($connexion, $query);

        // Création du tableau des machines
        $machines = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $machines[] = $row['alias'];
        }

        // Récupération des lignes distinctes du tableau 1
        $query = "SELECT DISTINCT ligne FROM tabl";
        $result = mysqli_query($connexion, $query);

        // Création du tableau des lignes
        $lignes = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $lignes[] = $row['ligne'];
        }

        // Récupération des steps distincts du tableau 1
        $query = "SELECT DISTINCT step FROM tabl";
        $result = mysqli_query($connexion, $query);

        // Création du tableau des steps
        $steps = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $steps[] = $row['step'];
        }
        ?>

        <form method="POST">
            <select name="ligne">
                <?php foreach ($lignes as $ligne): ?>
                    <option value="<?php echo $ligne; ?>"><?php echo $ligne; ?></option>
                <?php endforeach; ?>
            </select>

            <select name="step">
                <?php foreach ($steps as $step): ?>
                    <option value="<?php echo $step; ?>"><?php echo $step; ?></option>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Rechercher">
        </form>

        <?php
        // Vérification de la soumission du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $selectedLigne = $_POST['ligne'];
            $selectedStep = $_POST['step'];

            // Récupération des machines correspondant à la ligne et au step sélectionnés
            $query = "SELECT alias FROM tabl WHERE ligne = '$selectedLigne' AND step = '$selectedStep'";
            $result = mysqli_query($connexion, $query);

            // Vérification si des machines ont été trouvées
            if (mysqli_num_rows($result) > 0) {
                ?>
                <table>
                    <tr>
                        <th>Machine</th>
                        <th>Temps restant</th>
                    </tr>
                    <?php
                    // Parcours des machines
                    while ($row = mysqli_fetch_assoc($result)) {
                        $machine = $row['alias'];

                        // Recherche de la dernière date de mesure pour la machine en question dans le tableau 2
                        $query2 = "SELECT date_heur1 FROM pieces_supprimees WHERE alias = '$machine' ORDER BY date_heur1 DESC LIMIT 1";
                        $result2 = mysqli_query($connexion, $query2);

                        // Vérification de l'existence d'une mesure et calcul du temps restant
                        if (mysqli_num_rows($result2) > 0) {
                            $row2 = mysqli_fetch_assoc($result2);
                            $lastMeasurement = strtotime($row2['date_heur1']);
                            $currentTime = time();
                            $timeDiff = $lastMeasurement + 24 * 60 * 60 - $currentTime;

                            // Vérification si le temps restant est dépassé
                            if ($timeDiff <= 0) {
                                echo "<tr class='machine-row-red'>";
                                echo "<td>$machine</td>";
                                echo "<td>Besoin de mesurer</td>";
                            } else {
                                $hours = floor($timeDiff / 3600);
                                $minutes = floor(($timeDiff % 3600) / 60);
                                $seconds = $timeDiff % 60;

                                echo "<tr class='machine-row'>";
                                echo "<td>$machine</td>";
                                echo "<td>$hours h $minutes min $seconds s</td>";
                            }
                        } else {
                            echo "<tr class='machine-row-red'>";
                            echo "<td>$machine</td>";
                            echo "<td>Besoin de mesurer</td>";
                        }

                        echo "</tr>";
                    }
                    ?>
                </table>
                <?php
            } else {
                echo "<p>Aucune machine trouvée pour la ligne $selectedLigne et le step $selectedStep.</p>";
            }
        }
        ?>

    </div>
</body>
</html>

<?php
// Fermeture de la connexion à la base de données
mysqli_close($connexion);
?>
