import Modal, { Size } from '@typo3/backend/modal.js';

Modal.advanced({
  title: 'New page',
  content: 'A form that grows downwards',
  // Medium width, large height
  size: {
    width: Size.medium,
    height: Size.large,
  },
});
