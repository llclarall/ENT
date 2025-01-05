<?php
include('header.php');
include('config.php');
include('nav.php');

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


// Récupérer les rendus de l'utilisateur
$requete = "SELECT * FROM rendus WHERE fk_user = :fk_user OR fk_user is NULL";
$stmt = $db->prepare($requete);

// Lier l'id de l'utilisateur à la requête
$stmt->bindParam(':fk_user', $id, PDO::PARAM_INT);

// Exécuter la requête
$stmt->execute();
$rendus = $stmt->fetchAll(PDO::FETCH_ASSOC);



// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $titre = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);
    $date = $_POST['date']; // Date au format datetime-local

    // Si l'utilisateur est connecté, on ajoute fk_user
    $fk_user = $_SESSION['id'];

    // Requête pour insérer un rendu
    $requete = "INSERT INTO rendus (titre, description, date, fk_user) VALUES (:titre, :description, :date, :fk_user)";
    $stmt = $db->prepare($requete);

    // Lier les paramètres
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':fk_user', $fk_user);

    // Exécuter la requête
    if ($stmt->execute()) {
        header("Location: rendus.php"); // Rediriger vers la page des rendus après l'ajout
        exit();
    } else {
        echo "Erreur lors de l'ajout du rendu.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENT | Rendus</title>
</head>
<body>

<section class="page-rendus">

<h1>Rendus</h1>
<br>
<div class="rendus-container">

    <!-- Bouton d'ajout de rendu -->
    <div class="ajouter-rendu" id="openModalBtn">
        <img src="images/ajouter.png" alt="">
        <p>Ajouter un rendu</p>
    </div>


    <!-- Modale ajout rendu -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeModalBtn">&times;</span>
            <h2>Ajouter un Rendu</h2>
            
            <!-- Formulaire pour ajouter un rendu -->
            <form id="addRenduForm" method="POST" action="rendus.php">
                <label for="titre" required>Titre*</label>
                <input type="text" id="titre" name="titre" required>

                <label for="description">Description</label>
                <textarea id="description" name="description"></textarea>

                <label for="date">Date*</label>
                <input type="datetime-local" id="date" name="date" required><br><br>

                <button type="submit">Ajouter</button>
            </form>
        </div>
    </div>


    <!-- Rendu Card --> 
    <?php foreach ($rendus as $rendu): ?>
    <div class="rendu-card <?php echo $rendu['pinned'] == 1 ? 'pinned' : ''; ?>" id="rendu-<?= $rendu['id'] ?>">
        <img src="images/pin.png" alt="" class="pin" onclick="pinRendu(<?= $rendu['id'] ?>)">
        <h2><?= $rendu['titre'] ?></h2>
        <p class="description"><?= $rendu['description'] ?></p>
        <p>
            <?php 
            $dateTime = new DateTime($rendu['date']); 
            echo "Pour le " . $dateTime->format('d/m/y') . " à " . $dateTime->format('H\hi');
            ?>
        </p>

        <!-- Dropdown pour les états -->
        <div class="etats-dropdown">
            <label for="etat-<?= $rendu['id'] ?>" class="sr-only">État :</label>
            <select id="etat-<?= $rendu['id'] ?>" class="etat <?= $rendu['etat'] ?>" onchange="updateEtat(<?= $rendu['id'] ?>, this.value)">
                <option value="a-faire" <?= $rendu['etat'] === 'a-faire' ? 'selected' : '' ?>>Pas commencé</option>
                <option value="en-cours" <?= $rendu['etat'] === 'en-cours' ? 'selected' : '' ?>>En cours</option>
                <option value="fait" <?= $rendu['etat'] === 'fait' ? 'selected' : '' ?>>Terminé</option>
            </select>
        </div>

        <a href="rendu.php" onclick="openModal(event)">Consulter et déposer</a>

        <!-- Modale ajout tâches -->
        <div id="modal-tasks" class="modal-tasks" style="display: none;" onclick="closeModal(event)">
            <div class="modal-content" onclick="event.stopPropagation()">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2><?= $rendu['titre'] ?></h2>
                
                <ul id="taskList" class="taskList">
                    <!-- Les tâches seront ajoutées ici -->
                </ul>

                <!-- Formulaire pour ajouter une tâche -->
                <div class="task-form">
                    <input type="text" id="taskInput" placeholder="Ajouter une tâche" class="taskInput" onkeydown="checkEnter(event)"/>
                    <button onclick="addTask()">Ajouter</button>
                </div>

                <form id="drop-zone" class="drop-zone" onclick="triggerFileInput()">
                    <p>Déposez votre fichier ici ou cliquez pour sélectionner</p>
                    <input type="file" id="fileInput" onchange="handleFileSelect(event)" style="display: none;" />
                    
                    <!-- Champs cachés pour stocker les identifiants -->
                    <input type="hidden" id="userId" value="<?=$user['id']?>">
                    <input type="hidden" id="renduId" value="<?=$rendu['id']?>">
                    
                    <div id="file-info" class="file-info"></div>
                </form>

                <button id="renderFileButton" onclick="renderFile()" style="display: none;" class="render-btn">Rendre le fichier</button>


            </div>
        </div>
 

    </div>
    <?php endforeach; ?>


</div>


</section>
    
</body>
</html>