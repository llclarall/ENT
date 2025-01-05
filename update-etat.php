<?php
include('config.php');

// Récupère les données envoyées par le formulaire
$id = $_POST['id'];
$etat = $_POST['etat'];

// Vérifie que les données sont valides
if ($id && in_array($etat, ['a-faire', 'en-cours', 'fait'])) {
    try {
        $requete = $db->prepare('UPDATE rendus SET etat = :etat WHERE id = :id');
        $requete->execute([
            ':etat' => $etat,
            ':id' => $id,
        ]);

        echo "Mise à jour réussie pour l'état : $etat.";
    } catch (PDOException $e) {
        echo "Erreur SQL : " . $e->getMessage();
    }
} else {
    echo "Données invalides. ID ou état incorrect.";
}

?>