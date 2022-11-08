.. include:: /Includes.rst.txt
.. index:: Events; LoginConfirmedEvent
.. _LoginConfirmedEvent:


===================
LoginConfirmedEvent
===================

.. versionadded:: 10.4
   This event replaces the :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['login_confirmed']`
   hook from the pibase plugin.


The notification event is triggered when a login was successful.


API
---

.. include:: /CodeSnippets/Events/FrontendLogin/LoginConfirmedEvent.rst.txt
