<?php
// Connexion à la base de données
include "db.php";



// Vérification si le formulaire a été soumis avec la date de recherche
if (isset($_POST['date_recherche'])) {
    // Date de recherche choisie par l'utilisateur
    $dateRecherche = $_POST['date_recherche'];

    // Requête pour récupérer les échantillons dans la période spécifiée
    $query = "SELECT * FROM pieces_supprimees WHERE DATE(date_heur) = '$dateRecherche' ORDER BY date_heur ASC";
    $result = $connexion->query($query);

    // Variables pour le calcul de l'indice FIFO
    $totalEchantillons = 0;
    $respectFifo = 0;
    $previousRTP = '';

    // Parcours des échantillons
    while ($row = $result->fetch_assoc()) {
        $totalEchantillons++;

        // Vérification de l'ordre de date/heure pour chaque échantillon
        if ($row['rtp'] == 'OUI' && $previousRTP == 'OUI') {
            $respectFifo = 0;
            break;
        }

        // Vérification de la date de chaque échantillon par rapport aux échantillons précédents
        $queryPrevious = "SELECT * FROM pieces_supprimees WHERE DATE(date_heur) = '$dateRecherche' AND date_heur < '{$row['date_heur']}'";
        $resultPrevious = $connexion->query($queryPrevious);

        while ($previousRow = $resultPrevious->fetch_assoc()) {
            if ($row['rtp'] == 'OUI' && $previousRow['rtp'] == 'OUI') {
                $respectFifo = 0;
                break 2;
            }

            if ($row['rtp'] == 'NON' && $previousRow['rtp'] == 'NON') {
                $respectFifo = 0;
                break 2;
            }
        }

        $previousRTP = $row['rtp'];
        $respectFifo = 1;
    }

    // Calcul de l'indice FIFO
    $indiceFifo = $respectFifo / $totalEchantillons;

    // Enregistrement des résultats dans la base de données
    $queryInsert = "INSERT INTO fifo_stats (date_recherche, fifo_indice) VALUES ('$dateRecherche', $indiceFifo)";
    $connexion->query($queryInsert);

    // Affichage du résultat
    echo "Indice FIFO pour le $dateRecherche : " . $indiceFifo;
} else {
    // Affichage du formulaire de recherche
    echo '
        <form method="POST" action="fifo.php">
            <label>Date de recherche:</label>
            <input type="date" name="date_recherche" required>
            <input type="submit" value="Calculer FIFO">
        </form>
    ';
}

// Fermeture de la connexion à la base de données
$connexion->close();
?>

<!-- Inclure la bibliothèque Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    // Chargement de la bibliothèque Google Charts
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    // Fonction pour dessiner le graphique
    function drawChart() {
        // Requête pour récupérer les statistiques de FIFO à partir de la base de données
        <?php
        $queryStats = "SELECT date_recherche, fifo_indice FROM fifo_stats";
        $resultStats = $connexion->query($queryStats);
        ?>

        // Création d'un tableau de données pour le graphique
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Date de recherche');
        data.addColumn('number', 'Indice FIFO');

        // Remplissage des données du tableau
        <?php
        while ($rowStats = $resultStats->fetch_assoc()) {
            echo "data.addRow(['" . $rowStats['date_recherche'] . "', " . $rowStats['fifo_indice'] . "]);";
        }
        ?>

        // Options du graphique
        var options = {
            title: 'Statistiques FIFO',
            curveType: 'function',
            legend: { position: 'bottom' }
        };

        // Création du graphique
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>

<!-- Div pour afficher le graphique -->
<div id="chart_div" style="width: 800px; height: 400px;"></div>
