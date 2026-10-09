import Notification from "@typo3/backend/notification.js";
import DeferredAction from "@typo3/backend/action-button/deferred-action.js";
import AjaxRequest from "@typo3/core/ajax/ajax-request.js";

class _flashMessageDeferredActionDemo {
  constructor() {
    const deferredActionCallback = new DeferredAction(function () {
      return new AjaxRequest(TYPO3.settings.ajaxUrls.myextension_example_dosomething).post({});
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
