<?php
require_once 'config.php'; 
require_once 'libs/TCPDF/tcpdf.php';

spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . '/libs/pdfparser/src/';
    $file = $baseDir . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use Smalot\PdfParser\Parser;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fichier_notes']) && $_FILES['fichier_notes']['error'] === UPLOAD_ERR_OK) {
    // Récupérer les informations saisies manuellement
    $professeur = $_POST['professeur'];
    $competence = $_POST['competence'];
    $controle = $_POST['controle'];
    $matiere = $_POST['matiere'];
    $semestre = $_POST['semestre'];
    $date = $_POST['date'];

    // Vérifier si le fichier est un PDF
    $fileTmpPath = $_FILES['fichier_notes']['tmp_name'];
    $fileName = $_FILES['fichier_notes']['name'];
    $fileSize = $_FILES['fichier_notes']['size'];
    $fileType = $_FILES['fichier_notes']['type'];

    if ($fileType !== 'application/pdf') {
        die('Le fichier téléchargé n\'est pas un PDF.');
    }

    // Déplacer le fichier vers le dossier souhaité
    $uploadDir = 'uploads_notes/';
    $destinationPath = $uploadDir . $fileName;

    if (move_uploaded_file($fileTmpPath, $destinationPath)) {
        try {
            // Initialiser le parser PDF
            $parser = new Parser();
            $pdf = $parser->parseFile($destinationPath);

            // Extraire le texte du PDF
            $text = $pdf->getText();

            // Traitement du texte pour trouver les lignes contenant les notes
            $lines = explode("\n", $text);
            foreach ($lines as $line) {
                if (preg_match('/^(\d{6})\s+([\d,.]+)/', $line, $matches)) {
                    $etudiant_num = $matches[1];
                    $note = str_replace(',', '.', $matches[2]); // Remplacer virgules par des points

                    // Préparation de l'insertion dans la base de données
                    $query = "INSERT INTO notes (etudiant_num, note, matiere, semestre, prof_id, competence, controle_nom, date)
                              VALUES (:etudiant_num, :note, :matiere, :semestre, :professeur, :competence, :controle, :date)";
                    $stmt = $db->prepare($query);
                    $stmt->execute([
                        ':etudiant_num' => $etudiant_num,
                        ':note' => $note,
                        ':matiere' => $matiere,
                        ':semestre' => $semestre,
                        ':professeur' => $professeur,
                        ':competence' => $competence,
                        ':controle' => $controle,
                        ':date' => $date 
                    ]);
                }
            }

            echo "<script>alert('Les notes ont été insérées avec succès.'); window.location.href='notes-back-pdf.php';</script>";
        } catch (Exception $e) {
            echo "Erreur lors de l'analyse du fichier PDF : " . $e->getMessage();
        }
    } else {
        echo 'Erreur lors du téléchargement du fichier.';
    }
} else {
    echo 'Aucun fichier téléchargé ou erreur de téléchargement.';
}
?>
