import RegularEvent from '@typo3/core/event/regular-event';

new RegularEvent('click', function (e) {
  e.preventDefault();
  window.location.reload();
}).bindTo(document.querySelector('#my-element'));
