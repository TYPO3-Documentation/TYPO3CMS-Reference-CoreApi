.. include:: /Includes.rst.txt
.. index:: Events; ModifyLoginFormViewEvent
.. _ModifyLoginFormViewEvent:


========================
ModifyLoginFormViewEvent
========================

Allows to inject custom variables into the login form.

.. deprecated:: 11.5
   The interface :php:`\TYPO3\CMS\Extbase\Mvc\View\ViewInterface` has been deprecated
   with v11.5 and will be removed with v12. This class's signature is set to change 
   to :php:`TYPO3Fluid\Fluid\View\ViewInterface` with the release v12.

API
---

.. |nbsp| unicode:: 0xA0
   :trim:

.. rst-class:: dl-parameters

getView()
   :sep:`|` :aspect:`ReturnType:` :php:`\TYPO3\CMS\Extbase\Mvc\View\ViewInterface`
   :sep:`|`

   |nbsp|
