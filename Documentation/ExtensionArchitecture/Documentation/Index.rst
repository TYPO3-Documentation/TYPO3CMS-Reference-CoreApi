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

The documentation platform http://docs.typo3.org centralizes documentation for every project. It supports three
different kind of documentation:

#. **(recommended)** A Sphinx project, stored within :file:`EXT:{extkey}/Documentation/`
#. A simple README file stored as :file:`EXT:{extkey}/README.rst` as seen on Github
#. *(legacy)* An OpenOffice manual, stored as :file:`EXT:{extkey}/doc/manual.sxw`


.. _extension-documentation-sphinx:

Sphinx project
""""""""""""""

Sphinx is the official format for official TYPO3 documentation. Unlike OpenOffice, it is a plain text file format. A
Sphinx-based documentation is a set of text files making up the chapters or sections of the documentation and uses a
markup language called "reStructuredText".

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

- The extension `Sphinx Python Documentation Generator and Viewer <http://typo3.org/extensions/repository/view/sphinx>`_
  (key: "sphinx") helps install a local Sphinx environment, convert existing OpenOffice manuals into Sphinx projects
  and edit/compile the documentation from your TYPO3 website.
  It can be installed from the TYPO3 Extension Repository (TER) like any other extension.
- An example manual is available in the https://git.typo3.org/Documentation/TYPO3/Example/ExtensionManual.git
  Git repository.
- The `Extension Builder <http://typo3.org/extensions/repository/view/extension_builder>`_
  provides a skeleton documentation based on the above-mentioned Git repository.


.. _extension-documentation-readme:

README.rst
""""""""""

This is a simple text file stored at the root of your extension directory and briefly describing the purpose of your
extension. It is best suited when installing or using your extension is straightforward. The format of this file is
reStructuredText, as for chapters of a Sphinx project.

.. tip::

   In TYPO3 6.2, the system extension "documentation" is using such a simple manual.


.. _extension-documentation-openoffice:

OpenOffice manual
"""""""""""""""""

You may use the :file:`manual.sxw` from extension `doc_template`_ as a template for writing documentation for your
extension.

.. _`doc_template`: http://typo3.org/extensions/repository/view/doc_template
