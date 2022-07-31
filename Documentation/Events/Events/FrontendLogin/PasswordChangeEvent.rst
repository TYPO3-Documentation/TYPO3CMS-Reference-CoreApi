.. include:: /Includes.rst.txt
.. index:: Events; PasswordChangeEvent
.. _PasswordChangeEvent:


===================
PasswordChangeEvent
===================

.. versionadded:: 10.4
   This event replaces the :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['password_changed']`
   hook from the pibase plugin.


The event contains information about the password that has been set and will be
stored in the database shortly. It allows to mark the password as invalid.


API
---

.. include:: /CodeSnippets/Events/FrontendLogin/PasswordChangeEvent.rst.txt
