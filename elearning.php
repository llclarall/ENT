<?php 
    include('header.php');
    include('config.php');
    include('nav.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>ENT | Elearning</title>
</head>
<body>
    <!-- Main Section -->
    <main>
    <section class="page-elearning">
      <h1>E-learning</h1>
      <!-- Archives des cours -->
      <div class="flex-container-btn"><a href="archives.php" class="archives-btn">Accéder aux Archives</a>
    </div>
      <!-- Création numérique Section -->
    <div class="elearning-container">
      <div class="section-title">Création numérique</div>
      <div class="course-container">
        <div class="course-card">
          <img src="img/creation.png" alt="">
          <div class="course-details">
            <strong>R3.09 Création et Design interactif MMI2 </strong>
            <span>Eiffel Année universitaire 2024/2025</span>
          </div>
        </div>
        <div class="course-card">
        <img src="img/audiovisuel.jpg" alt="">
        <div class="course-details">
            <strong>Audiovisuel & Motion Design</strong>
            <span>Eiffel Année universitaire 2024/2025</span>
          </div>
        </div>
      </div>
      <!-- Développement Web Section -->
      <div class="section-title">Développement web</div>
      <div class="course-container">
        <div class="course-card">
          <img src="img/deploiement.jpg" alt="">
          <div class="course-details">
            <strong>Déploiement de services MMI2 2024</strong>
            <span>Eiffel Année universitaire 2024/2025</span>
          </div>
        </div>
        <div class="course-card">
          <img src="img/javascript.jpg" alt="">
        <div class="course-details">
            <strong>R3.12 Développement Javascript</strong>
            <span>Eiffel Année universitaire 2024/2025</span>
          </div>
        </div>
        <div class="course-card">
          <img src="img/integration.jpg" alt="">
        <div class="course-details">
            <strong>Intégration web - BUT MMI2</strong>
            <span>Eiffel Année universitaire 2024/2025</span>
          </div>
        </div>
      </div>
    </div>
    </section>
  </main> 
  
  <script src="../script.js"></script>
</body>
</html>