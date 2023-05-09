<!DOCTYPE html>
<html>
<head>
	<title>input data sample</title>
</head>
<body>
	<h1>SPC SYSTEM</h1>
	<form method="post" action="traitement.php">
		<label for="lot_id">LOT_ID :</label>
		<input type="text" name="lot_id" id="lot_id" required><br><br>
		
		<label for="alias">Alias :</label>
		<select id="alias" name="alias">
			<?php
			// Connexion à la base de données
            include "db.php";

			// Récupération des choix d'alias depuis la base de données
			$sql = "SELECT alias FROM tabl";
			$result = mysqli_query($connexion, $sql);

			// Affichage des options dans la liste déroulante
			while($row = mysqli_fetch_assoc($result)) {
				echo "<option value='" . $row['alias'] . "'>" . $row['alias'] . "</option>";
			}

			// Fermeture de la connexion
			mysqli_close($connexion);
			?>
		</select><br><br>

<br><br>
		<label for="rtp">RTP :</label><br>
		<input type="radio" name="rtp" value="oui" id="oui" required><label for="oui">Oui</label><br>
		<input type="radio" name="rtp" value="non" id="non" required><label for="non">Non</label><br><br>
		<label for="emplacement">Emplacement :</label>
		<input type="text" name="emplacement" id="emplacement" required><br><br>
		<input type="submit" name="submit" value="Envoyer">
	</form>
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
  font-size: 36px;
  margin: 20px 0;
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
