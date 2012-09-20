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


Flash messages
--------------

Since TYPO3 4.3 there is a generic system to show users that an action
was performed successfully, or more importantly, failed. This system
is known as "flash messages". The screenshot below shows the various
severity levels of messages that can be emitted. It also shows that
flash messages can include a header or not.

|img-19| The different severity levels are described below:

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


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   FlashMessagesApi/Index

