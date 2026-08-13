import Modal from '@typo3/backend/modal.js';
import { html } from 'lit';
import { lll } from '@typo3/core/lit-helper.js';

button.addEventListener('click', (event) => {
  event.preventDefault();

  Modal.advanced({
    title: 'A header',
    content: html`<p>${lll('myExtension.modal.greeting', 'World')}</p>`,
    size: Modal.sizes.large,
  });
});
