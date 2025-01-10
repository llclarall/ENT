<?php
include 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'secretaire') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $absence_id = $_POST['absence_id'];
    $statut = $_POST['action'] === 'valider' ? 'Validé' : 'Rejeté';

    try {
        // Validation des données
        if (empty($absence_id) || empty($statut)) {
            throw new Exception('Tous les champs sont obligatoires.');
        }

        // Mise à jour du statut de l'absence
        $stmt = $db->prepare("
            UPDATE absences 
            SET statut = :statut 
            WHERE id = :absence_id
        ");
        $stmt->execute([
            'statut' => $statut,
            'absence_id' => $absence_id
        ]);

        header('Location: absences-back.php?success=Statut de l\'absence mis à jour avec succès');
    } catch (Exception $e) {
        header('Location: absences-back.php?error=' . urlencode($e->getMessage()));
    }
    exit;
}

?>
