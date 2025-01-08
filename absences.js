document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("justification-modal");
  const justifyButtons = document.querySelectorAll('.justify-btn');
  const validateButton = document.getElementById("validate-justification");
  const cancelButton = document.getElementById('cancel-justification');
  const reasonSelect = document.getElementById("reason");
  const documentInput = document.getElementById("document");
  const commentInput = document.getElementById("comment");

  let currentRow = null;
  let absenceId = null;

  // Ouvrir la modale lorsqu'on clique sur un bouton pour justifier une absence
  justifyButtons.forEach(button => {
    button.addEventListener('click', function() {
      absenceId = this.closest('tr').dataset.absenceId;
      document.getElementById('absence-id').value = absenceId;
      modal.style.display = 'flex';
      reasonSelect.focus();
    });
  });

  // Fermer la modale avec le bouton Annuler
  cancelButton.addEventListener('click', function() {
    modal.style.display = 'none';
    clearModalFields();
  });

  // Validation du formulaire et envoi des données
  validateButton.addEventListener("click", () => {
    const reason = reasonSelect.value;
    const documentFile = documentInput.files[0];
    const comment = commentInput.value;

    if (!reason) {
      alert("Veuillez choisir une raison.");
      return;
    }

    if (!documentFile) {
      alert("Veuillez télécharger un document.");
      return;
    }

    const formData = new FormData();
    formData.append("absence_id", absenceId);
    formData.append("reason", reason);
    formData.append("comment", comment);
    formData.append("document", documentFile);

    fetch("justifier_absence.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (response.ok) {
          return response.text();
        } else {
          throw new Error("Erreur lors de l'enregistrement de la justification.");
        }
      })
      .then((message) => {
        alert(message);

        if (currentRow) {
          const justificationCell = currentRow.querySelector("td:last-child");
          justificationCell.textContent = "En attente de validation";
        }

        modal.style.display = "none";
        clearModalFields();
      })
      .catch((error) => {
        console.error(error);
        alert("Une erreur est survenue. Veuillez réessayer.");
      });
  });

  // Fermer la modale si l'utilisateur clique en dehors de celle-ci
  window.addEventListener("click", (e) => {
    // Si le clic est en dehors de la modale (mais pas sur des éléments internes), on la ferme
    if (e.target === modal) {
      modal.style.display = "none";
      clearModalFields();
    }
  });

  // Réinitialiser les champs de la modale
/*   const clearModalFields = () => {
    reasonSelect.value = "";
    documentInput.value = "";
    commentInput.value = "";
    currentRow = null;
    absenceId = null;
  }; */
});
