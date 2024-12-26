<?php
    include('header.php');
    include('config.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Annie+Use+Your+Telescope&family=Barriecito&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
<section class="connexion">
    <div class="left-block">
        <h1 class="welcome-message">Bienvenue sur l’ENT de Gustave Eiffel</h1>
    </div>

    <div class="right-block">

        <h1>Se connecter</h1>
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
        
        <label for="password">Mot de passe :</label><br>
        <div class="password-container">
            <input type="password" id="password" name="password" required>
            <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
        </div>
        <br><br>
        
        <input type="submit" class="connecter" value="Se connecter">
    </form>

    </div>
</section>

<script src="script.js"></script>
</body>
</html>



