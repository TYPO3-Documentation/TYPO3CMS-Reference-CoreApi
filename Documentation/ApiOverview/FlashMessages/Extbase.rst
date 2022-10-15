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
