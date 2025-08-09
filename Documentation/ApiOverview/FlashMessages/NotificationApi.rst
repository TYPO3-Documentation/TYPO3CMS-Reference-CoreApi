..  include:: /Includes.rst.txt
..  index::
    pair: Flash messages; JavaScript
    pair: Flash messages; Notification API
    pair: Backend JavaScript; Notification API
    Notification API
..  _flash-messages-javascript:
..  _notification_api:

==================================================
JavaScript-based flash messages (Notification API)
==================================================

..  attention::
    The notification API is designed for TYPO3 backend purposes only.

The TYPO3 Core provides a JavaScript-based API called :js:`Notification` to
trigger flash messages that appear in the bottom right corner of the TYPO3
backend. To use the notification API, load the
:js:`TYPO3/CMS/Backend/Notification` module and use one of its methods:

*   :js:`notice()`
*   :js:`info()`
*   :js:`success()`
*   :js:`warning()`
*   :js:`error()`

All methods accept the same arguments:

..  rst-class:: dl-parameters

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

    The amount of seconds how long a notification will stay visible.
    A value of `0` disables the timer.

actions
    :sep:`|` :aspect:`Condition:` optional
    :sep:`|` :aspect:`Type:` array
    :sep:`|` :aspect:`Default:` '[]'
    :sep:`|`

    Contains all actions that get rendered as buttons inside the notification.

Example:

..  literalinclude:: _ES6/_flash-message-demo.js
    :caption: EXT:some_extension/Resources/Public/JavaScript/flash-message-demo.js

To stay compatible with both TYPO3 v11 and v12 the (deprecated) RequireJS module can
still be used:

..  literalinclude:: _RequireJS/_flash-message-demo.js
    :caption: EXT:some_extension/Resources/Public/JavaScript/FlashMessageDemo.js

..  _notification_api-actions:

Actions
-------

The notification API may bind actions to a notification that execute certain
tasks when invoked. Each action item is an object containing the
fields :js:`label` and :js:`action`:

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

    An instance of either :ref:`ImmediateAction <notification_api_immediate_action>`
    (:js:`@typo3/backend/action-button/immediate-action.js`)
    or :ref:`DeferredAction <notification_api_deferred_action>`
    (:js:`@typo3/backend/action-button/deferred-action.js`).

..  attention::
    Any action **must** be optional to be executed. If triggering an action is
    mandatory, consider using a :ref:`modal <modules-modals>` instead.

..  _notification_api_immediate_action:

Immediate action
~~~~~~~~~~~~~~~~

An action of type :js:`ImmediateAction`
(:js:`@typo3/backend/action-button/immediate-action.js`) is executed directly on
click and closes the notification. This action type is suitable for e.g.
linking to a backend module.

The class accepts a callback method executing very simple logic.

Example:

..  literalinclude:: _ES6/_flash-message-immediate-action-demo.js
    :caption: EXT:some_extension/Resources/Public/JavaScript/flash-message-immediate-action-demo.js

To stay compatible with both TYPO3 v11 and v12 the (deprecated) RequireJS module can
still be used:

..  literalinclude:: _RequireJS/_flash-message-immediate-action-demo.js
    :caption: EXT:some_extension/Resources/Public/JavaScript/FlashMessageImmediateActionDemo.js

..  _notification_api_deferred_action:

Deferred action
~~~~~~~~~~~~~~~

An action of type :js:`DeferredAction` (:js:`@typo3/backend/action-button/deferred-action.js`)
is recommended when a long-lasting task is executed, e.g. an Ajax request.

This class accepts a callback method which must return a :js:`Promise`
(read more at `developer.mozilla.org <https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Promise>`__).

The :js:`DeferredAction` replaces the action button with a spinner icon to
indicate a task will take some time. It is still possible to dismiss the
notification, which will **not stop** the execution.

Example:

..  literalinclude:: _ES6/_flash-message-deferred-action-demo.js
    :caption: EXT:some_extension/Resources/Public/JavaScript/flash-message-deferred-action-demo.js

To stay compatible with both TYPO3 v11 and v12 the (deprecated) RequireJS module can
still be used:

..  literalinclude:: _RequireJS/_flash-message-deferred-action-demo.js
    :caption: EXT:some_extension/Resources/Public/JavaScript/FlashMessageDeferredActionDemo.js
