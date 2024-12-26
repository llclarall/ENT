<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Annie+Use+Your+Telescope&family=Barriecito&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <div class="container">
    <div class="left-block">
        <h1 class="bienvenue">Bienvenue sur l’ENT 
            de Gustave Eiffel</h1>

    </div>
    <div class="right-section">
    <h1>Se connecter</h1>

      <form class="login-form">
        <h2>Entrez votre login et mot de passe</h2>
        <label for="username" class="connect" >Nom d'utilisateur</label>
        <input type="text" id="username" name="username" placeholder="Entrez votre nom d'utilisateur" required>
        
        <label for="password" class="connect">Mot de passe</label>
        <input type="password" class="connect" id="password" name="password" placeholder="Entrez votre mot de passe" required>
        
        
        <button type="submit" class="connecter">Se connecter</button>

    </form>
    </div>
</div>

</body>
</html>