<?php
include 'header-back.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload PDF et Informations</title>
    <link rel="stylesheet" href="style.css"> <!-- Si vous avez un fichier CSS -->
</head>
<body>
<section class="page-notes-pdf" id="content">
    <h1>Importer des notes via un fichier PDF</h1>
    
        <form action="process_pdf.php" method="POST" enctype="multipart/form-data">

            <!-- Groupe Semestre et Compétence -->
            <div class="group">
                <div>
                    <label for="semestre">Semestre :</label>
                    <select name="semestre" id="semestre" required>
                        <option value="semestre1">Semestre 1</option>
                        <option value="semestre2">Semestre 2</option>
                    </select>
                </div>
                <div>
                    <label for="competence">Compétence :</label>
                    <select name="competence" id="competence" required>
                    <option value="">Sélectionnez une compétence</option>
                        <option value="CONCEVOIR">CONCEVOIR</option>
                        <option value="COMPRENDRE">COMPRENDRE</option>
                        <option value="EXPRIMER">EXPRIMER</option>
                        <option value="DEVELOPPER">DEVELOPPER</option>
                        <option value="ENTREPRENDRE">ENTREPRENDRE</option>
                    </select>
                </div>
            </div>
            
            <!-- Groupe Professeur et Matière -->
            <div class="group">
                <div>
                    <?php
                    // Récupérer les informations des professeurs depuis la base de données
                    $sql = "SELECT * FROM utilisateurs WHERE role = 'prof'";
                    $stmt = $db->query($sql);
                    ?>
                    <label for="professeur">Nom du professeur :</label>
                    <select name="professeur" id="professeur" required>
                        <option value="">Sélectionnez un professeur</option>
                        <?php
                        $sql = "SELECT id, nom, prenom FROM utilisateurs WHERE role = 'prof'";
                        $stmt = $db->query($sql);

                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['prenom'] . " " . $row['nom'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Aucun professeur trouvé</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="matiere">Matière :</label>
                    <input type="text" name="matiere" id="matiere" required><br><br>
                </div>
            </div>
            
            <!-- Groupe Contrôle et Date -->
            <div class="group">
                <div>
                    <label for="controle">Nom du contrôle :</label>
                    <input type="text" name="controle" id="controle" required><br><br>
                </div>
                <div>
                    <label for="date">Date :</label>
                    <input type="date" name="date" id="date" required><br><br>
                </div>
            </div>
            
            <!-- Champ Fichier PDF -->
            <label for="fichier_notes">Sélectionnez un fichier notes PDF :</label>
            <input type="file" name="fichier_notes" id="fichier_notes" accept=".pdf" required><br><br>
            
            <button type="submit">Envoyer</button>
        </form>
        
</section>

<?php include('footer.php');?>
</body>
</html>
