..  include:: /Includes.rst.txt
..  index::
    pair: Flash messages; Extbase
..  _flash-messages-extbase:

=========================
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


The messages are then displayed by Fluid with the 
`FlashMessages ViewHelper <f:flashMessages> <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-flashmessages>`_:

.. code-block:: html

   <div id="typo3-docbody">
      <div id="typo3-inner-docbody">
         <f:flashMessages />
         <f:render section="main" />
      </div>
   </div>

Where to display the flash messages in an Extbase-based backend module is
as simple as moving the ViewHelper around.

By default, all messages are put into the scope of the
current plugin namespace with a prefix `extbase.flashmessages.`. So
if your plugin namespace is computed as `tx_myvendor_myplugin`, the
flash message queue identifier will be
`extbase.flashmessages.tx_myvendor_myplugin`.

..  _flash-messages-extbase-distinct:

Using explicit flash message queues in Extbase
==============================================

It is possible to add a message to a different flash message queue. Use 
cases could be a detailed display of different flash message queues in 
different places of the page  or displaying a Flash message when you 
forward to a different controller or even a different extension. 

If you need distinct queues, you can use a custom identifier to fetch
and operate on that queue:

..  code-block:: php

    $customQueue = $this->getFlashMessageQueue('tx_myvendor_customqueue');
    // Instead of using $this->addFlashMessage() you will instead directly
    // access the custom queue:
    $flashMessage = GeneralUtility::makeInstance(
            FlashMessage::class,
            'My flash message in a custom queue',
            'My flash message title of a custom queue',
            ContextualFeedbackSeverity::OK,
            $storeInSession = true,
    );
    $customQueue->enqueue($flashMessage);

..  _flash-messages-extbase-fluid-queueidentifier:

Fluid flash messages ViewHelper with explicit queue identifier
==============================================================

When you used an :ref:`explicit flash message queue <flash-messages-extbase-distinct>`
during enqueueing the message it will only be displayed on the page if you use the
same identifier in the `FlashMessages ViewHelper <f:flashMessages> <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-flashmessages>`_.

..  code-block:: html

    <f:flashMessages queueIdentifier="tx_myvendor_customqueue" />
