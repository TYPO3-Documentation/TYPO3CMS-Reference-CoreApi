.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _extension-documentation:

Adding documentation
^^^^^^^^^^^^^^^^^^^^

If you plan to upload your extension to the TYPO3 Extension Repository (TER), you should first consider adding a
documentation to your extension. A documentation will help users and administrators to quickly install and configure
your extension and give it more weight.

The documentation platform https://docs.typo3.org centralizes documentation for every project. It supports three
different kind of documentation:

#. **(recommended)** A Sphinx project, stored within :file:`EXT:{extkey}/Documentation/`
#. A simple README file stored as :file:`EXT:{extkey}/README.rst` as seen on Github
#. *(legacy)* An OpenOffice manual, stored as :file:`EXT:{extkey}/doc/manual.sxw`


.. _extension-documentation-sphinx:

Sphinx project
""""""""""""""

Sphinx is the official format for official TYPO3 documentation. A Sphinx-based documentation is a set of
plain text files making up the chapters or sections of the documentation. It uses a markup language
called "reStructuredText" (reST).

Advantages of this new documentation format are numerous:

- **Output formats:** Sphinx projects may be automatically rendered as HTML or TYPO3-branded PDF.
- **Cross-references:** It is easy to cross-reference other chapters and sections of other manuals (either TYPO3
  references or extension manuals).
- **Multilingual:** Unlike OpenOffice, Sphinx projects may be easily localized and automatically presented in the most
  appropriate language to TYPO3 users.
- **Collaboration:** As the documentation is plain text, it is easy to work as a team on the same manual or quickly
  review changes using any versioning system.

Although it is possible to write every single line of a Sphinx-based documentation from scratch, the TYPO3 community
provides tools that help write and manage Sphinx projects:

- The extension "Sphinx" (`Sphinx Python Documentation Generator and Viewer <https://extensions.typo3.org/extension/sphinx>`_)
  installs a local Sphinx environment to view, edit and compile documentation in the backend of your TYPO3 website.
  It can be installed from the TYPO3 Extension Repository (TER) like any other extension.
- The Sphinx extension is able to convert existing OpenOffice manuals (manual.sxw) into Sphinx projects with just
  one click.
- An `example manual <https://git.typo3.org/Documentation/TYPO3/Example/ExtensionManual.git>`_ is available in
  the TYPO3 Git repository.
- The `Extension Builder <https://extensions.typo3.org/extension/extension_builder>`_
  provides a skeleton documentation based on the above-mentioned Git repository.
- A `good primer <https://docs.typo3.org/typo3cms/drafts/github/xperseguers/RstPrimer/>`_
  to get started using the reStructuredText markup.


.. _extension-documentation-readme:

README.rst
""""""""""

A "README.rst" is a simple text file stored at the root of your extension directory and briefly describing the
purpose of your extension. It is best suited when installing or using your extension is straightforward. The format
of this file is reStructuredText, as for chapters of a Sphinx project.

.. tip::

   In TYPO3 6.2, the system extension "documentation" is using such a simple manual.


.. _extension-documentation-openoffice:

OpenOffice manual
"""""""""""""""""

The OpenOffice SXW format used to be the official documentation format for TYPO3.
**Use of this format is highly discouraged since support on docs.typo3.org is about to be dropped.**
Please use the tools mentioned above to convert your existing SXW file into a Sphinx project instead.

- `OpenOffice example manual <http://typo3.org/extensions/repository/view/doc_template>`_ in the TYPO3 extension repository.
