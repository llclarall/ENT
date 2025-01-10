<?php
include 'header-back.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload PDF</title>
</head>
<body>
    <h1>Importer des notes via un fichier PDF</h1>
    <form action="process_pdf.php" method="POST" enctype="multipart/form-data">
        <label for="pdf_file">Sélectionnez un fichier PDF :</label>
        <input type="file" name="pdf_file" id="pdf_file" accept=".pdf" required>
        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
