.. include:: /Includes.rst.txt
.. index::
   Rich text editor
   RTE
   see: RTE; Rich text editor
   CKEditor
.. _rte-rendering-frontend:

=========================
Rendering in the Frontend
=========================

The explanations on this page don't show how to display an RTE but rather, describe how
rendering of content should be done in the frontend when it was entered with help
of an RTE.

.. note::

   For including an RTE in the frontend you can read :ref:`Using an RTE in the frontend <rte-frontend-introduction>`.

Fluid templates
===============

Rendering in TYPO3 is nowadays done mostly with Fluid templates.

RTEs enrich content in most cases with HTML, therefore it's advisable to use
the Fluid ViewHelper `format.html` for this kind of content:

.. code-block:: xml

   <f:format.html><p>Visit the <a href="t3://page?uid=51">example page</a>.</p></f:format.html>

The result might still be missing some important aspects. One example are links
of the form `t3://page?uid=51` that need to be processed. Usually those links should
be transformed already because the ViewHelper is using by default `lib.parseFunc_RTE`
to parse the content.

Nevertheless it's possible to define the parsing function explicitely and also to
define a different parsing function:

.. code-block:: xml

   <f:format.html parseFuncTSPath="lib.parseFunc"><p>Visit the <a href="t3://page?uid=51">example page</a>.</p></f:format.html>

.. note::

   Details to `format.html` can be found in the :ref:`ViewHelper Reference <t3viewhelper:typo3-fluid-format-html>`.

TypoScript
==========

Rendering is sometimes done by TypoScript only, in those cases it's possible to
use `lib.parseFunc_RTE` too for parsing:

.. code-block:: typoscript

   20 = TEXT
   20.value = Visit the <a href="t3://page?uid=51">example page</a>.
   20.wrap = <p>|</p>
   20.stdWrap.parseFunc < lib.parseFunc_RTE

So for fields of the content-table in the database the TypoScript could look like this:

.. code-block:: typoscript

   20 = TEXT
   20.field = bodytext
   20.wrap = <p>|</p>
   20.stdWrap.parseFunc < lib.parseFunc_RTE

.. note::

   Usually the TypoScript function `typolink` should be used for single links,
   but for text that might include several links that is not possible easily.
   Therefore `lib.parseFunc_RTE` is used to simplify and streamline this process.

   Details to `parseFunc` can be found in the TypoScript Reference:

   * :ref:`TypoScript Reference: parseFunc <t3tsref:parsefunc>`
   * :ref:`TypoScript Reference: stdWrap.parseFunc <t3tsref:stdwrap-parsefunc>`
   * :ref:`TypoScript Reference: TEXT <t3tsref:cobj-text>`

Further details
===============

The transformation process during content-rendering is highly configurable.
You can find further information here:

* :ref:`transformations`
* :ref:`appendix-a`
