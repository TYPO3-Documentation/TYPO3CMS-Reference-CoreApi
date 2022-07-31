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

.. deprecated:: 11.5
   The interface :php:`\TYPO3\CMS\Extbase\Mvc\View\ViewInterface` has been deprecated
   with v11.5 and will be removed with v12. This class's signature is set to change
   to :php:`TYPO3Fluid\Fluid\View\ViewInterface` with the release v12.

API
---

.. include:: /CodeSnippets/Events/FrontendLogin/ModifyLoginFormViewEvent.rst.txt
