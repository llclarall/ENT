<?php
include('config.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$mail = $_POST['mail'];

$requete = $db->prepare("SELECT id, mail FROM utilisateurs WHERE mail = :mail");
$requete->execute(['mail' => $mail]);
$user = $requete->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Générer un token de réinitialisation unique
    $token = bin2hex(random_bytes(50)); 

    // Enregistrer ce token avec le mail dans la base de données
    $requete = $db->prepare("UPDATE utilisateurs SET reset_token = :token WHERE mail = :mail");
    $requete->execute(['token' => $token, 'mail' => $mail]);

    // lien de réinitialisation
    $reset_link = "http://ent.moubarak.butmmi.o2switch.site/reset_mdp.php?token=$token";

    // Envoye le mail à l'utilisateur avec le lien de réinitialisation
    $message = "Cliquez sur ce lien pour réinitialiser votre mot de passe: <br><br> <a href='$reset_link'>$reset_link</a>";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    mail($mail, 'Réinitialisation de votre mot de passe', $message, $headers);

    echo "<script>alert('Un lien de réinitialisation a été envoyé à votre mail.');
    window.location.href = 'index.php';</script>";
} else {
    echo "<script>alert('Cet mail n\'existe pas dans notre base de données.');
    window.location.href = 'mdp_oublie.php';</script>";
}
} else {
// Afficher le formulaire de demande de réinitialisation
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
</body>
</html>

<div class="page-mdp-oublie">
    <h1>Mot de passe oublié</h1>
    <form method="POST" class="mdp-oublie">
        <label for="mail">Entrez votre mail :</label>
        <input type="mail" name="mail" id="mail" required>
        <button type="submit">Envoyer le lien de réinitialisation</button>
    </form>
</div>

<?php
}
?>
