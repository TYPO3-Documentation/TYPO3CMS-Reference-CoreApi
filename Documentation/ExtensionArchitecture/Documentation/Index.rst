.. include:: ../../Includes.txt


.. _extension-documentation:

====================
Adding documentation
====================

If you plan to upload your extension to the TYPO3 Extension Repository (TER), you should first consider adding
documentation to your extension. Documentation will help users and administrators to install, configure
and use your extension.

We will give you a short overview here, but for more information, please see the guide 
:ref:`Writing documentation <h2document:start>` and specifically:

* General information about TYPO3 documentation: :ref:`h2document:basic-principles`
* Get started using reST: :ref:`h2document:Formatting-with-reST`
* More information about starting documentation for your TYPO3 extension: :ref:`h2document:how-to-start-docs-extension`
* If you want to test your documenation, you need to render it: :ref:`h2document:rendering-docs`

The documentation platform https://docs.typo3.org centralizes documentation for every project. It supports 
different kinds of documentation:

#. **(recommended)** A Sphinx project, stored within :file:`EXT:{extkey}/Documentation/`
#. Other formats, such as a simple README file stored as :file:`EXT:{extkey}/README.rst`, see :ref:`h2document:supported-filenames-and-formats`


.. _extension-documentation-sphinx:

Sphinx project
==============

Sphinx is the format used for official TYPO3 documentation. A Sphinx-based documentation is a set of
plain text files making up the chapters or sections of the documentation. It uses a markup language
called "reStructuredText" (reST).

Advantages of this documentation format are numerous:

- **Output formats:** Sphinx projects may be automatically rendered as HTML or TYPO3-branded PDF.
- **Cross-references:** It is easy to cross-reference other chapters and sections of other manuals (either TYPO3
  references or extension manuals). The links are automatically updated if pages or sections are moved.
- **Collaboration:** As the documentation is plain text, it is easy to work as a team on the same manual or quickly
  review changes using any versioning system.

Although it is possible to write every single line of a Sphinx-based documentation from scratch, the TYPO3 community
provides tools that help to create a Sphinx documentation project:

- An `example manual <https://github.com/TYPO3-Documentation/TYPO3CMS-Example-ExtensionManual>`_ is available on
  the TYPO3 Documentation Github repository.
- The `Extension Builder <https://extensions.typo3.org/extension/extension_builder>`_
  provides a skeleton documentation based on the above-mentioned Git repository.

.. _extension-documentation-readme:

Other formats
=============

Other formats besides the recommended format are possible as described in :ref:`h2document:supported-filenames-and-formats`.
However, please consider using the recommended format (sphinx project in file:`Documentation` directory)
as described here. 

There are some rendering issues with Markdown, so even if it is possible to use Mardown, please consider
using reST, because that is what is commonly used in TYPO3 documentation projects and that is what is
supported best. 

README.rst
----------

A "README.rst" is a simple text file stored at the root of your extension directory and briefly describing the
purpose of your extension. It is best suited when installing or using your extension is straightforward. The format
of this file is reStructuredText, as for chapters of a Sphinx project.


