<?php
// Connexion à la base de données
include "db.php";

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données soumises
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Vérification si tous les champs ont été remplis
    if (!empty($username) && !empty($password) && !empty($email)) {
        // Vérification si l'utilisateur existe déjà
        $select_query = "SELECT * FROM user_spc WHERE username='$username'";
        $result = mysqli_query($connexion, $select_query);
        if (mysqli_num_rows($result) > 0) {
            echo "Cet utilisateur existe déjà.";
        } else {
            // Insertion des données dans la table "users"
            $insert_query = "INSERT INTO user_spc (username, password, email) VALUES ('$username', '$password', '$email')";
            if (mysqli_query($connexion, $insert_query)) {
                echo "Inscription réussie.";
            } else {
                echo "Erreur lors de l'inscription : " . mysqli_error($connexion);
            }
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}

// Fermeture de la connexion
mysqli_close($connexion);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
</head>
<body>
    <h2>Inscription</h2>
    <form method="post">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username"><br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password"><br>

        <label for="email">Adresse e-mail :</label>
        <input type="email" name="email" id="email"><br>

        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>
