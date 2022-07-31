.. include:: /Includes.rst.txt
.. index:: Events; LogoutConfirmedEvent
.. _LogoutConfirmedEvent:


====================
LogoutConfirmedEvent
====================

.. versionadded:: 10.4
   This event replaces the :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['logout_confirmed']`
   hook from the pibase plugin.


The event is triggered when a logout was successful.



API
---

.. include:: /CodeSnippets/Events/FrontendLogin/LogoutConfirmedEvent.rst.txt
