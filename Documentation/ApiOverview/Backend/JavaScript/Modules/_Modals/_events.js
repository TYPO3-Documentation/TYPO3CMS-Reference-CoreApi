import Modal from '@typo3/backend/modal.js';

const modal = Modal.confirm(
  'Delete the conference?',
  'The talks of the conference are deleted as well.',
);

modal.addEventListener('typo3-modal-hidden', () => {
  // Runs after the modal has been closed, no matter how
  document.querySelector('#delete-conference')?.focus();
});
