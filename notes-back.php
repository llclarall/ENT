<?php
include 'header-back.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $num_etudiant = $_POST['num_etudiant'];
    $matiere = $_POST['matiere'];
    $controle_nom = $_POST['controle_nom'];
    $date = $_POST['date'];
    $note = $_POST['note'];
    $semestre = $_POST['semestre'];

    // Insérer la note dans la base de données
    $query = "INSERT INTO notes (etudiant_num, matiere, controle_nom, date, note, semestre) 
              VALUES (:num_etudiant, :matiere, :controle_nom, :date, :note, :semestre)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':num_etudiant', $num_etudiant);
    $stmt->bindParam(':matiere', $matiere);
    $stmt->bindParam(':controle_nom', $controle_nom);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':note', $note);
    $stmt->bindParam(':semestre', $semestre);

    if ($stmt->execute()) {
        $message = "Note ajoutée avec succès !";
    } else {
        $message = "Erreur lors de l'ajout de la note.";
    }
}
?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertion des Notes</title>
</head>
<body>

<section class="page-insert-notes" id="content">
    <h1>Insertion des Notes</h1>

    <div class="container">
        
        <?php if (!empty($message)) : ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="num_etudiant">Étudiant :</label>
            <select id="num_etudiant" name="num_etudiant" required>
                <?php
                $query = "SELECT num_etudiant, nom, prenom FROM utilisateurs WHERE role = 'etudiant' ORDER BY nom ASC ";
                $stmt = $db->prepare($query);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . htmlspecialchars($row['num_etudiant']) . "'>" . htmlspecialchars($row['nom'] . ' ' . $row['prenom']) . "</option>";
                }
                ?>
            </select>
            <label for="matiere">Matière :</label>
            <input type="text" id="matiere" name="matiere" required>
            <label for="controle_nom">Nom du Contrôle :</label>
            <input type="text" id="controle_nom" name="controle_nom" required>
            <label for="date">Date :</label>
            <input type="date" id="date" name="date" required>
            <label for="note">Note :</label>
            <input type="number" id="note" name="note" step="0.01" min="0" max="20" required>
            <label for="semestre">Semestre :</label>
            <select id="semestre" name="semestre" required>
                <option value="semestre1">Semestre 1</option>
                <option value="semestre2">Semestre 2</option>
            </select>
            <button type="submit">Ajouter la Note</button>
        </form>
    </div>

</section>

</body>
</html>
