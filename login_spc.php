<?php
include "db.php";

session_start();

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    header("Location: affichage.php?session_id=".$_SESSION['user_id']);
    exit();
}


// Vérifier si les informations de connexion ont été envoyées
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérifier si l'utilisateur existe dans la base de données
    $result = mysqli_query($connexion, "SELECT id FROM user_spc WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];
        header("Location: affichage.php?session_id=".$_SESSION['user_id']);
        exit();
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect";
    }
}
?>
<!-- Formulaire de connexion -->
<form action="login_spc.php" method="post">
    <input type="text" name="username" placeholder="Nom d'utilisateur">
    <input type="password" name="password" placeholder="Mot de passe">
    <button type="submit">Se connecter</button>
</form>
<p>
<center>ce programme en phase de développement vous pouvez utiliser le mot <strong>"admin"</strong> pour le nom d'utilisateur et le mot de passe </center>
</p>
<style>
form {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin: 20px;
}

input[type="text"], input[type="password"] {
  padding: 10px;
  margin: 10px;
  border: none;
  border-radius: 5px;
  box-shadow: 0px 0px 5px #888888;
  width: 300px;
}

button[type="submit"] {
  padding: 10px;
  margin: 10px;
  border: none;
  border-radius: 5px;
  background-color: #4CAF50;
  color: white;
  font-weight: bold;
  cursor: pointer;
  box-shadow: 0px 0px 5px #888888;
  width: 200px;
}

button[type="submit"]:hover {
  background-color: #3e8e41;
}

.error-message {
  color: red;
  font-weight: bold;
  margin: 10px;
}



</style>