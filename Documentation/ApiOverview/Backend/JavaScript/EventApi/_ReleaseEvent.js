import RegularEvent from '@typo3/core/event/regular-event.js';

const clickEvent = new RegularEvent('click', function (e) {
  // Do something
});
clickEvent.bindTo(document.querySelector('#my-button'));

// Do more stuff

clickEvent.release();
