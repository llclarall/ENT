<?php
include('config.php');

// pin_rendu.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées
    $data = json_decode(file_get_contents('php://input'), true);
    $renduId = $data['id'];
    $pinned = $data['pinned']; // 1 pour épinglé, 0 pour non épinglé

    $stmt = $db->prepare("UPDATE rendus SET pinned = :pinned WHERE id = :id");
    $stmt->bindParam(':pinned', $pinned, PDO::PARAM_INT);
    $stmt->bindParam(':id', $renduId, PDO::PARAM_INT);
    $stmt->execute();
}

?>
