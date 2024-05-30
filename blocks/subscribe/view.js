/**
 * WordPress dependencies
 */
import { store, getContext } from '@wordpress/interactivity';

const { actions, state } = store('mailbob/subscription', {
  actions: {
    formSubmit: async (event) => {
      event.preventDefault();

      const form = event.target;
      const formData = new FormData(event.target);
      formData.append('action', 'mailbob_block_subscribe');
      formData.append('nonce', state.nonce);
      formData.append('postId', state.postId);

      const formObject = Object.fromEntries(formData.entries());

      const submitButton = form.querySelector('button');

      // Remove existing response messages
      const existingMessages = form.querySelectorAll('.mailbob-message');
      existingMessages.forEach((message) => message.remove());

      // Change button text and disable it
      const originalButtonText = submitButton.textContent;
      submitButton.textContent = state.loadingButtonText;
      submitButton.disabled = true;

      try {
        const response = await fetch(state.ajaxUrl, {
          method: 'POST',
          credentials: 'same-origin',
          body: formData,
        });

        if (!response.ok) {
          throw new Error('Network response was not ok');
        }

        const responseData = await response.text();

        const responseObj = JSON.parse(responseData);

        // Display error message
        const errorContainer = document.createElement('div');
        errorContainer.classList.add('mailbob-message');

        if (responseObj.success) {
          if (responseObj.data.success) {
            errorContainer.textContent = state.successMessage;
          } else {
            errorContainer.classList.add('mailbob-message--error');
            errorContainer.textContent = responseObj.data.message;
          }
        } else {
          errorContainer.classList.add('mailbob-message--error');
          errorContainer.textContent =
            state.errorMessage || responseObj.data.message;
        }

        event.target.appendChild(errorContainer);
      } catch (error) {
        console.log('Error:', error);
      } finally {
        submitButton.textContent = originalButtonText;
        submitButton.disabled = false;
      }
    },
  },
});
