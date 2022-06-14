.. include:: /Includes.rst.txt
.. index:: Events; BeforeMailerSentMessageEvent
.. _BeforeMailerSentMessageEvent:

============================
BeforeMailerSentMessageEvent
============================

.. versionadded:: 12.0

This event is dispatched before the message is sent by the mailer and can be
used to manipulate the :php:`Symfony\Component\Mime\RawMessage` and the
:php:`Symfony\Component\Mailer\Envelope`. Usually a
:php:`Symfony\Component\Mime\Email` or :php:`TYPO3\CMS\Core\Mail\FluidEmail`
instance is given as :php:`RawMessage`. Additionally the mailer instance is
given, which depends on the implementation - usually
:php:`TYPO3\CMS\Core\Mail\Mailer`. It contains the
:php:`Symfony\Component\Mailer\Transport` object, which can be retrieved using
the :php:`getTransport()` method.

Example
=======

Registration of the event listener:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   MyVendor\MyExtension\EventListener\MailerSentMessageEventListener:
     tags:
       - name: event.listener
         identifier: 'my-extension/modify-message'
         method: 'modifyMessage'

The corresponding event listener class:

.. code-block:: php
   :caption: EXT:my_extension/Classes/EventListener/MailerSentMessageEventListener.php

   namespace MyVendor\MyExtension\EventListener;

   use Symfony\Component\Mime\Address;
   use Symfony\Component\Mime\Email;
   use TYPO3\CMS\Core\Mail\Event\BeforeMailerSentMessageEvent;

   final class MailerSentMessageEventListener
   {
       public function modifyMessage(BeforeMailerSentMessageEvent $event): void
       {
           $message = $event->getMessage();

           // If $message is an Email implementation, add an additional recipient
           if ($message instanceof Email) {
               $message->addCc(new Address('cc_recipient@example.org'));
           }
       }
    }

API
===

.. include:: /CodeSnippets/Events/Core/BeforeMailerSentMessageEvent.rst.txt
