.. include:: /Includes.rst.txt
.. index:: Events; LoginErrorOccurredEvent
.. _LoginErrorOccurredEvent:


=======================
LoginErrorOccurredEvent
=======================

.. versionadded:: 10.4

   This event replaces the :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['login_error']`
   hook from the pibase plugin.


The notification event is triggered when an error occurs while trying to log in
a user.


API
---

.. include:: /CodeSnippets/Events/FrontendLogin/LoginErrorOccurredEvent.rst.txt
