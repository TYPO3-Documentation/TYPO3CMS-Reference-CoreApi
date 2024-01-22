import RegularEvent from '@typo3/core/event/regular-event.js';

new RegularEvent('click', function (e) {
  // Do something
}).bindTo(document.querySelector('#my-element'));
