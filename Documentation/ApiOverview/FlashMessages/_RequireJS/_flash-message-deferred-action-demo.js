require(['jquery', 'TYPO3/CMS/Backend/Notification', 'TYPO3/CMS/Backend/ActionButton/DeferredAction'], function($, Notification, DeferredAction) {
	const deferredActionCallback = new DeferredAction(function () {
		return Promise.resolve($.ajax(/* Ajax configuration */));
	});

	Notification.warning('Goblins ahead', 'It may become dangerous at this point.', 10, [
		{
			label: 'Delete the internet',
			action: deferredActionCallback
		}
	]);
});