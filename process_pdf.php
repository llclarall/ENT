<?php
require_once 'config.php'; 
require_once 'libs/TCPDF/tcpdf.php';
require_once 'libs/pdfparser/src/Smalot/PdfParser/Config.php';
require_once 'libs/pdfparser/src/Smalot/PdfParser/Parser.php';
require_once 'libs/pdfparser/src/Smalot/PdfParser/Document.php';
require_once 'libs/pdfparser/src/Smalot/PdfParser/Header.php';
require_once 'libs/pdfparser/src/Smalot/PdfParser/Page.php';
require_once 'libs/pdfparser/src/Smalot/PdfParser/Element.php';
require_once 'libs/pdfparser/src/Smalot/PdfParser/Font.php';
require_once 'libs/pdfparser/src/Smalot/PdfParser/Object.php';
require_once 'libs/pdfparser/src/Smalot/PdfParser/StreamObject.php';

use Smalot\PdfParser\Parser;

try {
    // Initialiser le parser
    $parser = new Parser();
    $pdf = $parser->parseFile('uploads_notes/fichier_notes.pdf');

    // Extraire le texte du PDF
    $text = $pdf->getText();

    echo nl2br($text);

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

// Traitement du texte pour trouver les lignes contenant les notes
$lines = explode("\n", $text);
foreach ($lines as $line) {
    if (preg_match('/^(\d{6})\s+([\d,.]+)/', $line, $matches)) {
        $etudiant_num = $matches[1];
        $note = str_replace(',', '.', $matches[2]); // Remplacer virgules par des points

        // Préparation de l'insertion
        $query = "INSERT INTO notes (etudiant_num, note, matiere, date)
                  VALUES (:etudiant_num, :note, :matiere, :date)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            ':etudiant_num' => $etudiant_num,
            ':note' => $note,
            ':matiere' => 'Dev Web Integration',
            ':date' => '2024-11-08' 
        ]);
    }
}

echo "Les notes ont été insérées avec succès.";
?>
