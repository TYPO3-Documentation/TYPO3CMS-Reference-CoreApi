import RegularEvent from '@typo3/core/event/regular-event';

new RegularEvent('click', function (e) {
  // Do something
}).bindTo(document.querySelector('#my-element'));
