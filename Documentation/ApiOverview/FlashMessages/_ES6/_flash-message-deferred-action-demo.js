import Notification from "@typo3/backend/notification.js";
import DeferredAction from "@typo3/backend/action-button/deferred-action.js";
import $ from 'jquery';

class _flashMessageDeferredActionDemo {
	constructor() {
		const deferredActionCallback = new DeferredAction(function () {
			return Promise.resolve($.ajax(/* AJAX configuration */));
		});

		Notification.warning('Goblins ahead', 'It may become dangerous at this point.', 10, [
			{
				label: 'Delete the internet',
				action: deferredActionCallback
			}
		]);
	}
}

export default new _flashMessageDeferredActionDemo();
