..  include:: /Includes.rst.txt
..  index::
    pair: Flash messages; JavaScript
    pair: Flash messages; Notification API
    pair: Backend JavaScript; Notification API
    Notification API
.. _flash-messages-javascript:

==================================================
JavaScript-based flash messages (Notification API)
==================================================

.. important::
   The notification API is designed for TYPO3 Backend purposes only.

The TYPO3 Core provides a JavaScript-based API to trigger flash messages ("Notifications") that appear on the upper
right corner of the TYPO3 backend. To use the notification API, load the :js:`TYPO3/CMS/Backend/Notification` module and
use one of its methods:

*  :js:`notice()`
*  :js:`info()`
*  :js:`success()`
*  :js:`warning()`
*  :js:`error()`

All methods accept the same arguments.

.. rst-class:: dl-parameters

title
   :sep:`|` :aspect:`Condition:` required
   :sep:`|` :aspect:`Type:` string
   :sep:`|`

   Contains the title of the notification.

message
   :sep:`|` :aspect:`Condition:` optional
   :sep:`|` :aspect:`Type:` string
   :sep:`|` :aspect:`Default:` ''
   :sep:`|`

   The actual message that describes the purpose of the notification.

duration
   :sep:`|` :aspect:`Condition:` optional
   :sep:`|` :aspect:`Type:` number
   :sep:`|` :aspect:`Default:` '5 (0 for :js:`error()`)'
   :sep:`|`

   The amount of seconds how long a notification will stay visible. A value of `0` disables the timer.

actions
   :sep:`|` :aspect:`Condition:` optional
   :sep:`|` :aspect:`Type:` array
   :sep:`|` :aspect:`Default:` '[]'
   :sep:`|`

   Contains all actions that get rendered as buttons inside the notification.


Example:

.. code-block:: js

   require(['TYPO3/CMS/Backend/Notification'], function(Notification) {
     Notification.success('Well done', 'Whatever you did, it was successful.');
   });


Actions
-------

Since TYPO3 v10.1 the notification API may bind actions to a notification that execute certain tasks when invoked. Each
action item is an object containing the fields :js:`label` and :js:`action`:

.. rst-class:: dl-parameters

label
   :sep:`|` :aspect:`Condition:` required
   :sep:`|` :aspect:`Type:` string
   :sep:`|`

   The label of the action item.

action
   :sep:`|` :aspect:`Condition:` required
   :sep:`|` :aspect:`Type:` ImmediateAction|DeferredAction
   :sep:`|`

   An instance of either :js:`ImmediateAction` or :js:`DeferredAction`.

.. important::
   Any action **must** be optional to be executed. If triggering an action is mandatory, consider using Modals instead.

Immediate action
~~~~~~~~~~~~~~~~

An action of type :js:`ImmediateAction` (:js:`TYPO3/CMS/Backend/ActionButton/ImmediateAction`) is executed directly on
click and closes the notification. This action type is suitable for e.g. linking to a backend module.

The class accepts a callback method executing very simple logic.

Example:

.. code-block:: js

   require(['TYPO3/CMS/Backend/Notification', 'TYPO3/CMS/Backend/ActionButton/ImmediateAction'], function(Notification, ImmediateAction) {
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


Deferred action
~~~~~~~~~~~~~~~

An action of type :js:`DeferredAction` (:js:`TYPO3/CMS/Backend/ActionButton/DeferredAction`) is recommended when a
long-lasting task is executed, e.g. an AJAX request.

This class accepts a callback method which must return a :js:`Promise` (read more at `developer.mozilla.org`_).

The :js:`DeferredAction` replaces the action button with a spinner icon to indicate a task will take some time. It's
still possible to dismiss a notification, which will **not** stop the execution.

Example:

.. code-block:: js

   require(['jquery', 'TYPO3/CMS/Backend/Notification', 'TYPO3/CMS/Backend/ActionButton/DeferredAction'], function($, Notification, DeferredAction) {
     const deferredActionCallback = new DeferredAction(function () {
       return Promise.resolve($.ajax(/* AJAX configuration */));
     });

     Notification.warning('Goblins ahead', 'It may become dangerous at this point.', 10, [
       {
         label: 'Delete the internet',
         action: deferredActionCallback
       }
     ]);
   });

.. _`developer.mozilla.org`: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Promise
