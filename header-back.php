<?php
include 'config.php';
 
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

// Vérifier si l'utilisateur est connecté et est un administrateur
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'secretaire') {
    echo "Accès refusé.";
    exit;
}

// Récupérer les informations de l'utilisateur
$id = $_SESSION['id'];
$requete = "SELECT * FROM utilisateurs WHERE id = :id";
$stmt = $db->prepare($requete);
$stmt->bindParam(':id', $id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"/>
</head>
<body>

<header>
    <a href="back-office.php">Back-Office<img src="images/logo.png" alt=""></a>
</header>


<!-- nav -->
<button class="toggle-menu" aria-label="Ouvrir le menu">
    <i class="fas fa-bars"></i>
</button>

<nav class="side-nav" role="navigation" aria-labelledby="menu-label">
    <h2 id="menu-label" class="sr-only">Menu de navigation</h2>
    <div class="logo">
      <a href="back-office.php"><img src="images/logo.png" alt="Back-Office ENT" /></a>
    </div>
    <ul class="menu">
      <!-- Accueil -->
      <li>
        <a href="back-office.php" class="menu-item"> 
          <i class="fas fa-home"></i>
          <span>Accueil Back-Office</span>
        </a>
      </li>

      <!-- users -->         
      <li>
        <a href="#" class="menu-item dropdown-toggle" aria-expanded="false" aria-label="Gestion des utilisateurs">
          <i class="fas fa-users" aria-hidden="true"></i>
          <span>Gestion des utilisateurs</span>
        </a>
        <ul class="dropdown" role="menu">
          <li><a href="inscription.php" role="menuitem"><span>Inscrire un utilisateur</span></a></li> 
          <li><a href="affiche_users.php" role="menuitem"><span>Afficher les utilisateurs</span></a></li> 
        </ul>
      </li>
      
      <!-- absences -->    
      <li>
        <a href="#" class="menu-item dropdown-toggle" aria-expanded="false" aria-label="Gestion des absences">
          <i class="fas fa-calendar-alt" aria-hidden="true"></i>
          <span>Gestion des absences</span>
        </a>
        <ul class="dropdown" role="menu">
          <li><a href="admin_absences.php" role="menuitem"><span>Insérer des absences</span></a></li> 
          <li><a href="admin_absences.php" role="menuitem"><span>Absences à valider</span></a></li> 
        </ul>
      </li>

      <!-- notes -->      
      <li>
        <a href="#" class="menu-item dropdown-toggle" aria-expanded="false" aria-label="Messagerie">
          <i class="fas fa-comment-dots" aria-hidden="true"></i>
          <span>Gestion des notes</span>
        </a>
        <ul class="dropdown" role="menu">
          <li><a href="notes-back.php" role="menuitem"><span>Notes</span></a></li>
          <li><a href="notes-back-pdf.php" role="menuitem"><span>pdf</span></a></li>
        </ul>
      </li>

      <!-- messagerie -->      
      <li>
        <a href="#" class="menu-item dropdown-toggle" aria-expanded="false" aria-label="Messagerie">
          <i class="fas fa-comment-dots" aria-hidden="true"></i>
          <span>Messagerie</span>
        </a>
        <ul class="dropdown" role="menu">
          <li><a href="messagerie.php" role="menuitem"><span>Messagerie</span></a></li>
          <li><a href="annuaire.php" role="menuitem"><span>Annuaire</span></a></li>
        </ul>
      </li>
      
      <!-- Vie étudiante -->          
      <li>
        <a href="vie_etudiante.php" class="menu-item" aria-label="Page vie étudiante">
          <i class="fas fa-users" aria-hidden="true"></i>
          <span>Vie étudiante</span>
        </a>
      </li>

    </ul>
    
    <!-- Deconnexion -->     
    <div class="logout">
      <a href="deconnect.php" class="logout-button" aria-label="Se déconnecter">
        <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
        <span>Se déconnecter</span>
      </a>
    </div>
  </nav>

  <script src="script.js"></script>
    
</body>
</html>