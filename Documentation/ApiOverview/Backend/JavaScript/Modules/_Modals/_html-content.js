import Modal from '@typo3/backend/modal.js';
import { html } from 'lit';

button.addEventListener('click', (event) => {
  event.preventDefault();

  Modal.advanced({
    title: 'A header',
    content: html`<p>This is <strong>bold</strong> HTML content.</p>`,
    size: Modal.sizes.large,
  });
});
