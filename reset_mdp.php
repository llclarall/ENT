<?php
include('config.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Vérifiez que le token est valide
    $requete = $db->prepare("SELECT id FROM utilisateurs WHERE reset_token = :token");
    $requete->execute(['token' => $token]);
    $user = $requete->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Afficher le formulaire de réinitialisation de mot de passe
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_password = $_POST['password'];
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Mettre à jour le mot de passe dans la base de données
            $requete = $db->prepare("UPDATE utilisateurs SET mdp = :mdp, reset_token = NULL WHERE reset_token = :token");
            $requete->execute(['mdp' => $hashed_password, 'token' => $token]);

            echo "<script>alert('Votre mot de passe a été réinitialisé avec succès.'); window.location.href = 'index.php';</script>";

        } else {
            ?>

            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Réinitialision mot de passe</title>
            </head>
            <body>
                
            </body>
            </html>
            <div class="page-mdp-oublie">
            <h1>Réinitialisez votre mot de passe</h1>
                <form method="POST" class="mdp-oublie">
                    <label for="password">Nouveau mot de passe :</label>
                    <input type="password" name="password" id="password" required>
                    <br><br>
                    <button type="submit">Réinitialiser le mot de passe</button>
                </form>
            </div>
            <?php
        }
    } else {
        echo "Le lien de réinitialisation est invalide ou a expiré.";
    }
} else {
    echo "Token manquant.";
}
?>
