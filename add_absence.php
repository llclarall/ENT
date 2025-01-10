<?php
include 'config.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'secretaire') {
    header('Location: index.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['student_id'];
    $date_absence = $_POST['date_absence'];
    $duree = $_POST['duree'];

    try {
        // Validation des données
        if (empty($user_id) || empty($date_absence) || empty($duree)) {
            throw new Exception('Tous les champs sont obligatoires.');
        }

        // Insertion dans la base de données
        $stmt = $db->prepare("
            INSERT INTO absences (user_id, date_absence, duree, statut) 
            VALUES (:user_id, :date_absence, :duree, 'À justifier')
        ");
        $stmt->execute([
            'user_id' => $user_id,
            'date_absence' => $date_absence,
            'duree' => $duree
        ]);

        header('Location: admin_absences.php?success=Absence ajoutée avec succès');
    } catch (Exception $e) {
        header('Location: admin_absences.php?error=' . urlencode($e->getMessage()));
    }
    exit;
}

?>
