
<?php
include 'header.php';
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENT | Mes réservations</title>
</head>
<body>

<section class="page-mes-reservations">

<h1>Mes réservations</h1>

<div class="container" id="content">

    <div class="filtres">
        <button class="filtre">Matériel</button>
        <button class="filtre">Salle</button>
        <button class="filtre">Repas</button>
    </div>

    <a href="reserver.php" class="reserver-lien">Tu souhaites réserver quelque chose ? C’est par ici !</a>

    <div class="rsvp-container">
        
        <div class="timeline">
            <span>déc</span>
            <div class="ligne"></div>
            <span>nov</span>
            <div class="ligne"></div>
        </div>


        <div class="reservations">

            <div class="reservation a-venir">
                <div class="reservation-info">
                    <div class="titre">
                        <h2>Osmo</h2>
                        <span class="type">matériel</span>
                    </div>
                    <p>Du 18 au 23 nov</p>
                </div>
                <div class="reservation-actions">
                    <span class="statut a-venir">à venir</span>
                    <a href="annuler_reservation.php"><img src="images/pencil.png" alt=""></a>
                    <a href="annuler_reservation.php"><img src="images/shape.png" alt=""></a>
                </div>
            </div>

            <div class="reservation en-cours">
                <div class="reservation-info">
                    <div class="titre">
                        <h2>Salle 126</h2>
                        <span class="type">salle</span>
                    </div>
                    <p>Le 19 nov  de 8h15 à 10h15</p>
                </div>
                <div class="reservation-actions">
                    <span class="statut en-cours">en cours</span>
                    <a href="annuler_reservation.php"><img src="images/pencil.png" alt=""></a>
                    <a href="annuler_reservation.php"><img src="images/shape.png" alt=""></a>
                </div>
            </div>

            <div class="reservation terminee">
                <div class="reservation-info">
                    <div class="titre">
                        <h2>Menu First</h2>
                        <span class="type">repas</span>
                    </div>
                    <p>Le 10 nov</p>
                </div>
                <div class="reservation-actions">
                    <span class="statut terminee">terminée</span>
                    <a href="annuler_reservation.php"><img src="images/pencil.png" alt=""></a>
                    <a href="annuler_reservation.php"><img src="images/shape.png" alt=""></a>
                </div>
            </div>

            <div class="reservation terminee">
                <div class="reservation-info">
                    <div class="titre">
                        <h2>Osmo</h2>
                        <span class="type">matériel</span>
                    </div>
                    <p>Du 18 au 23 nov</p>
                </div>
                <div class="reservation-actions">
                    <span class="statut terminee">terminée</span>
                    <a href="annuler_reservation.php"><img src="images/pencil.png" alt=""></a>
                    <a href="annuler_reservation.php"><img src="images/shape.png" alt=""></a>
                </div>
            </div>
        </div>
    </div>

</div>

</section>
    
</body>
</html>