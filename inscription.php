<?php 
include 'header-back.php';
?>

<title>Back-Office | Inscription</title>

<section class="page-inscription" id="content">

<h1>Inscription</h1>
<div class="container">
    
    <form action="traite_inscription.php" method="post" onsubmit="return verifierFormulaire()">
        <label for="role">Rôle :</label>
        <select name="role" id="role" required onchange="genererInfos()">
            <option value="">Sélectionner un rôle</option>
            <option value="etudiant">Étudiant</option>
            <option value="prof">Professeur</option>
        </select>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required><br>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br>

        <label for="num_etudiant">Numéro d'étudiant (automatique pour étudiant)</label><br>
        <input type="text" id="num_etudiant" name="num_etudiant" readonly><br>

        <label for="email">Email (automatique)</label><br>
        <input type="email" id="email" name="email" readonly><br>

        <label for="login">Login (automatique)</label><br>
        <input type="text" id="login" name="login" readonly><br>

        <label for="password">Mot de passe (automatique)</label><br>
        <input type="text" id="password" name="password" readonly><br>


        <input type="submit" value="Inscrire">
        <span>Tous les champs sont obligatoires</span>
    </form>
</div>

</section>



<script>

// Fonction pour générer un mot de passe aléatoire
function generatePassword() {
    let chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+";
    let password = "";
    for (let i = 0; i < 8; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return password;
}

// Fonction pour générer le login, l'email, le mot de passe et le numéro étudiant
function genererInfos() {
    let prenom = document.getElementById('prenom').value;
    let nom = document.getElementById('nom').value;
    let role = document.getElementById('role').value;

    if (prenom && nom) {
        // Générer le login
        let login = prenom.normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase() + '.' + nom.normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase();
        document.getElementById('login').value = login;

        // Générer le mot de passe
        let password = generatePassword();
        document.getElementById('password').value = password;

        // Gérer les informations en fonction du rôle sélectionné
        if (role === "etudiant") {
            // Numéro d'étudiant
            let numEtudiant = "27" + Math.floor(1000 + Math.random() * 9000); // Génère un numéro commençant par 26
            document.getElementById('num_etudiant').value = numEtudiant;

            // Email pour étudiant
            document.getElementById('email').value = login + "@edu.univ-eiffel.fr";
        } else if (role === "prof") {
            // Pas de numéro étudiant pour le professeur
            document.getElementById('num_etudiant').value = '0';

            // Email pour professeur
            document.getElementById('email').value = login + "@univ-eiffel.fr";
        }
    }
}

// Ajouter un événement pour mettre à jour les informations lorsque le prénom et nom sont modifiés
document.getElementById('prenom').addEventListener('input', genererInfos);
document.getElementById('nom').addEventListener('input', genererInfos);
document.getElementById('role').addEventListener('change', genererInfos);

</script>