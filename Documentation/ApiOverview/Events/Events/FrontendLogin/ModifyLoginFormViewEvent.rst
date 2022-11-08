.. include:: /Includes.rst.txt
.. index:: Events; ModifyLoginFormViewEvent
.. _ModifyLoginFormViewEvent:


========================
ModifyLoginFormViewEvent
========================

.. versionadded:: 10.4
   This event replaces the :php:`$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['loginFormOnSubmitFuncs']`
   hook from the pibase plugin.


Allows to inject custom variables into the login form.

.. versionchanged:: 12.0
   The interface :php:`TYPO3\CMS\Extbase\Mvc\View\ViewInterface` has been
   removed with v12. The :php:`getView()` method signature has been changed
   to :php:`TYPO3Fluid\Fluid\View\ViewInterface` with the v12 release.


API
---

.. include:: /CodeSnippets/Events/FrontendLogin/ModifyLoginFormViewEvent.rst.txt
