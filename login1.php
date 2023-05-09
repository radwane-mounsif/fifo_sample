<?php
session_start();
require_once('db.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($connexion,$_POST['username']);
    $password = mysqli_real_escape_string($connexion,$_POST['password']);

    $sql = "SELECT * FROM users WHERE username = '$username' and password = '$password'";
    $result = mysqli_query($connexion,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if($count == 1) {
        $_SESSION['login_user'] = $username;
        header("location: affichage.php");
    }else {
        $error = "Le nom d'utilisateur ou le mot de passe est incorrect.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <form action="" method="post">
        <label>Nom d'utilisateur :</label>
        <input type="text" name="username"><br><br>
        <label>Mot de passe :</label>
        <input type="password" name="password"><br><br>
        <input type="submit" value="Se connecter">
    </form>
    <br>
    <a href="register.php">S'inscrire</a>
    <?php
        if(isset($error)) {
            echo '<br><br><span style="color:red">' . $error . '</span>';
        }
    ?>
</body>
</html>
Page d'inscription (register.php)

<?php
session_start();
require_once('db.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($connexion,$_POST['username']);
    $password = mysqli_real_escape_string($connexion,$_POST['password']);

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connexion,$sql);
    $count = mysqli_num_rows($result);

    if($count == 0) {
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        mysqli_query($connexion,$sql);
        $_SESSION['login_user'] = $username;
        header("location: affichage.php");
    }else {
        $error = "Ce nom d'utilisateur est déjà utilisé.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
</head>
<body>
    <h2>Inscription</h2>
    <form action="" method="post">
        <label>Nom d'utilisateur :</label>
        <input type="text" name="username"><br><br>
        <label>Mot de passe :</label>
        <input type="password" name="password"><br><br>
        <input type="submit" value="S'inscrire">
    </form>
    <br>
    <a href="login.php">Se connecter</a>
    <?php
        if(isset($error)) {
            echo '<br><br><span style="color:red">' . $error . '</span>';
        }
    ?>
</body>
</html>