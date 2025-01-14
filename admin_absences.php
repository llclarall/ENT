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
WHERE absences.statut = 'En attente de validation'
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

<section class="page-absences-admin" id="content">

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

</main>
</section>

<?php include('footer.php');?>

</body>
</html>
