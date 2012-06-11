.. include:: Images.txt

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Flash messages API
^^^^^^^^^^^^^^^^^^

Creating a flash message is achieved by simply instantiating an object
of class t3lib\_FlashMessage:

::

   $message = t3lib_div::makeInstance('t3lib_FlashMessage', 
         'My message text', 
    'Message Header', // the header is optional
    t3lib_FlashMessage::WARNING, // the severity is optional as well and defaults to t3lib_FlashMessage::OK
        TRUE // optional, whether the message should be stored in the session or only in the t3lib_MessageQueue object (default is FALSE)
   );

The severity is defined by using class constants provided by
t3lib\_FlashMessage:

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

|img-20| By default flash messages are shown atop the content of a
module. However, if needed, you can change where the messages are
shown by manipulating a module's template and inserting the
###FLASHMESSAGES### marker. Messages will then replace that marker
instead of appearing at the top of the module.

It is also possible to render a single message directly, instead of
adding it to the queue. This makes it possible to display flash
messages absolutely anywhere. Here's how this is achieved:

::

   $message->render();

