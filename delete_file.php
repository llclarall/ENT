<?php
include('config.php');

// Récupérer l'ID du fichier à supprimer
$fileId = $_GET['id'] ?? null;

if (!$fileId) {
    echo "ID de fichier manquant.";
    exit;
}

try {
    // Rechercher le fichier dans la base de données
    $stmt = $db->prepare("SELECT chemin FROM fichiers WHERE id = ?");
    $stmt->execute([$fileId]);
    $file = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($file) {
        // Supprimer le fichier physique du serveur
        if (file_exists($file['chemin'])) {
            unlink($file['chemin']);
        }

        // Supprimer le fichier de la base de données
        $stmt = $db->prepare("DELETE FROM fichiers WHERE id = ?");
        $stmt->execute([$fileId]);

        echo "<script>alert('Fichier supprimé avec succès.'); window.location.href='rendus.php';</script>";
    } else {
        echo "Fichier introuvable.";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
