<?php
include 'header-back.php';

// Récupérer les informations de l'utilisateur
$id = $_SESSION['id'];
$requete = "SELECT * FROM utilisateurs WHERE id = :id";
$stmt = $db->prepare($requete);
$stmt->bindParam(':id', $id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<title>ENT | Back-Office</title>

<section class="back-office" id="content">

<h1>Bienvenue dans le Back-Office</h1>

<div class="container">
    <p>Bienvenue, <?php echo $user['prenom'] . ' ' . $user['nom']; ?>. Utilisez le menu à gauche pour gérer les utilisateurs, les absences et les notes.</p>

    <!-- Cardes pour les sections principales -->
    <div class="cards-container">
        <div class="card">
            <i class="fas fa-users fa-3x"></i>
            <h3>Gestion des utilisateurs</h3>
            <p>Inscrivez et affichez les utilisateurs.</p>
            <div class="flex-btn">
                <a href="inscription.php" class="btn">Inscrire un  utilisateur</a>
                <a href="inscription.php" class="btn">Afficher les utilisateurs</a>
            </div>
        </div>
        <div class="card">
            <i class="fas fa-calendar-alt fa-3x"></i>
            <h3>Gestion des absences</h3>
            <p>Enregistrez les absences et validez-les.</p>
            <div class="flex-btn">
                <a href="admin_absences.php" class="btn">Ajouter des absences</a>
                <a href="admin_absences.php" class="btn">Valider des justificatifs</a>
            </div>
        </div>
        <div class="card">
            <i class="fas fa-pencil-alt fa-3x"></i>
            <h3>Gestion des notes</h3>
            <p>Ajoutez et gérez les notes des étudiants.</p>
            <div class="flex-btn">
                <a href="notes-back.php" class="btn">Ajouter des notes</a>
                <a href="notes-back.php" class="btn">Insérer un PDF de notes</a>
            </div>
        </div>
    </div>
</div>
</section>

<?php include('footer.php');?>
