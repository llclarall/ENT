<?php
include 'header-back.php';


// Récupérer les utilisateurs
$stmt = $db->prepare("SELECT * FROM utilisateurs ORDER BY nom, prenom");
$stmt->execute();
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Séparer les utilisateurs ayant le rôle de secrétaire
$secretaires = array_filter($utilisateurs, function($user) {
    return $user['role'] === 'secretaire';
});
$profs = array_filter($utilisateurs, function($user) {
    return $user['role'] === 'prof';
});
$autres_utilisateurs = array_filter($utilisateurs, function($user) {
    return $user['role'] !== 'secretaire' && $user['role'] !== 'prof';
});
?>

<title>Back-Office | Utilisateurs</title>

<section class="page-users" id="content">
    
    <h1>Liste des Utilisateurs</h1>
    
    <div id="user-list" class="container">
        <?php foreach (array_merge($secretaires, $profs,  $autres_utilisateurs) as $utilisateur): ?>
            <!-- Bouton de suppression -->
            <div class="tout">

                <form method="post" action="delete_utilisateur.php" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');" title="Supprimer cet utilisateur" class="delete-user">
                    <input type="hidden" name="id" value="<?= $utilisateur['id']; ?>">
                    <button type="submit"><i class="fas fa-trash delete"></i></button>
                </form>
            
            <div class="user-container" style="<?= $utilisateur['role'] === 'secretaire' ? 'background-color: #ffe4c2;' : ''; ?> <?= $utilisateur['role'] === 'prof' ? 'background-color: #d3f2ff;' : ''; ?>">
                <div class="user-header" onclick="toggleDetails(this)">
                    <div class="user-info">
                        <span><?= htmlspecialchars($utilisateur['prenom']) . " " . htmlspecialchars($utilisateur['nom']); ?>
                        </span>
                        <span class="role"><?= htmlspecialchars($utilisateur['role']); ?></span>
                        
                    </div>
   
                    <span class="arrow">▶</span>
                </div>
                <div class="user-details">
                    <p><strong>Login :</strong> <?= htmlspecialchars($utilisateur['login']); ?></p>
                    <?php if (!empty($utilisateur['mdp_clair'])): ?>
                        <p><strong>Mot de passe temporaire :</strong> <?= htmlspecialchars($utilisateur['mdp_clair']); ?></p>
                    <?php endif; ?>
                    <p><strong>Email :</strong> <?= htmlspecialchars($utilisateur['mail']); ?></p>
                    <?php if (!empty($utilisateur['num_etudiant'])): ?>
                        <p><strong>Numéro étudiant :</strong> <?= htmlspecialchars($utilisateur['num_etudiant']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<script>
    // Fonction pour afficher/masquer les détails d'un utilisateur
    function toggleDetails(element) {
        const details = element.nextElementSibling;
        const arrow = element.querySelector('.arrow');

        if (details.style.display === "none" || details.style.display === "") {
            details.style.display = "block";
            arrow.classList.add('down');
        } else {
            details.style.display = "none";
            arrow.classList.remove('down');
        }
    }
</script>

<?php include('footer.php');?>

</body>
</html>
