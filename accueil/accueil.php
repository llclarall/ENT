<?php 
    include('header.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil ENT</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    
    <div class="accueil">
        <h1>Bienvenue user !</h1>
        
        <div class="container">
            <!-- Applications avec 3 sous-blocs -->
            <div class="applications">
                <h2>Applications</h2>
                <div class="flex-container">
                    <div class="widget sub-block">Elearning</div>
                    <div class="widget sub-block">Archives</div>
                    <div class="widget sub-block">Emploi du temps</div>
                </div>
            </div>
            <!-- Réservations avec 3 sous-blocs -->
            <div class="reservations">
                <h2>Absences & Réservations</h2>
                <div class="flex-container">
                    <div class="widget sub-block">8h à justifier</div>
                    <div class="widget sub-block">3+ notes</div>
                    <div class="widget sub-block">1 réservation</div>
                </div>
            </div>
        
            <!-- Derniers messages -->
            <div class="widget messages">
                <h2>Derniers messages</h2>
                <p>Le prochain QCM se...</p>
                <p>Gaëlle Charpentier | 12/11</p>
            </div>
            <!-- Menu -->
            <div class="widget menu">
                <h2>Menu du jour</h2>
                <p><strong>Entrées :</strong> Oeufs mayonnaise, Taboulet</p>
                <p><strong>Plats :</strong> Poulet braisé, Poisson pané</p>
                <p><strong>Desserts :</strong> Tiramisu, Tarte aux pommes</p>
            </div>
            <!-- To-Do List -->
            <div class="widget rendus">
                <h2>Prochains rendus</h2>
                <p><strong>Mini blog :</strong> le 30 nov</p>
                <p><strong>CV vidéo :</strong> le 24 déc</p>
                <p><strong>Portfolio :</strong> fait</p>
            </div>
            <!-- Actualités -->
            <div class="widget actualites">
                <h2>Actualités</h2>
                <p>Un tournoi d'échecs est organisé du mardi 26 au mercredi 28 novembre...</p>
                <button>En savoir plus</button>
            </div>
        </div>
    </div>
</body>

</html>