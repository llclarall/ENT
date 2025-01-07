<?php 

function telechargerEdtDepuisEnt($loginUrl, $edtUrl, $destination, $username, $password) {
    $ch = curl_init();

    // Étape 1 : Connexion au formulaire
    curl_setopt($ch, CURLOPT_URL, $loginUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'clara.moubarak' => $username,
        'EntmmICMo#09' => $password
    ]));
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt'); // Sauvegarde des cookies
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $connexion = curl_exec($ch);

    if (strpos($connexion, "Erreur") !== false) {
        die("Erreur : Connexion échouée. Vérifiez vos identifiants.\n");
    }

    // Étape 2 : Télécharger l'emploi du temps
    curl_setopt($ch, CURLOPT_URL, $edtUrl);
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt'); // Réutilisation des cookies
    $fichier = curl_exec($ch);

    if (curl_errno($ch)) {
        die("Erreur cURL : " . curl_error($ch) . "\n");
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode !== 200) {
        die("Erreur HTTP : $httpCode\n");
    }

    curl_close($ch);
    file_put_contents($destination, $fichier);
}

// Appel de la fonction
telechargerEdtDepuisEnt(
    "https://ent.univ-eiffel.fr/login", // URL du formulaire de connexion
    "https://ent.univ-eiffel.fr/edt.ics", // URL de l'emploi du temps
    "edt_semaine.ics",
    "clara.moubarak",
    "EntmmICMo#09"
);

?>