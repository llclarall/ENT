<?php 
require 'config.php';
include 'header.php';
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>


<section class="">

<h2>Inscription</h2>

<form action="traite_inscription.php" method="post" onsubmit="return verifierFormulaire()">
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required><br>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br>

        <label for="login">Login :</label>
        <input type="text" id="login" name="login" required><br>

        <label for="password">Mot de passe :</label><br>
        <div class="password-container">
            <input type="password" id="password" name="password" required>
            <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
        </div>  

        <label for="confirm_password">Confirmer mot de passe :</label><br>
        <div class="password-container">
            <input type="password" id="confirm_password" name="confirm_password" required>
            <span class="toggle-password" onclick="togglePassword('confirm_password', this)">👁️</span>
        </div>
        <br><br>

        <input type="submit" value="S'inscrire">
        <span>Tous les champs sont obligatoires</span>
    </form>

</section>

    <script src="script.js"></script>
</body>
</html>
