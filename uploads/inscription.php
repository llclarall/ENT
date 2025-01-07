<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h2>Inscription</h2>


    <?php
// Exemple lors de la création d'un utilisateur
if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Hacher le mot de passe avant de le stocker
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertion dans la base de données
    $requete = "INSERT INTO utilisateurs (login, mdp) VALUES (:login, :mdp)";
    $stmt = $db->prepare($requete);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':mdp', $hashedPassword);
    $stmt->execute();

    echo "Utilisateur créé avec succès.";
}
?>


    <form action="traite_inscription.php" method="post" onsubmit="return verifierFormulaire()">
        <label for="login">Login (mail) :</label>
        <input type="text" id="login" name="login" required><br><br>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="prenom">Prenom :</label>
        <input type="text" id="prenom" name="prenom" required><br><br>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Confirmer mot de passe :</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <input type="submit" value="S'inscrire">
    </form>

    <script>
        function verifierFormulaire() {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                alert("Les mots de passe ne correspondent pas.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
