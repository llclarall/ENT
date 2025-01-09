<?php
include('config.php');

// Vérifier si la requête est bien en POST et que le fichier a été envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    if (!isset($_SESSION['id'])) {
        echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
        return;
    }

    $file = $_FILES['file'];
    $fk_user = $_SESSION['id'];
    $fk_rendu = $_POST['fk_rendu'];

    // Vérification des erreurs d'upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'Erreur de téléchargement du fichier, code: ' . $file['error']]);
        return;
    }

    // Vérification de la taille du fichier (max 5MB par exemple)
    $maxFileSize = 5 * 1024 * 1024; // 5MB
    if ($file['size'] > $maxFileSize) {
        echo json_encode(['success' => false, 'message' => 'Le fichier est trop volumineux.']);
        return;
    }

    // Liste des extensions autorisées
    $allowedExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) {
        echo json_encode(['success' => false, 'message' => 'Type de fichier non autorisé.']);
        return;
    }

    // Répertoire d'upload
    $uploadDir = 'uploads/';
    $fileName = basename($file['name']);
    $filePath = $uploadDir . $fileName;

    // Vérifier si le dossier existe, sinon, le créer
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Déplacer le fichier vers le dossier d'upload
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        try {
            // Insérer les informations dans la table 'fichiers'
            $stmt = $db->prepare("INSERT INTO fichiers (nom, chemin, fk_user, fk_rendu, date_upload) VALUES (?, ?, ?, ?, NOW())");
            if ($stmt->execute([$fileName, $filePath, $fk_user, $fk_rendu])) {
                // Retourner une réponse JSON avec les informations du fichier
                echo json_encode([
                    'success' => true,
                    'message' => 'Fichier inséré dans la base de données avec succès.',
                    'fileName' => $fileName,
                    'filePath' => $filePath
                ]);
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
