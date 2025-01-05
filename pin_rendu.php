<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'utilisateur connecté
    $userId = $_SESSION['id'];
    if (!$userId) {
        http_response_code(401); // Non autorisé
        echo json_encode(['error' => 'Utilisateur non connecté']);
        exit;
    }
    
    // Récupérer les données envoyées
    $data = json_decode(file_get_contents('php://input'), true);
    $renduId = $data['id'];
    $pinned = $data['pinned']; // 1 pour épinglé, 0 pour non épinglé

    if ($pinned) {
        // Ajouter une entrée dans la table `pins`
        $stmt = $db->prepare("INSERT IGNORE INTO pins (fk_user, fk_rendu) VALUES (:fk_user, :fk_rendu)");
        $stmt->execute(['fk_user' => $userId, 'fk_rendu' => $renduId]);
    } else {
        // Supprimer l'entrée correspondante
        $stmt = $db->prepare("DELETE FROM pins WHERE fk_user = :fk_user AND fk_rendu = :fk_rendu");
        $stmt->execute(['fk_user' => $userId, 'fk_rendu' => $renduId]);
    }

    echo json_encode(['success' => true]);
}
?>
