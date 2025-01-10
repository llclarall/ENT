<?php
    include('config.php');

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENT | Connexion</title>
    
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet" />
</head>
<body>
<section class="connexion">
    <div class="left-section">
        <div class="left-block">
            <img src="images/logo.png" alt="">
            <h1 class="welcome-message">Bienvenue sur l’ENT de Gustave Eiffel</h1>
        </div>
    </div>

    <div class="right-section">

        <h2>Se connecter</h2>
        <?php
    // Vérifie s'il y a une erreur dans l'URL
    if (isset($_GET['erreur']) && $_GET['erreur'] == 'login') {
        echo "<p style='color:red;'>Identifiant ou mot de passe incorrect.</p>";
    }
    ?>

    <form class="login-form" action="traite_co.php" method="post">
        <label for="login" class="form-label">Nom d'utilisateur :</label>
        <input type="text" id="login" name="login" required>
        <br><br>
        
        <label for="password">Mot de passe :</label>
        <div class="password-container">
            <input type="password" id="password" name="password" required>
            <span class="toggle-password" onclick="togglePassword('password', this)"><i class="fa-regular fa-eye-slash"></i></span>
        </div>
        <br><br>

        <input type="submit" class="connecter" value="Se connecter">

        <a href="mdp_oublie.php" class="forgot-password">Mot de passe oublié ?</a>
    </form>

    </div>
</section>

<script src="script.js"></script>
</body>
</html>



