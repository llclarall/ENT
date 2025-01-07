<?php
include 'header.php';
include 'nav.php';
?>


<!DOCTYPE html>
<html lang="FR">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="styles.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Notes</title>
</head>
<body>

<section class="page-notes">

<h1>Notes</h1>




<div class="container">

    <div class="small-boxes">
        <h3>Matières</h3>
        
        <div class="small-box">Gestion de projet</div>
        <div class="small-box">Intégration web</div>
        <div class="small-box">Anglais</div>
        <div class="small-box">PPP</div>
        <div class="small-box">Droit du numérique</div>
        <div class="small-box">Référencement</div>
        <div class="small-box">Culture numérique</div>
        <div class="small-box">Communication</div>
    </div>

    <div class="large-box">    
        
    <div class="semester-dropdown">
        <select id="semester" name="semester">
            <option value="" disabled selected>Choix du semestre</option>
            <option value="semester1">Semestre 1</option>
            <option value="semester2">Semestre 2</option>
        </select>
    </div>

        <div class="control-row">
            <div class="control-info">
                <p class="gras">Contrôle n°1</p>
                <p class="date">06/01/2025</p>
            </div>
            <div class="control-note">15/20</div>
        </div>
        <div class="control-row">
            <div class="control-info">
                <p class="gras">Contrôle n°2</p>
                <p class="date">13/01/2025</p>
            </div>
            <div class="control-note">10/20</div>
        </div>
        <div class="control-row">
            <div class="control-info">
                <p class="gras">Contrôle n°3</p>
                <p class="date">20/01/2025</p>
            </div>
            <div class="control-note">12/20</div>
        </div>
        <div class="control-row">
            <div class="control-info">
                <p class="gras">Contrôle n°4</p>
                <p class="date">27/01/2025</p>
            </div>
            <div class="control-note">14/20</div>
        </div>
        <div class="control-row">
            <div class="control-info">
                <p class="gras">Contrôle n°5</p>
                <p class="date">03/02/2025</p>
            </div>
            <div class="control-note">16/20</div>
        </div>
        <div class="separator"></div>
        <div class="control-row">
            <div class="control-info">
                <p class="gras">Moyenne</p>
            </div>
            <div class="control-note">13.4/20</div>
        </div>
    </div>

</div>

</section>
</body>
</html>
