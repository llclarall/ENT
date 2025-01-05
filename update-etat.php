<?php
include('config.php'); 

if (!isset($_SESSION['id'])) {
    echo "Vous devez être connecté pour effectuer cette opération.";
    exit();
}

$id = $_POST['id']; 
$etat = $_POST['etat']; 
$fk_user = $_SESSION['id']; 

if ($id && in_array($etat, ['a-faire', 'en-cours', 'fait'])) {
    try {
        $requete = $db->prepare('SELECT * FROM etats_rendus WHERE fk_rendu = :fk_rendu AND fk_user = :fk_user');
        $requete->execute([
            ':fk_rendu' => $id,
            ':fk_user' => $fk_user
        ]);
        
        // Si l'utilisateur n'a pas encore d'état pour ce rendu, on l'insère
        if ($requete->rowCount() == 0) {
            $insert = $db->prepare('INSERT INTO etats_rendus (fk_user, fk_rendu, etat) VALUES (:fk_user, :fk_rendu, :etat)');
            $insert->execute([
                ':fk_user' => $fk_user,
                ':fk_rendu' => $id,
                ':etat' => $etat
            ]);
            echo "État mis à jour avec succès.";
        } else {
            // Sinon, on met simplement à jour l'état
            $update = $db->prepare('UPDATE etats_rendus SET etat = :etat WHERE fk_rendu = :fk_rendu AND fk_user = :fk_user');
            $update->execute([
                ':etat' => $etat,
                ':fk_rendu' => $id,
                ':fk_user' => $fk_user
            ]);
            echo "État mis à jour avec succès.";
        }

    } catch (PDOException $e) {
        echo "Erreur SQL : " . $e->getMessage();
    }
} else {
    echo "Données invalides. ID ou état incorrect.";
}
?>
