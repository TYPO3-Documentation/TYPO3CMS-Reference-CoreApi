import RequestAnimationFrameEvent from '@typo3/core/event/request-animation-frame-event';

new RequestAnimationFrameEvent('mousewheel', function (e) {
  console.log('Triggered every 16ms (= 60 FPS)!');
});
