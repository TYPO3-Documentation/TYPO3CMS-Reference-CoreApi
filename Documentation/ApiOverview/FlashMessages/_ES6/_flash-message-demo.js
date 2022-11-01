import Notification from "@typo3/backend/notification.js";

class FlashMessageDemo {
  constructor() {
    Notification.success('Success', 'This flash message was sent via JavaScript', 5);
  }
}

export default new FlashMessageDemo();
