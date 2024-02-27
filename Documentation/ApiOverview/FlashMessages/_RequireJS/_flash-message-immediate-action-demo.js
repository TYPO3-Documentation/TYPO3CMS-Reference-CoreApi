require(['TYPO3/CMS/Backend/Notification', 'TYPO3/CMS/Backend/ActionButton/ImmediateAction'], function (Notification, ImmediateAction) {
  const immediateActionCallback = new ImmediateAction(function () {
    require(['TYPO3/CMS/Backend/ModuleMenu'], function (ModuleMenu) {
      ModuleMenu.showModule('web_layout');
    });
  });

  Notification.info('Nearly there', 'You may head to the Page module to see what we did for you', 10, [
    {
      label: 'Go to module',
      action: immediateActionCallback
    }
  ]);
});
