<?php
include 'header.php';
include 'nav.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Absences</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<section class="page-absences">

<h1>ENT | Absences</h1>

  <main class="container">

    <div id="total-hours" class="total-hours">
      <h2>Total des heures manquées : <span id="total-missed" class="total-missed">4</span> heures</h2>
    </div>
    
    <div id="absences">
      <h2>Détails des absences</h2>

      <table id="absences-table" role="table" aria-labelledby="absences-table">
        <thead>
          <tr class="table-header">
            <th   scope="col">Date</th>
            <th scope="col">Durée (heures)</th>
            <th scope="col">Justification</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Le 13/01/2025 à 10h15</td>
            <td class="duration">2:00</td>
            <td><button class="justify-btn" aria-label="Justifier l'absence de cette date">À justifier</button></td>
          </tr>
          <tr>
            <td>Le 10/01/2025 à 13h30</td>
            <td class="duration">2:00</td>
            <td><button class="justify-btn" aria-label="Justifier l'absence de cette date">À justifier</button></td>
          </tr>
          <tr>
            <td>Le 18/12/2024 à 15h30</td>
            <td class="duration">2:00</td>
            <td>Justifié</td>
          </tr>
          <tr>
            <td>Le 18/12/2024 à 10h30</td>
            <td class="duration">2:00</td>
            <td>Justifié</td>
          </tr>
        </tbody>
      </table>
    </div>
      
    
      <!-- Modal pour la justification -->
      <div id="justification-modal" class="modal" role="dialog" aria-labelledby="modal-title" aria-hidden="true">

      <div class="modal-content">
      <h3 id="modal-title">Justification de l'absence</h3>
      <label for="reason">Raison (obligatoire) :</label>
      <select id="reason" required aria-required="true">
        <option value="" disabled selected>Choisissez votre raison ci-dessous</option>
        <option value="illness">Maladie</option>
        <option value="transport">Problème de transport</option>
        <option value="family">Urgence familiale</option>
        <option value="other">Autre</option>
      </select>
      <br><br>
      <label for="document">Télécharger un document (obligatoire) :</label>
      <input type="file" id="document" accept="application/pdf,.doc,.docx,.png" required aria-required="true">
    
      <small>Les documents acceptés sont au format PDF, PNG, DOC ou DOCX.</small>
      <br><br>
      <label for="comment">Commentaire (facultatif) :</label>
      <textarea id="comment" rows="4" placeholder="Ajouter un commentaire..."></textarea>
      <br><br>
      <button id="validate-justification" aria-label="Valider la justification">Valider</button>
      <button id="cancel-justification" class="cancel-justification" aria-label="Annuler la justification">Annuler</button>
      </div>
    </div>


  </main>
</section>

<script src="absences.js"></script>
</body>
</html>
