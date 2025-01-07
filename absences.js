


document.addEventListener("DOMContentLoaded", () => {
  const calculateTotalHours = () => {
    const durations = document.querySelectorAll(".duration");
    let total = 0;
  
    durations.forEach(duration => {
    total += parseInt(duration.textContent, 10);
    });
  
    document.getElementById("total-missed").textContent = total;
  };
  
  calculateTotalHours();
  
  // Fonctionnalité du modal
  const modal = document.getElementById("justification-modal");
  const justifyButtons = document.querySelectorAll(".justify-btn");
  const validateButton = document.getElementById("validate-justification");
  const cancelButton = document.getElementById("cancel-justification");
  const reasonSelect = document.getElementById("reason");
  const documentInput = document.getElementById("document");
  const commentInput = document.getElementById("comment");
  let currentRow = null;

  // Capturer le focus dans le modal
  const trapFocus = (e) => {
    const focusableElements = modal.querySelectorAll('button, select, input, textarea');
    const firstFocusable = focusableElements[0];
    const lastFocusable = focusableElements[focusableElements.length - 1];
    
    if (e.key === 'Tab') {
      if (e.shiftKey) { // shift + tab
        if (document.activeElement === firstFocusable) {
          lastFocusable.focus();
          e.preventDefault();
        }
      } else { // tab
        if (document.activeElement === lastFocusable) {
          firstFocusable.focus();
          e.preventDefault();
        }
      }
    } else if (e.key === 'Escape') {
      cancelButton.click();
    }
  };

  justifyButtons.forEach(button => {
    button.addEventListener("click", (e) => {
    modal.style.display = "flex";
    currentRow = e.target.closest("tr");
    modal.setAttribute('aria-hidden', 'false');
    firstFocusableElement.focus();
    document.addEventListener('keydown', trapFocus);
    });
  });

  cancelButton.addEventListener("click", () => {
    modal.style.display = "none";
    modal.setAttribute('aria-hidden', 'true');
    document.removeEventListener('keydown', trapFocus);
  });

  validateButton.addEventListener("click", () => {
    const reason = reasonSelect.value;
    const document = documentInput.files[0];
    const comment = commentInput.value;

    // Validation des champs obligatoires (Raison et Document)
    if (!reason) {
    alert("Veuillez choisir une raison.");
    return; 
    }

    if (!document) {
    alert("Veuillez télécharger un document.");
    return;
    }

    // Si la validation est réussie, mettre à jour la justification de l'absence
    if (currentRow) {
    const justificationCell = currentRow.querySelector("td:last-child");
    justificationCell.textContent = "En attente de validation"; 
    }

    modal.style.display = "none";
    modal.setAttribute('aria-hidden', 'true');
  });

  // Fermer la modale en cliquant à l'extérieur
  window.addEventListener("click", (e) => {
    if (e.target === modal) {
    modal.style.display = "none";
    modal.setAttribute('aria-hidden', 'true');
    document.removeEventListener('keydown', trapFocus);
    }
  });
  });
