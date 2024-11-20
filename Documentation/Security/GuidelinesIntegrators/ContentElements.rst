.. include:: /Includes.rst.txt
.. index::
   pair: Security guidelines; Content elements
   pair: Security guidelines; RTE
.. _security-content-elements:

================
Content elements
================

.. todo:: Needs review: Outdated: This section is outdated and needs an update.

.. warning::

   The information on this page is outdated!


Besides the :ref:`low-level extensions <security-extensions-low-level>`, there
are also system-internal functions available which could allow the insertion of
raw HTML code on pages: the content element "Plain HTML" and the Rich
Text Editor (RTE).

A properly configured TYPO3 system does not require editors to have
any programming or HTML/CSS/JavaScript knowledge and therefore the
"raw HTML code" content element is not really necessary. Besides this
fact, raw code means, editors are also able to enter malicious or
dangerous code such as `JavaScript` that may harm the website visitor's
browser or system.

Even if editors do not insert malicious code intentionally, sometimes
the lack of knowledge, expertise or security awareness could put your
website at risk.

Depending on the configuration of the Rich Text Editor (RTE), it is
also possible to enter raw code in the text mode of the RTE. Given the
fact that HTML/CSS/JavaScript knowledge is not required, you should
consider disabling the function by configuring the buttons shown in
the `RTE`. The :ref:`page TSconfig <t3tsref:pageTsRte>` enables you to
list all buttons visible in the RTE by using the following TypoScript:

.. code-block:: typoscript

   RTE.default {
     showButtons = ...
     hideButtons = ...
   }

In order to disable the button "toggle text mode", add "chMode" to the
hideButtons list. The TSconfig/RTE (Rich Text Editor) documentation
provide further details about configuration options.
