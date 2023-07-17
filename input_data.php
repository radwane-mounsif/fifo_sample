<html>
<head>
    <title>input data sample</title>
</head>
<body>
<div style="background-color: #03234b;">
<div style="float: right; margin: 10px 10px 20px 20px; ">
    <img src="epu2qqrv.png" alt="ST">
</div>
<div style="background-color: #03234b; margin: 0; overflow-x: hidden; overflow-y: auto; padding: 0;">
    <h1 style="color: white; text-align: center;">SPC SYSTEM : Sample data</h1>
</div>
</div>
    <form method="post" action="traitement.php">
        <label for="lot_id">LOT_ID :</label>
        <input type="text" name="lot_id" id="lot_id" required><br><br>

        <label for="ligne">Line :</label>
        <select id="ligne" name="ligne" onchange="updateAliasOptions()">
            <?php
            // Connexion à la base de données
            include "db.php";
 
            // Récupération des choix de ligne depuis la base de données
            $sql = "SELECT ligne FROM ligne_data";
            $result = mysqli_query($connexion, $sql);
 
            // Affichage des options dans la liste déroulante
            while($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['ligne'] . "'>" . $row['ligne'] . "</option>";
            }
 
            // Fermeture de la connexion
            mysqli_close($connexion);
            ?>
        </select><br><br>
        <label for="step">Step Process :</label>
        <select id="step" name="step" onchange="updateAliasOptions(); updateNonRtpOptions()">
            <?php
            // Connexion à la base de données
            include "db.php";
 
            // Récupération des choix de step depuis la base de données
            $sql = "SELECT step FROM ligne_data";
            $result = mysqli_query($connexion, $sql);
 
            // Affichage des options dans la liste déroulante
            while($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['step'] . "'>" . $row['step'] . "</option>";
            }
 
            // Fermeture de la connexion
            mysqli_close($connexion);
            ?>
        </select><br><br>
        <label for="alias">Machine :</label>
        <select id="alias" name="alias">
            <!-- Options des alias mises à jour dynamiquement -->
        </select><br><br>
 
        <label for="rtp">RTP :</label><br>
        <input type="radio" name="rtp" value="oui" id="oui" required onchange="toggleRTPOptions()"><label for="oui">YES</label>
        <input type="radio" name="rtp" value="non" id="non" required onchange="toggleRTPOptions()"><label for="non">NO</label><br>
 
        <div id="rtpOptions" style="display: none;">
            <label for="rtpType">Type of RTP :</label>
            <select id="rtpType" name="rtpType">
                <option value="PM">PM</option>
                <option value="SETUP">SETUP</option>
                <option value="UDOWN">UDOWN</option>
            </select><br><br>
        </div>
 
        <div id="nonRtpOptions" style="display: none;">
            <label for="nonRtpType">Event :</label>
            <select id="nonRtpType" name="nonRtpType">
                <!-- Options des nonRtpType mises à jour dynamiquement -->
            </select><br><br>
        </div>
 
        <label for="emplacement">Location :</label>
        <input type="text" name="emplacement" id="emplacement" required><br><br>
        <input type="submit" name="submit" value="Envoyer">
    </form>
 
    <script>
        function toggleRTPOptions() {
            var rtpOptionDiv = document.getElementById("rtpOptions");
            var nonRtpOptionDiv = document.getElementById("nonRtpOptions");
            var rtpRadioYes = document.getElementById("oui");
 
            if (rtpRadioYes.checked) {
                rtpOptionDiv.style.display = "block";
                nonRtpOptionDiv.style.display = "none";
            } else {
                rtpOptionDiv.style.display = "none";
                nonRtpOptionDiv.style.display = "block";
            }
        }

        function updateAliasOptions() {
            var ligne = document.getElementById("ligne").value;
            var step = document.getElementById("step").value;

            // Effectuez une requête AJAX pour obtenir les alias correspondants
            // et mettez à jour les options de la liste déroulante des alias
            // en fonction des résultats de la requête.
            // Vous pouvez utiliser la méthode fetch() ou XMLHttpRequest pour cela.

            // Exemple avec fetch() :
            fetch('get_alias.php?ligne=' + ligne + '&step=' + step)
                .then(response => response.json())
                .then(data => {
                    var aliasSelect = document.getElementById("alias");
                    aliasSelect.innerHTML = ""; // Supprime toutes les options actuelles

                    // Ajoute les nouvelles options en fonction des données reçues
                    data.forEach(alias => {
                        var option = document.createElement("option");
                        option.value = alias;
                        option.text = alias;
                        aliasSelect.appendChild(option);
                    });
                })
                .catch(error => console.log(error));
        }

        function updateNonRtpOptions() {
            var step = document.getElementById("step").value;

            // Effectuez une requête AJAX pour obtenir les nonRtpOptions correspondants
            // et mettez à jour les options de la liste déroulante des nonRtpOptions
            // en fonction des résultats de la requête.
            // Vous pouvez utiliser la méthode fetch() ou XMLHttpRequest pour cela.

            // Exemple avec fetch() :
            fetch('get_nonrtpoptions.php?step=' + step)
                .then(response => response.json())
                .then(data => {
                    var nonRtpTypeSelect = document.getElementById("nonRtpType");
                    nonRtpTypeSelect.innerHTML = ""; // Supprime toutes les options actuelles

                    // Ajoute les nouvelles options en fonction des données reçues
                    data.forEach(nonRtpOption => {
                        var option = document.createElement("option");
                        option.value = nonRtpOption;
                        option.text = nonRtpOption;
                        nonRtpTypeSelect.appendChild(option);
                    });
                })
                .catch(error => console.log(error));
        }
    </script>
</body>
<style>
/* Set body margin and font */
body {
    margin: 0;
    font-family: Arial, sans-serif;
}

/* Style the page title */
h1 {
    text-align: center;
    font-size: 26px;
    margin: 19px 0;
}

/* Style the form */
form {
    width: 50%;
    margin: 0 auto;
    border: 1px solid #ccc;
    padding: 20px;
    box-sizing: border-box;
}

/* Style the form fields */
label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

input[type="text"],
select {
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 20px;
}

input[type="radio"] {
    display: inline-block;
    margin-right: 10px;
}

input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    float: right;
}
div {
    color: #03234b;
    margin: 0;
    overflow-x: hidden;
    overflow-y: auto;
    padding: 0;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

/* Add media queries for responsive design */
@media screen and (max-width: 600px) {
    form {
        width: 100%;
    }
}
</style>
</html>