.. include:: ../../Includes.txt



.. _flash-messages:

==============
Flash Messages
==============

There exists a generic system to show users that an action
was performed successfully, or more importantly, failed. This system
is known as "flash messages". The screenshot below shows the various
severity levels of messages that can be emitted.

.. figure:: ../../Images/FlashMessagesAll.png
   :alt: All levels of flash messages

   The "examples" BE module shows one of each type of flash message

The different severity levels are described below:

- *Notifications* are used to show very low severity information. Such
  information usually is so unimportant that it can be left out, unless
  running in some kind of debug mode.

- *Information messages* are to give the user some information that might
  be good to know.

- *OK messages* are to signal a user about a successfully executed action.

- *Warning messages* show a user that some action might be dangerous,
  cause trouble or might have partially failed.

- *Error messages* are to signal failed actions, security issues, errors
  and the like.


.. _flash-messages-api:

Flash Messages API
==================

Creating a flash message is achieved by simply instantiating an object
of class :php:`\TYPO3\CMS\Core\Messaging\FlashMessage`::

   $message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class,
      'My message text',
      'Message Header', // [optional] the header
      \TYPO3\CMS\Core\Messaging\FlashMessage::WARNING, // [optional] the severity defaults to \TYPO3\CMS\Core\Messaging\FlashMessage::OK
      true // [optional] whether the message should be stored in the session or only in the \TYPO3\CMS\Core\Messaging\FlashMessageQueue object (default is false)
   );


Flash Messages Severities
-------------------------

The severity is defined by using class constants provided by
:php:`\TYPO3\CMS\Core\Messaging\FlashMessage`:

- :php:`\TYPO3\CMS\Core\Messaging\FlashMessage::NOTICE` for notifications

- :php:`\TYPO3\CMS\Core\Messaging\FlashMessage::INFO` for information messages

- :php:`\TYPO3\CMS\Core\Messaging\FlashMessage::OK` for success messages

- :php:`\TYPO3\CMS\Core\Messaging\FlashMessage::WARNING` for warnings

- :php:`\TYPO3\CMS\Core\Messaging\FlashMessage::ERROR` for errors

The fourth parameter passed to the constructor is a flag that
indicates whether the message should be stored in the session or not (the
default is not). Storage in the session should be used if you need the
message to be still present after a redirection.

In backend modules you can then make that message appear on top of the
module after a page refresh or the rendering of the next page request
or render it on your own where ever you want.

This example adds the flash message at the top of modules when
rendering the next request::

   $flashMessageService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
   $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
   $messageQueue->addMessage($message);

The message is added to the queue and then the template class calls
:php:`\TYPO3\CMS\Core\Messaging\FlashMessageQueue::renderFlashMessages()` which renders all
messages from the queue. Here's how such a message looks like in a module:

.. figure:: ../../Images/FlashMessagesExample.png
   :alt: A flash message in action

   A typical (success) message shown at the top of a module


By default flash messages are shown atop the content of a
module. However, if needed, you can change where the messages are
shown by manipulating a module's template and inserting the
:html:`###FLASHMESSAGES###` marker. Messages will then replace that marker
instead of appearing at the top of the module.

The recommend way is to use the fluid ViewHelper :html:`<f:flashMessages />`.
This ViewHelper works in any context because it use the :php:`FlashMessageRendererResolver` class
to find the correct renderer for the current context.

.. _flash-messages-renderer:

Flash Messages Renderer
=======================

The implementation of rendering FlashMessages in the core has been optimized.

A new class called :php:`FlashMessageRendererResolver` has been introduced.
This class detects the context and renders the given FlashMessages in the correct output format.
It can handle any kind of output format.
The core ships with the following FlashMessageRenderer classes:

* :php:`TYPO3\CMS\Core\Messaging\Renderer\BootstrapRenderer`
  This renderer is used by default in the TYPO3 backend.
  The output is based on Bootstrap markup
* :php:`TYPO3\CMS\Core\Messaging\Renderer\ListRenderer`
  This renderer is used by default in the TYPO3 frontend.
  The output is a simple <ul> list
* :php:`TYPO3\CMS\Core\Messaging\Renderer\PlaintextRenderer`
  This renderer is used by default in the CLI context.
  The output is plain text

All new rendering classes have to implement the :php:`TYPO3\CMS\Core\Messaging\Renderer\FlashMessageRendererInterface` interface.
If you need a special output format, you can implement your own renderer class and use it:

.. code-block:: php

   $out = GeneralUtility::makeInstance(MySpecialRenderer::class)
      ->render($flashMessages);


The core has been modified to use the new :php:`FlashMessageRendererResolver`.
Any third party extension should use the provided :php:`FlashMessageViewHelper` or the new :php:`FlashMessageRendererResolver` class:

.. code-block:: php

   $out = GeneralUtility::makeInstance(FlashMessageRendererResolver::class)
      ->resolve()
      ->render($flashMessages);


.. _flash-messages-extbase:

Flash Messages in Extbase
=========================

In Extbase the standard way of issuing flash messages is to add them
in the controller. Code from the "examples" extension::

   $this->addFlashMessage('This is a simple success message');


The full API of this function is::

   $this->addFlashMessage(
      $messageBody,
      $messageTitle = '',
      $severity = \TYPO3\CMS\Core\Messaging\AbstractMessage::OK,
      $storeInSession = TRUE
   );


The messages are then displayed by Fluid with the relevant ViewHelper
as shown in this excerpt of :file:`EXT:examples/Resources/Private/Layouts/Module.html`:

.. code-block:: html

   <div id="typo3-docbody">
      <div id="typo3-inner-docbody">
         <f:flashMessages />
         <f:render section="main" />
      </div>
   </div>

Where to display the flash messages in an Extbase-based BE module is
as simple as moving the View Helper around.


.. _flash-messages-javascript:

JavaScript-based Flash Messages (Notification API)
==================================================

.. important::
   The Notification API is designed for TYPO3 Backend purposes only.

The TYPO3 Core provides a JavaScript-based API to trigger flash messages ("Notifications") that appear on the upper
right corner of the TYPO3 backend. To use the Notification API, load the :js:`TYPO3/CMS/Backend/Notification` module and
use one of its methods:

* :js:`notice()`
* :js:`info()`
* :js:`success()`
* :js:`warning()`
* :js:`error()`

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

Since TYPO3 10.3 the Notification API may bind actions to a notification that execute certain tasks when invoked. Each
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

An action of type :js:`ImmediateAction` (:js:`TYPO3/CMS/Backend/ActionButtons/ImmediateAction`) is executed directly on
click and closes the notification. This action type is suitable for e.g. linking to a backend module.

The class accepts a callback method executing very simple logic.

Example:

.. code-block:: js

   require(['TYPO3/CMS/Backend/Notification', 'TYPO3/CMS/Backend/ActionButtons/ImmediateAction'], function(Notification, ImmediateAction) {
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

An action of type :js:`DeferredAction` (:js:`TYPO3/CMS/Backend/ActionButtons/DeferredAction`) is recommended when a
long-lasting task is executed, e.g. an AJAX request.

This class accepts a callback method which must return a :js:`Promise`_.

The :js:`DeferredAction` replaces the action button with a spinner icon to indicate a task will take some time. It's
still possible to dismiss a notification, which will **not** stop the execution.

Example:

.. code-block:: js

   require(['jquery', 'TYPO3/CMS/Backend/Notification', 'TYPO3/CMS/Backend/ActionButtons/DeferredAction'], function(Notification, DeferredAction) {
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

.. _`Promise`: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Promise
