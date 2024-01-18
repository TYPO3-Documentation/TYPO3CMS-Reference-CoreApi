import RegularEvent from '@typo3/core/event/regular-event.js';

new RegularEvent('click', function (e) {
  e.preventDefault();
  window.location.reload();
}).bindTo(document.querySelector('#my-element'));
