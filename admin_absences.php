<?php
include 'header-back.php';

// Récupérer la liste des étudiants
try {
$students_query = $db->query("SELECT id, prenom, nom FROM utilisateurs WHERE role = 'etudiant'");
$students = $students_query->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les absences pour vérification des justificatifs
$absences_query = $db->query("
SELECT absences.*, utilisateurs.prenom, utilisateurs.nom 
FROM absences 
JOIN utilisateurs ON absences.user_id = utilisateurs.id
WHERE absences.statut = 'À valider'
ORDER BY date_absence DESC
");
$absences = $absences_query->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
echo "Erreur : " . $e->getMessage();
$students = [];
$absences = [];
}
?>

<title>Back-Office | Absences</title>

<section class="page-absences-admin">

<h1>Gestion des absences</h1>

<main class="container">

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success" id="success-message">
        <?= htmlspecialchars($_GET['success']) ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-error" id="error-message">
        <?= htmlspecialchars($_GET['error']) ?>
    </div>
<?php endif; ?>

<script>
    setTimeout(function() {
        var successMessage = document.getElementById('success-message');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
        var errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.style.display = 'none';
        }
    }, 3000); 
</script>


<!-- Formulaire d'ajout d'absence -->
<div id="add-absence-form" class="add-absence-form">
<h2>Ajouter une absence</h2>
<form method="POST" action="add_absence.php">
    <label for="student_id">Étudiant :</label>
    <select id="student_id" name="student_id" required>
        <option value="" disabled selected>Choisir un étudiant</option>
        <?php foreach ($students as $student): ?>
            <option value="<?= $student['id'] ?>"><?= $student['prenom'] . ' ' . $student['nom'] ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label for="date_absence">Date de l'absence :</label>
    <input type="datetime-local" id="date_absence" name="date_absence" required>
    <br><br>

    <label for="duree">Durée (en heures et minutes) :</label>
    <input type="time" id="duree" name="duree" step="60" required>
    <br><br>

    <button type="submit">Ajouter l'absence</button>
</form>
</div>

<!-- Liste des absences avec justificatifs -->
<div id="absences-list" class="absences-list">
<h2>Absences avec justificatifs à valider</h2>
<table id="absences-table" class="absences-table">
    <thead>
        <tr>
            <th>Étudiant</th>
            <th>Date</th>
            <th>Durée</th>
            <th>Justificatif</th>
            <th>Commentaire</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($absences)): ?>
        <?php foreach ($absences as $absence): ?>
            <tr>
                <td data-label="Étudiant"><?= $absence['prenom'] . ' ' . $absence['nom'] ?></td>
                <td data-label="Date"><?= date("d/m/Y à H\hi", strtotime($absence['date_absence'])) ?></td>
                <td data-label="Durée"><?= date("H\hi", strtotime($absence['duree'])) ?></td>
                <td data-label="Justificatif">
                    <?php if (!empty($absence['document_url'])): ?>
                        <a href="<?= $absence['document_url'] ?>" target="_blank">Voir</a>
                    <?php else: ?>
                        Aucun justificatif
                    <?php endif; ?>
                </td>
                <td data-label="Commentaire">
                    <?php if (!empty($absence['comment'])): ?>
                        <p><?= $absence['comment'] ?></p>
                    <?php else: ?>
                        Aucun commentaire
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <form method="POST" action="validate_absence.php" style="display:inline;">
                        <input type="hidden" name="absence_id" value="<?= $absence['id'] ?>">
                        <button type="submit" name="action" value="valider">Valider</button>
                    </form>
                    <form method="POST" action="validate_absence.php" style="display:inline;">
                        <input type="hidden" name="absence_id" value="<?= $absence['id'] ?>">
                        <button type="submit" name="action" value="rejeter">Rejeter</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">Aucune absence à valider.</td>
        </tr>
    <?php endif; ?>
</tbody>
</table>
</div>

</main>
</section>

</body>
</html>
