<?php
include 'config.php';
 
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
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
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"
  />
</head>
<body>

<a href="#content" class="skip">Aller au contenu</a>

<header>
    <a href="profil.php"><?=$user['prenom']?><img src="images/filler.png" alt=""></a>
</header>


<!-- nav -->
  <button class="toggle-menu" aria-label="Ouvrir le menu">
    <i class="fas fa-bars"></i>
  </button>

  <nav class="side-nav" role="navigation" aria-labelledby="menu-label">
    <h2 id="menu-label" class="sr-only">Menu de navigation</h2>
    <div class="logo">
      <a href="accueil.php"><img src="images/logo.png" alt="Accueil ENT" /></a>
    </div>
    <ul class="menu">
      <!-- Accueil -->
      <li>
        <a href="accueil.php" class="menu-item" aria-label="Page d'accueil"> 
          <i class="fas fa-home" aria-hidden="true"></i>
          <span>Accueil</span>
        </a>
      </li>

      <!-- EDT -->      
      <li>
        <a href="#" class="menu-item dropdown-toggle" aria-expanded="false" aria-label="Emploi du temps">
          <i class="fas fa-calendar-alt" aria-hidden="true"></i>
          <span>Emploi du temps</span>
        </a>
        <ul class="dropdown" role="menu">
          <li><a href="edt.php" role="menuitem"><span>Emploi du temps</span></a></li>
          <li><a href="absences.php" role="menuitem"><span>Absences</span></a></li> 
        </ul>
      </li>
      
      <!-- Cours -->    
      <li>
        <a href="#" class="menu-item dropdown-toggle" aria-expanded="false" aria-label="Cours">
          <i class="fas fa-book" aria-hidden="true"></i>
          <span>Cours</span>
        </a>
        <ul class="dropdown" role="menu">
          <li><a href="elearning.php" role="menuitem"><span>Elearning</span></a></li> 
          <li><a href="archives.php" role="menuitem"><span>Archives</span></a></li> 
          <li><a href="rendus.php" role="menuitem"><span>Rendus</span></a></li>
          <li><a href="notes.php?mark_as_read=1" role="menuitem"><span>Notes</span></a></li>
        </ul>
      </li>

      <!-- Messagerie -->      
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


      <!-- Réservations menu -->
      <li>
        <a href="#" class="menu-item dropdown-toggle" aria-expanded="false" aria-label="Réservations">
          <i class="fas fa-calendar-check" aria-hidden="true"></i>
          <span>Réservations</span>
        </a>
        <ul class="dropdown" role="menu">
          <li><a href="reserver.php" role="menuitem"><span>Réserver</span></a></li> 
          <li><a href="mes_reservations.php" role="menuitem"><span>Mes réservations</span></a></li> 
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



  <footer class="footer">
        <div>
            <h2>À propos de nous</h2>
            <p>Université Gustave Eiffel</p>
            <p><a href="#" onclick="showLegal()">Mentions légales</a></p>
            <p>© 2025 Tous droits réservés</p>
        </div>
    
        <div>
            <h2>Restons connectés</h2>
            <p>Vous pouvez nous contacter</p>
            <p>au 01 02 03 04 05,
            <p>du lundi au vendredi de 9h à 17h</p>
            <p>ou par courriel : 
            <p><a href="mailto:clara.moubarak@edu.univ-eiffel.fr">clara.moubarak@edu.univ-eiffel.fr</a></p>
        </div>
    </footer>

    <!-- Modal -->
    <section>
      <div id="footerModal" class="footer-modal">
          <div class="footer-modal-content">
              <span class="footer-close" onclick="closeModal()">&times;</span>
              <h2>Mentions Légales</h2>
              <div class="footer-legal-content">
                  <h3>Informations Générales</h3>
                  <p>Le présent site est édité par Clara MOUBARAK, Mélissa CUMUR, Emilie GUERRIER et Alyssa KARAHAN.</p>
      
                  <h3>Mentions Légales</h3>
                  <p>Ce site est géré par une équipe composée de Clara MOUBARAK, Mélissa CUMUR, Emilie GUERRIER et Alyssa KARAHAN. Il est localisé au 2 Rue Albert Einstein, 77420 Champs-sur-Marne.</p>
                  <h3>Équipe</h3>
                  <p><strong>Conception Graphique</strong><br>
                  Clara MOUBARAK, Mélissa CUMUR, Emilie GUERRIER et Alyssa KARAHAN.</p>
                  <p><strong>Développement Front</strong><br>
                      Clara MOUBARAK, Mélissa CUMUR, Emilie GUERRIER et Alyssa KARAHAN.</p>
                  <p><strong>Développement Back</strong><br>
                      Clara MOUBARAK.</p>
                  <h3>Hébergeur</h3>
                  <p>Ce site est hébergé par O2Switch et il est localisé au 222-224 Boulevard Gustave Flaubert, 63000 Clermont-Ferrand.</p>
      
                  <h3>Protection des Données et RGPD</h3>
                  <p>Nous sommes pleinement engagés à respecter le Règlement Général sur la Protection des Données (RGPD) afin de garantir la sécurité et la confidentialité de vos données personnelles. Toutes les informations collectées sur notre Environnement Numérique de Travail (ENT) sont traitées conformément aux normes en vigueur. Nous mettons en place des mesures de sécurité robustes pour protéger vos données contre tout accès non autorisé, divulgation, altération ou perte.</p>
                  <p>Vous disposez également de droits concernant vos données, tels que l'accès, la rectification, la suppression, la limitation du traitement, ainsi que la possibilité de s'opposer à leur utilisation ou de demander leur portabilité. Pour toute question ou pour exercer vos droits, n'hésitez pas à nous contacter à l'adresse suivante : clara.moubarak@edu.univ-eiffel.fr.</p>
              </div>
          </div>
      </div>
    </section>

    <script>
        function showLegal() {
            document.getElementById('footerModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('footerModal').style.display = "none";
        }

        // Fermer le modal si l'on clique en dehors du contenu du modal
        window.onclick = function(event) {
            var modal = document.getElementById('footerModal');
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>

  <script src="script.js"></script>
</body>
</html>
