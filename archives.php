<?php 
    include('header.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>ENT | Archives</title>
</head>
<body>
    <!-- Main Section -->
    <main>
    <section class="page-archives" id="content">
      <h1>Archives</h1>
      <!-- Archives des cours -->
      <div class="flex-container-btn"><a href="elearning.php" class="archives-btn">Accéder au Elearning</a>
    </div>


      <!-- Création numérique Section -->
       <div class="elearning-container">
      <div class="section-title">Création numérique</div>
      <div class="course-container">
        <div class="course-card">
          <img src="img/prodgraphique.jpg" alt="">
          <div class="course-details">
            <strong>R2.08 Prod. Graphique</strong>
            <span>Eiffel Année universitaire 2023/2024</span>
          </div>
        </div>
        <div class="course-card">
        <img src="img/audiovisuel.jpg" alt="">
        <div class="course-details">
            <strong>Audiovisuel & Motion Design</strong>
            <span>Eiffel Année universitaire 2024/2025</span>
          </div>
        </div>
        <div class="course-card">
        <img src="img/culture.png" alt="">
        <div class="course-details">
            <strong>Culture Numérique</strong>
            <span>Eiffel Année universitaire 2024/2025</span>
          </div>
        </div>
      </div>
      <!-- Développement Web Section -->
      <div class="section-title">Développement web</div>
      <div class="course-container">
        <div class="course-card">
          <img src="img/hebergement.jpg" alt="">
          <div class="course-details">
            <strong>Hébergement et gestion de contenu</strong>
            <span>Eiffel Année universitaire 2023/2024</span>
          </div>
        </div>
        <div class="course-card">
          <img src="img/ergonomie.jpg" alt="">
        <div class="course-details">
            <strong>Ergonomie et Accessibilité</strong>
            <span>Eiffel Année universitaire 2023/2024</span>
          </div>
        </div>
        <div class="course-card">
          <img src="img/systeme.jpg" alt="">
        <div class="course-details">
            <strong>R2.14 Systèmes d'information</strong>
            <span>Eiffel Année universitaire 2023/2024</span>
          </div>
        </div>
      </div>
      </div>
    </section>
  </main>  

  <?php include('footer.php');?>

</body>
</html>   
