composer require smalot/pdfparser


<?php
require 'vendor/autoload.php';
include 'config.php';
use Smalot\PdfParser\Parser;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['pdf_file'])) {
    // Vérifiez que le fichier a été uploadé sans erreur
    if ($_FILES['pdf_file']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['pdf_file']['tmp_name'];

        // Analyse du fichier PDF
        $parser = new Parser();
        $pdf = $parser->parseFile($file_tmp);
        $text = $pdf->getText();

        // Exemple : Supposons que chaque ligne du PDF est formatée comme "num_etudiant;nom;note"
        $lines = explode("\n", $text);
        $notes_data = [];

        foreach ($lines as $line) {
            $fields = explode(";", $line);
            if (count($fields) === 3) {
                $notes_data[] = [
                    'num_etudiant' => trim($fields[0]),
                    'nom' => trim($fields[1]),
                    'note' => trim($fields[2])
                ];
            }
        }

        // Insertion des données dans la table "notes"
        foreach ($notes_data as $data) {
            $stmt = $db->prepare("INSERT INTO notes (etudiant_num, controle_nom, note, semestre) VALUES (:num_etudiant, :controle_nom, :note, :semestre)");
            $stmt->execute([
                ':num_etudiant' => $data['num_etudiant'],
                ':controle_nom' => 'Nom du contrôle', // À remplacer ou dynamiser
                ':note' => $data['note'],
                ':semestre' => 'semestre1' // À ajuster selon les besoins
            ]);
        }

        echo "Les notes ont été insérées avec succès !";
    } else {
        echo "Erreur lors de l'upload du fichier.";
    }
} else {
    echo "Aucun fichier reçu.";
}
?>
