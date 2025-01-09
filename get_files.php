<?php
if (isset($_GET['renduId']) && isset($_GET['userId'])) {
    $rendu = $_GET['renduId'];  
    $fk_user = $_GET['userId']; 

    if (!$rendu || !$fk_user) {
        echo json_encode(['error' => 'Paramètres manquants ou invalides.']);
        exit;
    }

    try {
        require 'config.php'; 

        $stmt = $db->prepare("SELECT * FROM fichiers WHERE fk_user = :fk_user AND fk_rendu = :fk_rendu");
        $stmt->bindParam(':fk_user', $fk_user, PDO::PARAM_INT);
        $stmt->bindParam(':fk_rendu', $rendu, PDO::PARAM_INT);
        $stmt->execute();

        $fichiers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['files' => $fichiers]);

    } catch (PDOException $e) {
        echo json_encode(['error' => 'Erreur lors de la récupération des fichiers: ' . $e->getMessage()]);
    }

} else {
    echo json_encode(['error' => 'Paramètres manquants.']);
}
?>
