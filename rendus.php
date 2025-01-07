<?php
include('header.php');
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
$stmt->bindParam(':fk_user', $id, PDO::PARAM_INT);
$stmt->execute();
$rendus = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'ajouter') {
    // Récupérer les données du formulaire
    $titre = ($_POST['titre']);
    $description = ($_POST['description']);
    $date = $_POST['date']; 

    // Si l'utilisateur est connecté, on ajoute fk_user
    $fk_user = $_SESSION['id'];

    // Requête pour insérer un rendu
    $requete = "INSERT INTO rendus (titre, description, date, etat, fk_user) VALUES (:titre, :description, :date, :etat, :fk_user)";
    $stmt = $db->prepare($requete);

    // Lier les paramètres
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':date', $date);
    $stmt->bindValue(':etat', $etat = 'a-faire'); // Par défaut, l'état est "Pas commencé"
    $stmt->bindParam(':fk_user', $fk_user);

    // Exécuter la requête
    if ($stmt->execute()) {
        header("Location: rendus.php"); 
        exit();
    } else {
        echo "Erreur lors de l'ajout du rendu.";
    }
}

// Récupérer les rendus épinglés pour l'utilisateur connecté
$pinnedRendus = [];
if (isset($_SESSION['id'])) {
    $stmt = $db->prepare("SELECT fk_rendu FROM pins WHERE fk_user = :fk_user");
    $stmt->execute(['fk_user' => $_SESSION['id']]);
    $pinnedRendus = $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// Récupérer l'état spécifique à l'utilisateur pour chaque rendu
$etat_rendus = [];
foreach ($rendus as $rendu) {
    $requete_etat = "SELECT etat FROM etats_rendus WHERE fk_rendu = :fk_rendu AND fk_user = :fk_user";
    $stmt_etat = $db->prepare($requete_etat);
    $stmt_etat->bindParam(':fk_rendu', $rendu['id']);
    $stmt_etat->bindParam(':fk_user', $id);
    $stmt_etat->execute();
    $etat_user = $stmt_etat->fetch(PDO::FETCH_ASSOC);

    // Si l'état n'existe pas pour cet utilisateur, on l'ajoute à l'array avec l'état par défaut du rendu
    $etat_rendus[$rendu['id']] = $etat_user ? $etat_user['etat'] : $rendu['etat'];

}


// Traiter la suppression d'un rendu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'supprimer') {
    $delete_id = $_POST['delete_id'];

    $requete = "DELETE FROM rendus WHERE id = :id AND fk_user = :fk_user";
    $stmt = $db->prepare($requete);
    $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
    $stmt->bindParam(':fk_user', $_SESSION['id'], PDO::PARAM_INT);    

    if ($stmt->execute()) {
        header("Location: rendus.php"); 
        exit();
    } else {
        echo "Erreur lors de la suppression du rendu.";
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
                <input type="hidden" name="action" value="ajouter">
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
    <div class="rendu-card <?= in_array($rendu['id'], $pinnedRendus) ? 'pinned' : ''; ?>" id="rendu-<?= $rendu['id'] ?>">
        <img src="images/pin.png" alt="" class="pin" onclick="pinRendu(<?= $rendu['id'] ?>)">
       
        <!-- Boutons Modifier et Supprimer -->
        <?php if ($rendu['fk_user'] == $_SESSION['id']): ?>
            <div class="rendu-actions">

                <!-- Supprimer -->
                <form action="rendus.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rendu ?')">
                    <input type="hidden" name="action" value="supprimer">
                    <input type="hidden" name="delete_id" value="<?= $rendu['id'] ?>">
                    <button type="submit" class="supprimer-rendu-btn"><img src="images/supprimer.png" alt="Supprimer Rendu" class="supprimer-rendu"></button>
                </form>

            </div>
        <?php endif; ?>

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
            <select id="etat-<?= $rendu['id'] ?>" class="etat <?= $etat_rendus[$rendu['id']] ?>" onchange="updateEtat(<?= $rendu['id'] ?>, this.value)">
                <option value="a-faire" <?= $etat_rendus[$rendu['id']] === 'a-faire' ? 'selected' : '' ?>>Pas commencé</option>
                <option value="en-cours" <?= $etat_rendus[$rendu['id']] === 'en-cours' ? 'selected' : '' ?>>En cours</option>
                <option value="fait" <?= $etat_rendus[$rendu['id']] === 'fait' ? 'selected' : '' ?>>Terminé</option>
            </select>
        </div>



        <a href="#" data-id="<?= $rendu['id'] ?>" data-titre="<?= $rendu['titre'] ?>" data-description="<?= $rendu['description'] ?>" data-user-id="<?= $user['id'] ?>" onclick="openModal(event)">Consulter et déposer</a>


        <!-- Modale ajout tâches et zone de dépôt -->
        <div id="modal-tasks" class="modal-tasks" style="display: none;" onclick="closeModal(event)">
            <div class="modal-content" onclick="event.stopPropagation()">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2 id="modal-title"><?= $rendu['titre'] ?></h2>
                <p id="modal-description"><?= $rendu['description'] ?></p>
                
                <ul id="taskList" class="taskList">
                    <!-- Les tâches seront ajoutées ici -->
                </ul>

                <!-- Formulaire pour ajouter une tâche -->
                <div class="task-form">
                    <input type="text" id="taskInput" placeholder="Ajouter une tâche" class="taskInput" onkeydown="checkEnter(event)"/>
                    <button onclick="addTask()" class="addTask-btn">Ajouter</button>
                </div>

<br>
                <h3>Zone de dépôt</h3>
                <form id="drop-zone" class="drop-zone" ondragover="allowDrop(event)" 
                ondrop="handleDrop(event)" onclick="triggerFileInput()">

                    <p>Déposez votre fichier ici ou cliquez pour sélectionner</p>
                    <input type="file" id="fileInput" onchange="handleFileSelect(event)" style="display: none;" />
                    
                    <!-- Champs cachés pour stocker les identifiants -->
                    <input type="hidden" id="userId" value="<?=$user['id']?>">
                    <input type="hidden" id="renduId" name="renduId" value="">

                                
                    
                </form>

                <button id="renderFileButton" onclick="renderFile()" style="display: none;" class="render-btn">Rendre le fichier</button>


             <!-- Récupérer les fichiers associés à l'utilisateur et au rendu -->
                <h3>Fichiers rendus</h3>

                <div id="file-info" class="file-info"></div>
                
        </div>
    </div>

</div>
<?php endforeach; ?>


</div>


</section>
    
<script src="rendus.js"></script>
</body>
</html>