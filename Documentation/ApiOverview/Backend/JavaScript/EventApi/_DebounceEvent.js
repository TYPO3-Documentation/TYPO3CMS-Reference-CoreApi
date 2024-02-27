import DebounceEvent from '@typo3/core/event/debounce-event.js';

new DebounceEvent('mousewheel', function (e) {
  console.log('Triggered once after 250ms!');
}, 250).bindTo(document);
