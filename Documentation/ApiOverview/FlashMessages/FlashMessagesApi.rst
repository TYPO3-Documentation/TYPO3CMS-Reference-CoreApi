.. include:: /Includes.rst.txt
.. index:: Flash messages; API
.. _flash-messages-api:

==================
Flash messages API
==================

Instantiate a flash message
---------------------------

Creating a flash message is achieved by instantiating an object
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

:php:`$message`
   The text of the message
:php:`$title`
   [optional] the header
:php:`$severity`
   [optional] the severity (default: :php:`ContextualFeedbackSeverity::OK`)
:php:`$storeInSession`
   [optional] :php:`true`: store in the session or :php:`false`: store
   only in the :php:`\TYPO3\CMS\Core\Messaging\FlashMessageQueue` object. Storage
   in the session should be used if you need the message to be still present after
   a redirection (default: :php:`false`).


.. index:: ContextualFeedbackSeverity

Flash messages severities
-------------------------

..  versionchanged:: 13.0
    The previous class constants of :php:`\TYPO3\CMS\Core\Messaging\FlashMessage`
    have been removed with TYPO3 v13.0.

The severity is defined by using the
:php:`\TYPO3\CMS\Core\Type\ContextualFeedbackSeverity` enumeration:

*  :php:`ContextualFeedbackSeverity::NOTICE` for notifications

*  :php:`ContextualFeedbackSeverity::INFO` for information messages

*  :php:`ContextualFeedbackSeverity::OK` for success messages

*  :php:`ContextualFeedbackSeverity::WARNING` for warnings

*  :php:`ContextualFeedbackSeverity::ERROR` for errors


Add a flash message to the queue
--------------------------------

In backend modules you can then make that message appear on top of the
module after a page refresh or the rendering of the next page request
or render it on your own where ever you want.

In this example the :php:`FlashMessageService` (:php:`TYPO3\CMS\Core\Messaging\FlashMessageService`)
is used to add a flash message at the bottom right of a module:

.. code-block:: php
   :caption: EXT:my_extension/Classes/Controller/SomeController.php

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

Use the :php:`FlashMessageQueue::NOTIFICATION_QUEUE` to submit a flash message
as top-right notifications, instead of inline:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/MyController.php

    use TYPO3\CMS\Core\Messaging\FlashMessage;
    use TYPO3\CMS\Core\Messaging\FlashMessageQueue;
    use TYPO3\CMS\Core\Messaging\FlashMessageService;
    use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
    use TYPO3\CMS\Core\Utility\GeneralUtility;

    $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
    $notificationQueue = $flashMessageService->getMessageQueueByIdentifier(
        FlashMessageQueue::NOTIFICATION_QUEUE
    );
    $flashMessage = GeneralUtility::makeInstance(
        FlashMessage::class,
        'I am a message rendered as notification',
        'Hooray!',
        ContextualFeedbackSeverity::OK
    );
    $notificationQueue->enqueue($flashMessage);

The recommended way to show flash messages is to use the Fluid ViewHelper :html:`<f:flashMessages />`.
This ViewHelper works in any context because it uses the :php:`FlashMessageRendererResolver` class
to find the correct renderer for the current context.
