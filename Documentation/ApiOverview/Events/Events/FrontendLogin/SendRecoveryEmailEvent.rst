.. include:: /Includes.rst.txt
.. index:: Events; SendRecoveryEmailEvent
.. _SendRecoveryEmailEvent:


======================
SendRecoveryEmailEvent
======================

.. versionadded:: 10.4
   This event replaces the :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['forgotPasswordMail']`
   hook from the pibase plugin.


The event contains the email to be sent and additional information about the
user who requested a new password.


API
---

.. include:: /CodeSnippets/Events/FrontendLogin/SendRecoveryEmailEvent.rst.txt
