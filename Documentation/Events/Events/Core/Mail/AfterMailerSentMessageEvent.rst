.. include:: /Includes.rst.txt
.. index:: Events; AfterMailerSentMessageEvent
.. _AfterMailerSentMessageEvent:

===========================
AfterMailerSentMessageEvent
===========================

.. versionadded:: 12.0

This event is dispatched as soon as the message has been sent via the
corresponding :php:`Symfony\Component\Mailer\Transport\TransportInterface`.
It receives the current mailer instance, which depends on the implementation -
usually :php:`TYPO3\CMS\Core\Mail\Mailer`. It contains the
:php:`Symfony\Component\Mailer\SentMessage` object, which can be retrieved
using the :php:`getSentMessage()` method.

Example
=======

Registration of the event listener:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   MyVendor\MyExtension\EventListener\MailerSentMessageEventListener:
     tags:
       - name: event.listener
         identifier: 'my-extension/process-sent-message'
         method: 'processSentMessage'

The corresponding event listener class:

.. code-block:: php
   :caption: EXT:my_extension/Classes/EventListener/MailerSentMessageEventListener.php

   namespace MyVendor\MyExtension\EventListener;

   use Psr\Log\LoggerAwareInterface;
   use Psr\Log\LoggerAwareTrait;
   use TYPO3\CMS\Core\Mail\Event\AfterMailerSentMessageEvent;
   use TYPO3\CMS\Core\Mail\Mailer;

   final class MailerSentMessageEventListener implements LoggerInterface
   {
       use LoggerAwareTrait;

       public function processSentMessage(AfterMailerSentMessageEvent $event): void
       {
           $mailer = $event->getMailer();
           if ($mailer instanceof Mailer) {
               $sentMessage = $mailer->getSentMessage();
               if ($sentMessage !== null) {
                   $this->logger->debug($sentMessage->getDebug());
               }
           }
       }
    }

API
===

.. include:: /CodeSnippets/Events/Core/AfterMailerSentMessageEvent.rst.txt
