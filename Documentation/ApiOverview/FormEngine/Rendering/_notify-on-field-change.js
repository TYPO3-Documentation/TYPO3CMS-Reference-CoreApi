import FormEngine from '@typo3/backend/form-engine.js';
import Notification from '@typo3/backend/notification.js';

FormEngine.registerOnFieldChangeHandler(
  'my-extension-notify',
  (data) => {
    Notification.info(data.title, data.message);
  },
);
