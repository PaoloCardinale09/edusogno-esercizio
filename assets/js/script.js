// FUNZIONE PER ABILITARE/NASCONDERE LA PASSWORD
function togglePassword() {
    const passwordInput = document.getElementById("password");
    const toggleBtn = document.querySelector(".password-toggle button");

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
    } else {
      passwordInput.type = "password";
      toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
    }
  };

// TIMEOUT MESSAGGIO ERRORE
document.addEventListener("DOMContentLoaded", function () {
  const errorMessageContainer = document.querySelector(".error-message");

  if (errorMessageContainer) {
      // Imposta un timer per nascondere automaticamente il messaggio di errore dopo 5 secondi
      setTimeout(function () {
          errorMessageContainer.style.display = "none";
      }, 5000);
  }
});