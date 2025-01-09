<?php
include('header.php');
include('nav.php');

$message_envoye = false; // Pour afficher un message de confirmation
$erreurs = []; // Pour gérer les erreurs

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $expediteur_id = $_POST['expediteur_id']; 
    $destinataire_id = $_POST['destinataire_id']; 
    $objet = htmlspecialchars(trim($_POST['objet'])); // Nettoyage des données
    $message = htmlspecialchars(trim($_POST['message']));

    // Validation des champs
    if (empty($destinataire_id)) {
        $erreurs[] = "Veuillez sélectionner un destinataire.";
    }
    if (empty($objet)) {
        $erreurs[] = "L'objet du message est obligatoire.";
    }
    if (empty($message)) {
        $erreurs[] = "Le contenu du message est obligatoire.";
    }

    // Si pas d'erreurs, on insère dans la base de données
    if (empty($erreurs)) {
        $query = "INSERT INTO messages (expediteur_id, destinataire_id, objet, message, date_envoi) 
                  VALUES (:expediteur_id, :destinataire_id, :objet, :message, NOW())";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'expediteur_id' => $expediteur_id,
            'destinataire_id' => $destinataire_id,
            'objet' => $objet,
            'message' => $message
        ]);
        $message_envoye = true;
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENT | Nouveau message</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <section class="page-messagerie">
        <h1>Messagerie</h1>
        <div class="container-messagerie">

            <div class="sidebar">
                <a href="messagerie.php">Boîte de réception</a>
                <a href="envoi_msg.php" class="active">Nouveau message</a>
                <a href="messages_envoyes.php"><i class="fas fa-paper-plane"></i> Envoyés</a>
                <a href="messages_archives.php"><i class="fas fa-archive"></i> Archivés</a>
            </div>

            <div class="message-content">
                <?php if ($message_envoye): ?>
                    <div class="success-message">Votre message a été envoyé avec succès !</div>
                    <script>
                        setTimeout(function() {
                            window.location.href = 'messagerie.php';
                        }, 1500); // Redirection après 2 secondes
                    </script>
                <?php endif; ?>

                <?php if (!empty($erreurs)): ?>
                    <div class="error-message">
                        <ul>
                            <?php foreach ($erreurs as $erreur): ?>
                                <li><?= $erreur ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="envoi_msg.php" method="post" class="form-nv-msg">
                    <input type="hidden" name="expediteur_id" value="<?= htmlspecialchars($_SESSION['id']) ?>">
                    
                    <div class="form-group">
                        <label for="destinataire">Destinataire :</label>
                        <div style="position: relative;">
                            <input 
                                type="text" 
                                id="destinataire-input" 
                                placeholder="Tapez un prénom ou un nom..." 
                                autocomplete="off"
                                required
                            >
                            <input type="hidden" name="destinataire_id" id="destinataire-id">
                            <ul id="suggestions-list" class="suggestions-list hidden"></ul>
                        </div>
                    </div>

                    <!-- <span>ou</span>
                    <div>
                    <select name="destinataire_id" id="destinataire" required>
                        <option value="">-- Sélectionnez un destinataire --</option>
                        <?php
                        /* $query = "SELECT id, prenom, nom FROM utilisateurs WHERE id != :expediteur_id";
                        $stmt = $db->prepare($query);
                        $stmt->execute(['expediteur_id' => $_SESSION['id']]);
                        $destinataires = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($destinataires as $destinataire) {
                            echo "<option value='" . htmlspecialchars($destinataire['id']) . "'>" 
                                . htmlspecialchars($destinataire['prenom']) . " " 
                                . htmlspecialchars($destinataire['nom']) . "</option>";
                        } */
                        ?>
                    </select>
                    </div> <br><br> -->

                    <br>
                    <label for="objet">Objet : </label> 
                    <input type="text" name="objet" id="objet" placeholder="Sujet du message" required> <br><br>

                    <label for="message">Message</label>
                    <textarea name="message" id="message" cols="30" rows="10" placeholder="Écrivez votre message ici..." required></textarea> <br><br>

                    <button type="submit" class="btn-submit">Envoyer</button>
                </form>

            </div>
        </div>
    </section>
</body>
</html>
