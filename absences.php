<?php
include 'header.php';

$user_id = $_SESSION['id'];

try {
    // Requête pour récupérer les absences et calculer la somme des durées
    $requete = $db->prepare("
        SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duree))) AS total_duree 
        FROM absences 
        WHERE user_id = :user_id
    ");
    $requete->execute(['user_id' => $user_id]);
    $result = $requete->fetch(PDO::FETCH_ASSOC);

    // Gestion du total des heures (conversion)
    $total_heures = '0h'; // Valeur par défaut
    if ($result && !empty($result['total_duree'])) {
        list($hours, $minutes, $seconds) = sscanf($result['total_duree'], '%d:%d:%d');
        $total_heures = ($hours > 0 ? $hours . 'h' : '') . ($minutes > 0 ? $minutes . 'min' : '');
    }

    // Requête pour récupérer le total des heures non justifiées
    $requete_non_justifiees = $db->prepare("
        SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duree))) AS total_non_justifiees
        FROM absences 
        WHERE user_id = :user_id AND statut IN ('À justifier', 'Rejeté | Rejustifier', 'En attente de validation')
    ");
    $requete_non_justifiees->execute(['user_id' => $user_id]);
    $result_non_justifiees = $requete_non_justifiees->fetch(PDO::FETCH_ASSOC);

    // Calcul du total des heures non justifiées
    $total_non_justifiees = '0h'; // Valeur par défaut
    if ($result_non_justifiees && !empty($result_non_justifiees['total_non_justifiees'])) {
        list($hours_non_justifiees, $minutes_non_justifiees, $seconds_non_justifiees) = sscanf($result_non_justifiees['total_non_justifiees'], '%d:%d:%d');
        $total_non_justifiees = ($hours_non_justifiees > 0 ? $hours_non_justifiees . 'h' : '') . ($minutes_non_justifiees > 0 ? $minutes_non_justifiees . 'min' : '');
    }

    // Récupérer les absences pour l'affichage
    $absences_requete = $db->prepare("
        SELECT * FROM absences 
        WHERE user_id = :user_id 
        ORDER BY date_absence DESC
    ");
    $absences_requete->execute(['user_id' => $user_id]);
    $absences = $absences_requete->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Gestion des erreurs
    echo "<div class='error'>Erreur : " . htmlspecialchars($e->getMessage()) . "</div>";
    $total_heures = 'Erreur';
    $total_non_justifiees = 'Erreur';
    $absences = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ENT | Absences</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<section class="page-absences">

<h1>Absences</h1>

  <main class="container" id="content">

    <div id="total-hours" class="total-hours">
        <h2>Total des heures manquées : <span class="total-missed"><?= $total_heures ?></span></h2>
    </div>

    <div id="total-non-justifiees" class="total-non-justifiees">
        <h2>Total des heures non-justifiées : <span class="total-missed"><?= $total_non_justifiees ?></span></h2>
    </div>

    <div id="absences">
      <h2 class="details">Détails des absences</h2>

      <table id="absences-table">
        <thead>
          <tr class="table-header">
            <th scope="col">Date</th>
            <th scope="col">Durée (heures)</th>
            <th scope="col">Justification</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!empty($absences)): ?>
            <?php foreach ($absences as $absence): ?>
                <tr data-absence-id="<?= $absence['id'] ?>">
                    <td><?= date("d/m/Y à H\hi", strtotime($absence['date_absence'])) ?></td>
                    <td class="duree"><?= date("H\hi", strtotime($absence['duree'])) ?></td>
                    <td>
                        <?php if ($absence['statut'] === 'À justifier' || $absence['statut'] === 'Rejeté | Rejustifier'): ?>
                            <button class="justify-btn"><?=$absence['statut']?></button>
                        <?php else: ?>
                            <?=$absence['statut']?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Aucune absence enregistrée.</td>
            </tr>
        <?php endif; ?>
        </tbody>

      </table>
    </div>
      
    
      <!-- Modal pour la justification -->
<div id="justification-modal" class="modal">
    <form id="justification-form" method="POST" action="justifier_absence.php" enctype="multipart/form-data">
        <div class="modal-content">
            <h3>Justification de l'absence du <?= date("d/m/Y à H\hi", strtotime($absence['date_absence'])) ?></h3>
            <input type="hidden" name="absence_id" id="absence-id">
            <br>
            <label for="reason">Raison (obligatoire) :</label>
            <select id="reason" name="reason" required>
                <option value="" disabled selected>Choisissez votre raison ci-dessous</option>
                <option value="Maladie">Maladie</option>
                <option value="Transport">Problème de transport</option>
                <option value="Urgence familiale">Urgence familiale</option>
                <option value="Autre">Autre</option>
            </select>
            <br><br>
            
            <label for="document">Télécharger un document (obligatoire) :</label>
            <input type="file" id="document" name="document" accept="application/pdf,.doc,.docx,.png" required>

            <small>Les documents acceptés sont au format PDF, PNG, DOC ou DOCX.</small>
            <br><br>
            
            <label for="comment">Commentaire (facultatif) :</label>
            <textarea id="comment" name="comment" rows="4" placeholder="Ajouter un commentaire..."></textarea>
            <br><br>
            
            <button type="submit" id="validate-justification">Valider</button>
            <button type="button" id="cancel-justification" class="cancel-justification">Annuler</button>
        </div>
    </form>
</div>


  </main>
</section>

<?php include('footer.php');?>


<script src="absences.js"></script>
</body>
</html>
