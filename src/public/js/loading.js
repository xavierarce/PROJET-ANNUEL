// Loading utility functions
class LoadingManager {
  static addLoadingToForm(formElement, submitButtonText = "Chargement...") {
    const submitButton = formElement.querySelector('button[type="submit"]');
    if (!submitButton) return;

    // Store original text
    const originalText = submitButton.textContent;
    submitButton.dataset.originalText = originalText;
    let isLoading = false;
    let resetTimeoutId = null;

    formElement.addEventListener("submit", function (e) {
      if (isLoading) {
        e.preventDefault();
        return false;
      }

      // Handle confirmation dialogs
      const confirmMessage = submitButton.dataset.confirm;
      if (confirmMessage) {
        const confirmed = confirm(confirmMessage);
        if (!confirmed) {
          e.preventDefault();
          return false;
        }
      }

      isLoading = true;
      submitButton.disabled = true;
      submitButton.textContent = submitButtonText;
      submitButton.classList.add("loading");

      // Add visual loading indicator
      if (!submitButton.querySelector(".loading-spinner")) {
        const spinner = document.createElement("span");
        spinner.className = "loading-spinner";
        spinner.innerHTML = "⏳";
        submitButton.prepend(spinner);
      }

      // Store reset function for external access
      const resetFunction = () => {
        if (isLoading) {
          LoadingManager.resetButton(submitButton, originalText);
          isLoading = false;
          if (resetTimeoutId) {
            clearTimeout(resetTimeoutId);
            resetTimeoutId = null;
          }
        }
      };

      // Store reset function on the form for external access
      formElement._resetLoading = resetFunction;

      // Special handling for chat forms - shorter timeout but can be overridden
      const timeout = formElement.classList.contains("chat-form") ? 800 : 3000;

      // Auto-reset after timeout (fallback)
      resetTimeoutId = setTimeout(resetFunction, timeout);
    });

    // Reset loading state if form submission fails or page doesn't change
    window.addEventListener("beforeunload", function () {
      LoadingManager.resetButton(submitButton, originalText);
    });
  }

  static resetButton(button, originalText) {
    button.disabled = false;
    button.textContent = originalText;
    button.classList.remove("loading");
    const spinner = button.querySelector(".loading-spinner");
    if (spinner) spinner.remove();
  }

  static addLoadingToButton(buttonElement, loadingText = "Chargement...") {
    const originalText = buttonElement.textContent;
    let isLoading = false;

    buttonElement.addEventListener("click", function (e) {
      if (isLoading) {
        e.preventDefault();
        return false;
      }

      isLoading = true;
      buttonElement.disabled = true;
      buttonElement.textContent = loadingText;
      buttonElement.classList.add("loading");

      // Reset after a timeout (fallback)
      setTimeout(() => {
        LoadingManager.resetButton(buttonElement, originalText);
        isLoading = false;
      }, 5000);
    });
  }

  // Global utility to reset all chat form loading states
  static resetChatLoading() {
    const chatForms = document.querySelectorAll(".chat-form");
    chatForms.forEach((form) => {
      if (form._resetLoading) {
        form._resetLoading();
      }
    });
  }

  // Reset loading when new content appears (for socket updates)
  static observeContentChanges() {
    const messagesContainer = document.querySelector(".messages");
    if (!messagesContainer) return;

    const observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        if (mutation.type === "childList" && mutation.addedNodes.length > 0) {
          // New message added, reset chat loading
          LoadingManager.resetChatLoading();
        }
      });
    });

    observer.observe(messagesContainer, {
      childList: true,
      subtree: true,
    });
  }
}

// Auto-initialize on page load
document.addEventListener("DOMContentLoaded", function () {
  // Add loading to all forms with submit buttons
  const forms = document.querySelectorAll("form");
  forms.forEach((form) => {
    const submitButton = form.querySelector('button[type="submit"]');
    if (submitButton) {
      // Get custom loading text from data attribute or use default
      const loadingText = submitButton.dataset.loadingText || "Chargement...";
      LoadingManager.addLoadingToForm(form, loadingText);
    }
  });

  // Add loading to standalone buttons with data-loading attribute
  const loadingButtons = document.querySelectorAll("button[data-loading]");
  loadingButtons.forEach((button) => {
    const loadingText = button.dataset.loading || "Chargement...";
    LoadingManager.addLoadingToButton(button, loadingText);
  });

  // Observe content changes for chat messages
  LoadingManager.observeContentChanges();
});
