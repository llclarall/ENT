<?php 
    include('header.php');
    include('config.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil ENT</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    
    <div class="accueil">
        <h1>Bienvenue user !</h1>
        
        <div class="container">
            <!-- Applications avec 3 sous-blocs -->
            <div class="applications">
                <h2>Applications</h2>
                <div class="flex-container">
                    <div class="widget sub-block elearning"><img src="images/elearning2.png" alt="">Elearning</div>
                    <div class="widget sub-block archives"><img src="images/archives.png" alt="">Archives</div>
                    <div class="widget sub-block edt"><img src="images/edt.png" alt="">Emploi du temps</div>
                </div>
            </div>
            <!-- Réservations avec 3 sous-blocs -->
            <div class="notifs">
                <!-- <h2>Notifications</h2> -->
                <div class="flex-container">
                    <div class="absences">
                        <h3><i class="fa-solid fa-ghost"></i> Absences</h3>
                        <div class="widget sub-block">
                            <span class="big">8h</span> <br>
                            <span>à justifier</span>
                        </div>
                    </div>
                    <div class="notes">
                        <h3><i class="fa-solid fa-heart"></i> Notes</h3>
                        <div class="widget sub-block">
                            <span class="big">3+</span> <br>
                            <span>notes</span>
                        </div>
                    </div>
                    <div class="reservations">
                        <h3><i class="fa-solid fa-bookmark"></i> RSVP</h3>
                        <div class="widget sub-block">
                            <span class="big">1</span> <br>
                            <span>réservation</span>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Derniers messages -->
            <div class="widget messages">
                <h2>Derniers messages</h2><hr>
                <p>Le prochain QCM se...</p>
                <p>Gaëlle Charpentier | 12/11</p>
            </div>
            <!-- Menu -->
            <div class="widget menu">
                <h2>Menu du jour</h2> <hr>
                <p><strong>Entrées :</strong> Oeufs mayonnaise, Taboulet</p>
                <p><strong>Plats :</strong> Poulet braisé, Poisson pané</p>
                <p><strong>Desserts :</strong> Tiramisu, Tarte aux pommes</p>
            </div>
            <!-- To-Do List -->
            <div class="widget rendus">
                <h2>Prochains rendus</h2> <hr>
                <p><strong>Mini blog :</strong> le 30 nov</p>
                <p><strong>CV vidéo :</strong> le 24 déc</p>
                <p><strong>Portfolio :</strong> fait</p>
            </div>
            <!-- Actualités -->
            <div class="widget actualites">
                <h2>Actualités</h2> <hr>
                <p>Un tournoi d'échecs est organisé du mardi 26 au mercredi 28 novembre...</p>
                <button>En savoir plus</button>
            </div>
        </div>
    </div>
</body>

</html>