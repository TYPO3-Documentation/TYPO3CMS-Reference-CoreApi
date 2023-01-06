require(['TYPO3/CMS/Backend/BroadcastService'], function (BroadcastService) {
  const payload = {
    componentName: 'my_extension',
    eventName: 'my_event',
    hello: 'world',
    foo: ['bar', 'baz']
  };

  BroadcastService.post(payload);
});
