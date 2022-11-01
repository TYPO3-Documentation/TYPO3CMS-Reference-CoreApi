/**
 * Module: @t3docs/examples/flash-message-demo
 * JavaScript code for extension "examples" backend module
 */

import Notification from "@typo3/backend/notification.js";
import ImmediateAction from "@typo3/backend/action-button/immediate-action.js";
import ModuleMenu from "@typo3/backend/module-menu.js";

class _flashMessageImmediateActionDemo {
	constructor() {
		const immediateActionCallback = new ImmediateAction(function () {
			ModuleMenu.showModule('web_layout');
		});

		Notification.info('Nearly there', 'You may head to the Page module to see what we did for you', 10, [
			{
				label: 'Go to module',
				action: immediateActionCallback
			}
		]);
	}
}

export default new _flashMessageImmediateActionDemo();
