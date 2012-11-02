.. include:: ../../Includes.txt

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.


.. _flash-messages:

Flash messages
--------------

Since TYPO3 4.3 there is a generic system to show users that an action
was performed successfully, or more importantly, failed. This system
is known as "flash messages". The screenshot below shows the various
severity levels of messages that can be emitted.

.. figure:: ../../Images/FlashMessagesAll.png
   :alt: All levels of flash messages

   The "examples" BE module shows one of each type of flash message

The different severity levels are described below:

- Notifications are used to show very low severity information. Such
  information usually is so unimportant that it can be left out, unless
  running in some kind of debug mode.

- Information messages are to give the user some information that might
  be good to know.

- OK messages are to signal a user about a successfully executed action

- Warning messages show a user that some action might be dangerous,
  cause trouble or might have partially failed.

- Error messages are to signal failed actions, security issues, errors
  and the like.


.. _flash-messages-api:

Flash messages API
^^^^^^^^^^^^^^^^^^

Creating a flash message is achieved by simply instantiating an object
of class :code:`t3lib_FlashMessage`:

::

   $message = t3lib_div::makeInstance('t3lib_FlashMessage',
   	'My message text',
   	'Message Header', // the header is optional
   	t3lib_FlashMessage::WARNING, // the severity is optional as well and defaults to t3lib_FlashMessage::OK
   	TRUE // optional, whether the message should be stored in the session or only in the t3lib_MessageQueue object (default is FALSE)
   );

The severity is defined by using class constants provided by
:code:`t3lib_FlashMessage`:

- t3lib\_FlashMessage::NOTICE for notifications

- t3lib\_FlashMessage::INFO for information messages

- t3lib\_FlashMessage::OK for success messages

- t3lib\_FlashMessage::WARNING for warnings

- t3lib\_FlashMessage::ERROR for errors

The fourth parameter passed to the constructor is a flag that
indicates whether the message should be stored in session or not (the
default is not). Storage in session should be used if you need the
message to be still present after a redirection.

In backend modules you can then make that message appear on top of the
module after a page refresh / the rendering of the next page request
or render it on your own where ever you want.

This example adds the flash message at the top of modules when
rendering the next request:

::

   t3lib_FlashMessageQueue::addMessage($message);

The message is added to the queue and then the template class calls
t3lib\_FlashMessageQueue::renderFlashMessages() which renders all
messages from the queue. Here's how such a message looks like in a
module:

.. figure:: ../../Images/FlashMessagesExample.png
   :alt: A flash message in action

   A typical (success) message shown at the top of a module


By default flash messages are shown atop the content of a
module. However, if needed, you can change where the messages are
shown by manipulating a module's template and inserting the
###FLASHMESSAGES### marker. Messages will then replace that marker
instead of appearing at the top of the module.

It is also possible to render a single message directly, instead of
adding it to the queue. This makes it possible to display flash
messages absolutely anywhere. Here's how this is achieved:

::

   $message->render();


.. _flash-messages-extabase:

Flash messages in Extbase
^^^^^^^^^^^^^^^^^^^^^^^^^

In Extbase the standard way of issuing flash messages is to add them
in the controller. Code from the "examples" extension:

::

   $this->flashMessageContainer->add(
   	'This is a success message',
   	'Hooray!',
   	t3lib_FlashMessage::OK
   );


The messages are then displayed by Fluid with the relevant View Helper,
as shown in this excerpt of :file:`EXT:examples/Resources/Private/Layouts/Module.html`:

.. code-block:: html

   <div id="typo3-docbody">
   	<div id="typo3-inner-docbody">
   		<f:flashMessages renderMode="div" />
   		<f:render section="main" />
   	</div>
   </div>

Where to display the flash messages in an Extbase-based BE module is
as simple as moving the View Helper around.