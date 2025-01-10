<?php
include 'header.php';
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Annie+Use+Your+Telescope&family=Barriecito&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENT | Réserver</title>
</head>
<body>

<section class="page-reserver" id="content">
    
        <h1>Réserver</h1>
    <br>
    
    <div class="flex-container-btn">
        <a href="mes_reservations.php" class="resas archives-btn">Mes réservations</a>
    </div>
    
    <div class="container">
        <div class="item">
            <h2>Repas</h2>
            <div class="block">
                <img src="img/food.jpg" alt="" class="image">
                <div class="block-text">
                    <p class="reservez">Réservez votre repas</p>
                    <p class="description">Simplifiez vos pauses repas en réservant à l’avance. Des options savoureuses adaptées à tous les goûts vous attendent !</p>
                    <a href="#" class="resa">Réserver</a>
                </div>
            </div>
        </div>
    
        <div class="item">
            <h2>Matériel</h2>
            <div class="block">
                <img src="img/camera.jpg" alt="" class="image">
                <div class="block-text">
                    <p class="reservez">Réservez votre matériel</p>
                    <p class="description">Nous mettons à votre disposition des équipements professionnels : caméras, micros et plus encore.</p>
                    <a href="materiel.php" class="resa">Réserver</a>
                </div>
            </div>
        </div>
    
        <div class="item">
            <h2>Salles</h2>
            <div class="block">
                <img src="img/classe.jpg" alt="" class="image">
                <div class="block-text">
                    <p class="reservez"> Réservez votre salle</p>
                    <p class="description">Nous mettons à votre disposition des salles afin que vous puissiez réviser dans les meilleures conditions. </p>
                   <a href="#" class="resa">Réserver</a>
                </div>    
            </div>
        </div>
    </div>
    
</section>

</body>
</html>