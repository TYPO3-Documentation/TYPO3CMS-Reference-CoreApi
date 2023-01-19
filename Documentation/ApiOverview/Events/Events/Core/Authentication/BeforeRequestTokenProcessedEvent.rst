..  include:: /Includes.rst.txt
..  index:: Events; BeforeRequestTokenProcessedEvent
..  _BeforeRequestTokenProcessedEvent:

================================
BeforeRequestTokenProcessedEvent
================================

..  versionadded::  12.1

The event :php:`\TYPO3\CMS\Core\Authentication\Event\BeforeRequestTokenProcessedEvent`
allows to intercept or adjust a :ref:`request token <authentication-request-token>`
during active user authentication process.

Example
=======

Scenarios that are not using a login callback without having the possibility to
submit a request token, this event can be used to generate the token
individually:

..  code-block:: php
    :caption: EXT:my_extension/EventListener/ProcessRequestTokenListener.php

    namespace MyVendor\MyExtension\EventListener;

    use TYPO3\CMS\Core\Authentication\Event\BeforeRequestTokenProcessedEvent;
    use TYPO3\CMS\Core\Security\RequestToken;

    final class ProcessRequestTokenListener
    {
        public function __invoke(BeforeRequestTokenProcessedEvent $event): void
        {
            $user = $event->getUser();
            $requestToken = $event->getRequestToken();
            // fine, there is a valid request token
            if ($requestToken instanceof RequestToken) {
                return;
            }
            // validate individual requirements/checks
            // ...
            $event->setRequestToken(
                RequestToken::create('core/user-auth/' . $user->loginType);
            );
        }
    }

Registration of the event listener:

.. code-block:: yaml
   :caption: EXT:my_extension/Configuration/Services.yaml

   MyVendor\MyExtension\EventListener\ProcessRequestTokenListener:
     tags:
       - name: event.listener
         identifier: 'my-extension/process-request-token-listener'


API
===

..  include:: /CodeSnippets/Events/Core/BeforeRequestTokenProcessedEvent.rst.txt
