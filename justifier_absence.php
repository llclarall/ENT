<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $absence_id = $_POST['absence_id'];
    $reason = $_POST['reason'];
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
    $document = $_FILES['document'];

    if (!empty($absence_id) && !empty($reason) && $document['error'] === UPLOAD_ERR_OK) {
        // Vérifier et enregistrer le fichier
        $upload_dir = 'uploads_justificatifs/';
        $file_name = uniqid() . '_' . basename($document['name']);
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($document['tmp_name'], $file_path)) {
            try {
                $query = $db->prepare("
                    UPDATE absences 
                    SET justification = :reason, 
                        document_url = :file_path, 
                        commentaire = :comment,
                        statut = 'À valider' 
                    WHERE id = :absence_id
                ");
                $query->execute([
                    'reason' => $reason,
                    'file_path' => $file_path,
                    'comment' => $comment,
                    'absence_id' => $absence_id
                ]);

                echo "<script>alert('Justification envoyée.');
                window.location.href = 'absences.php';</script>";

            } catch (Exception $e) {
                echo "Erreur : " . $e->getMessage();
            }
        } else {
            http_response_code(500);
            echo "Erreur lors de l'enregistrement du fichier.";
        }
    } else {
        http_response_code(400);
        echo "Données manquantes ou fichier non valide.";
    }
} else {
    http_response_code(405);
    echo "Méthode non autorisée.";
}
