:navigation-title: Rendering

..  include:: /Includes.rst.txt
..  index::
    Rich text editor
    RTE
    see: RTE; Rich text editor
    CKEditor
..  _rte-rendering-frontend:

=====================================
Rendering RTE content in the Frontend
=====================================

The explanations on this page don't show how to display an RTE but rather, describe how
rendering of content should be done in the frontend when it was entered with help
of an RTE.

..  note::

    For including an RTE in the frontend you can read
    :ref:`Using an RTE in the frontend <rte-frontend-introduction>`.

..  _rte-rendering-fluid:

Fluid templates
===============

Rich text editors enrich content with HTML and pseudo HTML (for example a special
link syntax). You should therefore always render the output of a RTE field
with the `Format.html ViewHelper <f:format.html> <https://docs.typo3.org/permalink/t3viewhelper:typo3-fluid-format-html>`_:

..  code-block:: html
    :caption: packages/my_extension/Resources/Private/Templates/MyContentElement.html

    <f:format.html>{data.bodytext}</f:format.html>

..  _rte-rendering-typoscript:

TypoScript
==========

Rendering is sometimes done by TypoScript only, in those cases it is possible to
use `lib.parseFunc_RTE` for parsing and rendering (see also
`TypoScript function parseFunc <https://docs.typo3.org/permalink/t3tsref:parsefunc>`_):

For example to render the `bodytext` filed of table `tt_content` without Fluid:

..  literalinclude:: _parsefunc.typoscript
    :caption: packages/my_extension/Configuration/Sets/MySet/setup.typoscript

Usually the TypoScript function `typolink` should be used for single links,
but for text that might include several links that is not possible easily.
Therefore `lib.parseFunc_RTE` is used to simplify and streamline this process.

Details to `parseFunc` can be found in the TypoScript Reference:

*   :ref:`TypoScript Reference: parseFunc <t3tsref:parsefunc>`
*   :ref:`TypoScript Reference: stdWrap.parseFunc <t3tsref:stdwrap-parsefunc>`
*   :ref:`TypoScript Reference: TEXT <t3tsref:cobj-text>`
