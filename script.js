
// Fonction pour afficher ou masquer le mot de passe
function togglePassword(inputId, toggleElement) {
    const passwordInput = document.getElementById(inputId);

    // Vérifie le type actuel de l'input
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleElement.textContent = "🙈"; 
    } else {
        passwordInput.type = "password";
        toggleElement.textContent = "👁️"; 
    }
}