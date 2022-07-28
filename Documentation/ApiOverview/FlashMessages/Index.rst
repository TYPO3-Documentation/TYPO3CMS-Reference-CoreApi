.. include:: /Includes.rst.txt
.. index:: Flash messages
.. _flash-messages:

==============
Flash messages
==============

There exists a generic system to show users that an action
was performed successfully, or more importantly, failed. This system
is known as "flash messages". The screenshot below shows the various
severity levels of messages that can be emitted.

.. include:: /Images/AutomaticScreenshots/Examples/FlashMessages/FlashMessagesAll.rst.txt

The different severity levels are described below:

*  *Notifications* are used to show very low severity information. Such
   information usually is so unimportant that it can be left out, unless
   running in some kind of debug mode.

*  *Information messages* are to give the user some information that might
   be good to know.

*  *OK messages* are to signal a user about a successfully executed action.

*  *Warning messages* show a user that some action might be dangerous,
   cause trouble or might have partially failed.

*  *Error messages* are to signal failed actions, security issues, errors
   and the like.


.. index:: Flash messages; API
.. _flash-messages-api:

Flash messages API
==================

Instantiate a flash message
---------------------------

Creating a flash message is achieved by simply instantiating an object
of class :php:`\TYPO3\CMS\Core\Messaging\FlashMessage`:

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeController.php

   use TYPO3\CMS\Core\Messaging\FlashMessage;
   use TYPO3\CMS\Core\Utility\GeneralUtility;
   use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;

   // FlashMessage($message, $title = '', $severity = ContextualFeedbackSeverity::OK, $storeInSession = false)
   $message = GeneralUtility::makeInstance(FlashMessage::class,
      'My message text',
      'Message Header',
      ContextualFeedbackSeverity::WARNING,
      true
   );

:php:`$message:`
   The text of the message
:php:`$title:`
   [optional] the header
:php:`$severity:`
   [optional] the severity (default: :php:`ContextualFeedbackSeverity::OK`)
:php:`$storeInSession:`
   [optional] :php:`true`: store in the session or :php:`false`: store
   only in the :php:`\TYPO3\CMS\Core\Messaging\FlashMessageQueue` object. Storage
   in the session should be used if you need the message to be still present after
   a redirection (default: :php:`false`).


.. index:: ContextualFeedbackSeverity

Flash messages severities
-------------------------

.. versionchanged:: 12.0

The severity is defined by using the
:php:`\TYPO3\CMS\Core\Type\ContextualFeedbackSeverity` enumeration:

*  :php:`ContextualFeedbackSeverity::NOTICE` for notifications

*  :php:`ContextualFeedbackSeverity::INFO` for information messages

*  :php:`ContextualFeedbackSeverity::OK` for success messages

*  :php:`ContextualFeedbackSeverity::WARNING` for warnings

*  :php:`ContextualFeedbackSeverity::ERROR` for errors

.. deprecated:: 12.0
   In TYPO3 versions up to 11.5 class constants from
   :php:`\TYPO3\CMS\Core\Messaging\FlashMessage` must be used:

   *  :php:`FlashMessage::NOTICE` for notifications

   *  :php:`FlashMessage::INFO` for information messages

   *  :php:`FlashMessage::OK` for success messages

   *  :php:`FlashMessage::WARNING` for warnings

   *  :php:`FlashMessage::ERROR` for errors

   One can also use the class constants of :php:`FlashMessage` if an
   extension should remain compatible with TYPO3 v12 and older versions.

   The class constants will be removed in a future version of TYPO3.


Add a flash message to the queue
--------------------------------

In backend modules you can then make that message appear on top of the
module after a page refresh or the rendering of the next page request
or render it on your own where ever you want.

This example adds the flash message at the top of modules when
rendering the next request:


.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeController.php

   use TYPO3\CMS\Core\Utility\GeneralUtility;
   use TYPO3\CMS\Core\Messaging\FlashMessageService;

   $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
   $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
   $messageQueue->addMessage($message);

The message is added to the queue and then the template class calls
:php:`\TYPO3\CMS\Core\Messaging\FlashMessageQueue::renderFlashMessages()` which renders all
messages from the queue as inline flash messages. Here's how such a message looks like in a module:

.. include:: /Images/AutomaticScreenshots/Examples/FlashMessages/FlashMessagesExample.rst.txt

This shows flash messages with 2 types of rendering mechanisms:

*  several flash messages are displayed **inline**
*  and an additional flash message ("Record count") is rendered as top-right
   **notification** (which automatically disappear after a short delay).

