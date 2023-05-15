import {default as Modal} from './modal';

Modal.advanced({
  title: 'Hello',
  content: 'This modal is not closable via clicking the backdrop.',
  size: Modal.sizes.small,
  staticBackdrop: true
});
