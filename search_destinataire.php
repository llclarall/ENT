
<?php
require_once 'config.php';

if (isset($_GET['q'])) {
    $search = htmlspecialchars(trim($_GET['q']));

    $query = "SELECT id, prenom, nom FROM utilisateurs WHERE (prenom LIKE :search OR nom LIKE :search) AND id != :expediteur_id LIMIT 10";
    $stmt = $db->prepare($query);
    $stmt->execute([
        'search' => "%$search%",
        'expediteur_id' => $_SESSION['id']
    ]);
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($resultats);
    exit;
}
?>