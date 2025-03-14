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

By default, all messages are put into the scope of the
current plugin namespace with a prefix `extbase.flashmessages.`. So
if your plugin namespace is computed as `tx_myvendor_myplugin`, the
flash message queue identifier will be
`extbase.flashmessages.tx_myvendor_myplugin`.

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

To access the message of the custom queue in Fluid, you need to pass the
identifier:

..  code-block:: html

    <f:flashMessages queueIdentifier="tx_myvendor_customqueue" />

Be sure to pick a unique and distinct identifier for your queue.