.. versionadded:: 12.0

   :php:`FlashMessageQueue::NOTIFICATION_QUEUE` has been added in TYPO3 12 to
   provide a simple mechanism to add flash messages (from PHP code) to be
   displayed as notifications on the top-right edge of the backend. Previously,
   this had to be implemented in JavaScript (e.g. :js:`Notification.success()`),
   which is also still possible, see :ref:`flash-messages-javascript`.

Use the :php:`FlashMessageQueue::NOTIFICATION_QUEUE` to submit a flash message
as top-right notifications, instead of inline:

.. code-block:: php
   :caption: my_extension/Classes/Controller/MyController.php

    $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
    $notificationQueue = $flashMessageService->getMessageQueueByIdentifier(FlashMessageQueue::NOTIFICATION_QUEUE);
    $flashMessage = GeneralUtility::makeInstance(
        FlashMessage::class,
        'I\'m a message rendered as notification',
        'Hooray!',
        FlashMessage::OK
    );
    $notificationQueue->enqueue($flashMessage);

The recommended way to show flash messages is to use the Fluid ViewHelper :html:`<f:flashMessages />`.
This ViewHelper works in any context because it use the :php:`FlashMessageRendererResolver` class
to find the correct renderer for the current context.

.. _flash-messages-renderer:

Flash messages renderer
=======================

The implementation of rendering FlashMessages in the Core has been optimized.

A new class called :php:`TYPO3\CMS\Core\Messaging\FlashMessageRendererResolver`
has been introduced. This class detects the context and renders the given
FlashMessages in the correct output format.
It can handle any kind of output format.
The Core ships with the following FlashMessageRenderer classes:

*  :php:`TYPO3\CMS\Core\Messaging\Renderer\BootstrapRenderer`
   This renderer is used by default in the TYPO3 backend.
   The output is based on Bootstrap markup.
*  :php:`TYPO3\CMS\Core\Messaging\Renderer\ListRenderer`
   This renderer is used by default in the TYPO3 frontend.
   The output is a simple :html:`<ul>` list.
*  :php:`TYPO3\CMS\Core\Messaging\Renderer\PlaintextRenderer`
   This renderer is used by default in the CLI context.
   The output is plain text.

All new rendering classes have to implement the :php:`TYPO3\CMS\Core\Messaging\Renderer\FlashMessageRendererInterface` interface.
If you need a special output format, you can implement your own renderer class and use it:

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeController.php

   use TYPO3\CMS\Core\Utility\GeneralUtility;
   use Vendor\SomeExtension\Classes\Messaging\MySpecialRenderer;

   $out = GeneralUtility::makeInstance(MySpecialRenderer::class)
      ->render($flashMessages);


The Core has been modified to use the new :php:`FlashMessageRendererResolver`.
Any third party extension should use the provided :php:`FlashMessageViewHelper`
or the new :php:`FlashMessageRendererResolver` class:

.. code-block:: php
   :caption: EXT:some_extension/Classes/Controller/SomeController.php

   use TYPO3\CMS\Core\Utility\GeneralUtility;
   use TYPO3\CMS\Core\Messaging\FlashMessageRendererResolver;

   $out = GeneralUtility::makeInstance(FlashMessageRendererResolver::class)
      ->resolve()
      ->render($flashMessages);


.. index:: pair: Flash messages; Extbase
.. _flash-messages-extbase:

Flash messages in Extbase
=========================

In Extbase, the standard way of issuing flash messages is to add them
in the controller. Code from the `"examples" extension
<https://github.com/TYPO3-Documentation/t3docs-examples>`__:

.. code-block:: php
   :caption: EXT:examples/Classes/Controller/ModuleController.php

   $this->addFlashMessage('This is a simple success message');

.. warning::

   You cannot call this function in the constructor of a controller
   or in an initialize action as it needs some internal data
   structures to be initialized.


A more elaborate example:


.. code-block:: php
   :caption: EXT:examples/Classes/Controller/ModuleController.php

   // use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;

   $this->addFlashMessage(
      'This message is forced to be NOT stored in the session by setting the fourth argument to FALSE.',
      'Success',
      ContextualFeedbackSeverity::OK,
      false
   );


The messages are then displayed by Fluid with the relevant Viewhelper
as shown in this excerpt of :file:`EXT:examples/Resources/Private/Layouts/Module.html`:

.. code-block:: html

   <div id="typo3-docbody">
      <div id="typo3-inner-docbody">
         <f:flashMessages />
         <f:render section="main" />
      </div>
   </div>

Where to display the flash messages in an Extbase-based backend module is
as simple as moving the ViewHelper around.

.. index::
   pair: Flash messages; JavaScript
   Notification API
.. _flash-messages-javascript:

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

Since TYPO3 10.1 the notification API may bind actions to a notification that execute certain tasks when invoked. Each
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
