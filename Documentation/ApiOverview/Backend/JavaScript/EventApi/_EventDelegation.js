import RegularEvent from '@typo3/core/event/regular-event';

new RegularEvent('click', function (e) {
  // Do something
}).delegateTo(document, 'a[data-action="toggle"]');
