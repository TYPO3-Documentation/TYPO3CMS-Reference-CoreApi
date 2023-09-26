import RegularEvent from '@typo3/core/event/regular-event';

const clickEvent = new RegularEvent('click', function (e) {
  // Do something
}).delegateTo(document, 'a[data-action="toggle"]');

// Do more stuff

clickEvent.release();
