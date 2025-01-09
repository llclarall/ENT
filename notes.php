<?php
include 'header.php';
include 'nav.php';



$num_etudiant = $_SESSION['num_etudiant'];


if (isset($_GET['mark_as_read'])) {
    $update_query = "UPDATE notes SET consulted = 1 WHERE consulted = 0 AND etudiant_num = :num_etudiant";
    $stmt = $db->prepare($update_query);
    $stmt->bindParam(':num_etudiant', $num_etudiant);
    $stmt->execute();
}

?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENT | Notes</title>
    <script>
        // Fonction pour soumettre automatiquement le formulaire lors du changement de sélection
        function submitForm() {
            document.getElementById("semester-form").submit();
        }
    </script>
</head>
<body>

<section class="page-notes">
    <h1>Notes</h1>

    <div class="container">
        <div class="small-boxes">
            <h3>Matières</h3>
            <?php
            // Récupérer toutes les matières distinctes pour l'utilisateur connecté
            $query = "SELECT DISTINCT matiere FROM notes WHERE etudiant_num = :num_etudiant";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':num_etudiant', $num_etudiant);
            $stmt->execute();

            // Afficher chaque matière dans une boîte
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='small-box'>" . htmlspecialchars($row['matiere']) . "</div>";
            }
            ?>
        </div>

        <div class="large-box">
            <!-- Formulaire pour choisir le semestre (avec soumission automatique) -->
            <form method="POST" action="" id="semester-form">
                <div class="semester-dropdown">
                    <select id="semester" name="semester" onchange="submitForm()">
                        <option value="" disabled selected>Choix du semestre</option>
                        <option value="semestre1" <?php echo isset($_POST['semester']) && $_POST['semester'] == 'semestre1' ? 'selected' : ''; ?>>Semestre 1</option>
                        <option value="semestre2" <?php echo isset($_POST['semester']) && $_POST['semester'] == 'semestre2' ? 'selected' : ''; ?>>Semestre 2</option>
                    </select>
                </div>
            </form>

            <?php
            // Sélectionner toutes les notes pour un semestre spécifique et l'utilisateur connecté
            if (isset($_POST['semester'])) {
                $semester = $_POST['semester'];
                $query = "SELECT * FROM notes WHERE semestre = :semester AND etudiant_num = :num_etudiant";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':semester', $semester);
                $stmt->bindParam(':num_etudiant', $num_etudiant);
                $stmt->execute();
            } else {
                // Par défaut afficher les notes pour le semestre 1
                $query = "SELECT * FROM notes WHERE semestre = 'semestre1' AND etudiant_num = :num_etudiant";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':num_etudiant', $num_etudiant);
                $stmt->execute();
            }

            // Afficher les contrôles et leurs notes
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='control-row'>";
                echo "<div class='control-info'>";
                echo "<p class='gras'>" . htmlspecialchars($row['controle_nom']) . "</p>";
                $date = new DateTime($row['date']);
                echo "<p class='date'>" . $date->format('d/m/Y') . "</p>";
                echo "</div>";
                echo "<div class='control-note'>" . htmlspecialchars($row['note']) . "/20</div>";
                echo "</div>";
            }
            ?>

            <div class="separator"></div>
            <div class="control-row">
                <div class="control-info">
                    <p class="gras">Moyenne</p>
                </div>
                <?php
                // Calculer la moyenne pour l'utilisateur connecté
                if (isset($semester)) {
                    $query = "SELECT AVG(note) AS moyenne FROM notes WHERE semestre = :semester AND etudiant_num = :num_etudiant";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':semester', $semester);
                    $stmt->bindParam(':num_etudiant', $num_etudiant);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    // Vérifier si la moyenne est null et la définir sur 0 si nécessaire
                    $moyenne = $row['moyenne'] ?? 0;  
                    echo "<div class='control-note'>" . number_format($moyenne, 2) . "/20</div>";
                }
                ?>
            </div>
        </div>

    </div>

</section>

</body>
</html>
