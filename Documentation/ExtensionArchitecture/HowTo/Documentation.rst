.. include:: /Includes.rst.txt
.. index::
   Extension development; Documentation
   Path; EXT:{extkey}/Documentation/
.. _extension-documentation:
.. _extension-documentation-sphinx:
.. _extension-documentation-readme:

====================
Adding documentation
====================

If you plan to upload your extension to the TYPO3 Extension Repository (TER),
you should first consider adding documentation to your extension. Documentation
helps users and administrators to install, configure and use your extension,
and decision makers to get a quick overview without having to install the
extension.

The TYPO3 documentation platform https://docs.typo3.org centralizes documentation
for each project. It supports different types of documentation:

#. The *full documentation*, stored in :file:`EXT:{extkey}/Documentation/`.
#. The *single file documentation*, such as a simple README file stored in
   :file:`EXT:{extkey}/README.rst`.

We recommend the first approach for the following reasons:

-  **Output formats:** Full documentations can be automatically rendered as HTML
   or TYPO3-branded PDF.
-  **Cross-references:** It is easy to cross-reference to other chapters and
   sections of other manuals (either TYPO3 references or extension manuals).
   The links are automatically updated when pages or sections are moved.
-  **Many content elements:** The Sphinx template used for rendering the full
   documentation provides many useful content elements to improve the structure
   and look of your documentation.

For more details on both approaches see the :ref:`File structure <h2document:file-structure>`
page and for more information on writing TYPO3 documentation in general, see the
:doc:`Writing documentation <h2document:Index>` guide.

.. _extension-documentation-tools:

Tools
=====

Although it is possible to write every single line of a full documentation
from scratch, the TYPO3 community provides tools to support you:

-  A `Sample Manual <https://github.com/TYPO3-Documentation/TYPO3CMS-Example-ExtensionManual>`_
   is available to be immediately copied into your own extension.
-  The :t3ext:`extension_builder`
   optionally generates a documentation skeleton together with the extension
   skeleton.
