<?php
include('header.php');
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>ENT | Vie étudiante</title>
</head>
<body>

<section class="page-vie-etudiante" id="content">

<h1>Vie étudiante</h1>

<div class="sections-container">

    <div class="section-wrapper">
      <h2>Forum/FAQ</h2>
      <div class="info-card">
        <img src="img/forum.jpg" alt="">
        <div class="info-card-content">
          <div class="info-card-title">Forum et FAQ</div>
          <div class="info-card-description">Vous pouvez retrouver une FAQ complète ainsi qu’un forum dédié pour poser vos questions et échanger avec d’autres personnes</div>
          <a href="#" class="info-card-button">En savoir plus</a>
        </div>
      </div>
    </div>

    <div class="section-wrapper large-card" >
      <h2>Événements - UGE</h2>
      <div class="info-card">
        <img src="img/evenement.png" alt="">
        <div class="info-card-content">
          <div class="info-card-title">Élection des représentants</div>
          <div class="info-card-description">C'est avec enthousiasme que l'Université Gustave Eiffel vous annonce l'ouverture des élections des représentants étudiants au sein de notre institution.</div>
          <a href="#" class="info-card-button">En savoir plus</a>
        </div>
      </div>
    </div>

      <div class="section-wrapper">
        <h2>Offre stage / alternance</h2>
        <div class="info-card">
          <img src="img/stage.jpg" alt="">
          <div class="info-card-content">
            <div class="info-card-title">Salon de l'alternance</div>
            <div class="info-card-description">L'université Gustave Eiffel est heureuse de vous inviter à son Salon de l'alternance, le 3 décembre.</div>
            <a href="#" class="info-card-button">En savoir plus</a>
          </div>
        </div>
      </div>

      <div class="section-wrapper large-card">
        <h2>Internationale</h2>
        <div class="info-card">
          <img src="img/voyage.png" alt="">
          <div class="info-card-content">
            <div class="info-card-title">Voyage en Irlande</div>
            <div class="info-card-description">L'université Gustave Eiffel a le plaisir de vous annoncer l'organisation d'un voyage en Irlande, une occasion unique de découvrir la richesse culturelle et les paysages époustouflants de l'île.</div>
            <a href="#" class="info-card-button">En savoir plus</a>
          </div>
        </div>
      </div>

</div>

</section>

<?php include('footer.php');?>

</body>
</html>