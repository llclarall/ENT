<?php
include('config.php');

// Vérifier si la requête est bien en POST et que le fichier a été envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fk_user = $_POST['fk_user'];
    $fk_rendu = $_POST['fk_rendu'];

    // Vérification des erreurs d'upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'Erreur de téléchargement du fichier, code: ' . $file['error']]);
        return;
    }

    // Définir le dossier d'upload et le chemin du fichier
    $uploadDir = 'uploads/';
    $filePath = $uploadDir . basename($file['name']);

    // Vérifier si le dossier existe, sinon, le créer
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
        echo json_encode(['success' => false, 'message' => 'Le dossier d\'upload a été créé.']);
    }

    // Déplacer le fichier vers le dossier d'upload
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        echo json_encode(['success' => true, 'message' => 'Fichier déplacé avec succès.']);
        
        // Connexion à la base de données
        try {
            // Insérer les informations dans la table 'fichiers'
            $stmt = $db->prepare("INSERT INTO fichiers (nom, chemin, fk_user, fk_rendu, date_upload) VALUES (?, ?, ?, ?, NOW())");
            if ($stmt->execute([basename($file['name']), $filePath, $fk_user, $fk_rendu])) {
                echo json_encode(['success' => true, 'message' => 'Fichier inséré dans la base de données avec succès.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement dans la base de données.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors du déplacement du fichier.']);
    }
}

?>
