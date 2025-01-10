<?php
include 'header.php';

$num_etudiant = $_SESSION['num_etudiant'];

// Définir le semestre sélectionné par défaut
$selected_semester = isset($_POST['semester']) ? $_POST['semester'] : 'semestre1';

// Vérification des notes non consultées pour les semestres
$query_check_semester1 = "SELECT COUNT(*) AS count FROM notes WHERE semestre = 'semestre1' AND etudiant_num = :num_etudiant AND consulted = 0";
$stmt_check_semester1 = $db->prepare($query_check_semester1);
$stmt_check_semester1->bindParam(':num_etudiant', $num_etudiant);
$stmt_check_semester1->execute();
$result_semester1 = $stmt_check_semester1->fetch(PDO::FETCH_ASSOC);

$query_check_semester2 = "SELECT COUNT(*) AS count FROM notes WHERE semestre = 'semestre2' AND etudiant_num = :num_etudiant AND consulted = 0";
$stmt_check_semester2 = $db->prepare($query_check_semester2);
$stmt_check_semester2->bindParam(':num_etudiant', $num_etudiant);
$stmt_check_semester2->execute();
$result_semester2 = $stmt_check_semester2->fetch(PDO::FETCH_ASSOC);

// Si il n'y a pas de notes non consultées dans le semestre 1, on redirige vers le semestre 2
if ($result_semester1['count'] == 0 && $result_semester2['count'] > 0) {
    $selected_semester = 'semestre2';
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

        document.addEventListener("DOMContentLoaded", () => {
            const buttons = document.querySelectorAll(".small-box");
            const rows = document.querySelectorAll(".control-row");

            buttons.forEach(button => {
                button.addEventListener("click", () => {
                    const competenceClass = button.dataset.competence;

                    if (button.classList.contains("active")) {
                        // Si le bouton est actif, réinitialise tout
                        rows.forEach(row => row.style.display = "flex");
                        buttons.forEach(btn => btn.classList.remove("active"));
                    } else {
                        // Filtrer les éléments en fonction de la compétence
                        rows.forEach(row => {
                            if (row.classList.contains(competenceClass)) {
                                row.style.display = "flex";
                            } else {
                                row.style.display = "none";
                            }
                        });

                        // Activer le bouton cliqué et désactiver les autres
                        buttons.forEach(btn => btn.classList.remove("active"));
                        button.classList.add("active");
                    }
                });
            });
        });
    </script>
</head>
<body>

<section class="page-notes" id="content">
    <h1>Notes</h1>

    <div class="container">
        <div class="small-boxes">
            <h3>Compétences</h3>
            <?php

            // Récupérer toutes les matières distinctes pour l'utilisateur connecté
            $query = "SELECT DISTINCT competence FROM notes";
            $stmt = $db->prepare($query);
            $stmt->execute();

            // Afficher chaque compétence dans une boîte
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $competenceClass = str_replace(' ', '-', strtolower($row['competence']));

                $query_count = "SELECT COUNT(*) AS count FROM notes WHERE competence = :competence AND etudiant_num = :num_etudiant AND semestre = :semester";
                $stmt_count = $db->prepare($query_count);
                $stmt_count->bindParam(':competence', $row['competence']);
                $stmt_count->bindParam(':num_etudiant', $num_etudiant);
                $stmt_count->bindParam(':semester', $selected_semester);
                $stmt_count->execute();
                $count_row = $stmt_count->fetch(PDO::FETCH_ASSOC);

                echo "<button class='small-box' data-competence='$competenceClass'>" . htmlspecialchars($row['competence']) . " (". $count_row['count'] .") </button>";
            }
            ?>
        </div>

        <div class="large-box">
            <!-- Formulaire pour choisir le semestre (avec soumission automatique) -->
            <form method="POST" action="" id="semester-form">
                <div class="semester-dropdown">
                    <select id="semester" name="semester" onchange="submitForm()">
                        <option value="semestre1" <?php echo ($selected_semester == 'semestre1') ? 'selected' : ''; ?>>Semestre 1</option>
                        <option value="semestre2" <?php echo ($selected_semester == 'semestre2') ? 'selected' : ''; ?>>Semestre 2</option>
                    </select>
                </div>
            </form>

            <?php
            // Sélectionner toutes les notes pour un semestre spécifique et l'utilisateur connecté
            $query = "SELECT * FROM notes WHERE semestre = :semester AND etudiant_num = :num_etudiant";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':semester', $selected_semester);
            $stmt->bindParam(':num_etudiant', $num_etudiant);
            $stmt->execute();

            // Afficher les contrôles et leurs notes
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $competenceClass = str_replace(' ', '-', strtolower($row['competence']));
                echo "<div class='control-row $competenceClass'>";
                echo "<div class='control-info'>";                
                
                // Ajouter une icône si consulted = 0
                if ($row['consulted'] == 0) {
                    echo " <p class='gras'><i class='fa-solid fa-circle-exclamation' title='Nouvelle note'></i>" . htmlspecialchars($row['controle_nom']) . "</p>";
                }
                else {
                    echo "<p class='gras'>" . htmlspecialchars($row['controle_nom']) . "</p>";
                }

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
                $query = "SELECT AVG(note) AS moyenne FROM notes WHERE semestre = :semester AND etudiant_num = :num_etudiant";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':semester', $selected_semester);
                $stmt->bindParam(':num_etudiant', $num_etudiant);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Vérifier si la moyenne est null et la définir sur 0 si nécessaire
                $moyenne = $row['moyenne'] ?? 0;  
                echo "<div class='control-note'>" . number_format($moyenne, 2) . "/20</div>";
                ?>
            </div>
        </div>

    </div>

</section>

<?php include('footer.php');?>

</body>
</html>


<?php

// Met à jour le champ 'consulted' pour les notes consultées par l'utilisateur
function markNotesAsRead($db, $num_etudiant) {
    $update_query = "UPDATE notes SET consulted = 1 WHERE consulted = 0 AND etudiant_num = :num_etudiant";
    $stmt = $db->prepare($update_query);
    $stmt->bindParam(':num_etudiant', $num_etudiant);
    $stmt->execute();
}

markNotesAsRead($db, $num_etudiant);
?>