.. include:: /Includes.rst.txt
.. index:: LinkBrowser; record links
.. _TableRecordLinkBrowserTutorials:

=========================
Browse records of a table
=========================

This tutorial explains how to create a link browser to the records of a table.
It can be used to create links to a news detail page (See also the
:ref:`Link browser example in tutorial in the news extension manual <ext_news:linkhandler>`)
or to the record of another third-party extension.

In our example extension `t3docs/examples <https://github.com/TYPO3-Documentation/t3docs-examples>`__
we demonstrate creating a custom record link browser by linking to the single
view of a haiku poem.

Backend: Configure the link browser with page TSconfig
======================================================

The following configuration displays an additional tab in the link browser
window in the backend.

..  include:: /CodeSnippets/Tutorials/LinkBrowser/Classes/HaikuRecordLinkBrowserTsconfig.rst.txt

The TSconfig file should then be included in the extension's global
:file:`page.tsconfig` file or in the TSconfig of the pages where it should be
available:

.. code-block:: typoscript
    :caption: EXT:examples/Configuration/page.tsconfig

    @import 'EXT:examples/Configuration/TsConfig/Page/LinkBrowser/*.tsconfig'

You can find all available options here: :ref:`linkhandler-pagetsconfig_options`.

When an editor now selects a haiku poem as link it will then be saved 
as `t3://record?identifier=haiku&uid=1` in backend link
fields and as
:html:`<a href="t3://record?identifier=haiku&amp;uid=1">Look at this Haiku!</a>`
in the rich text editor (RTE).

The output of the link needs still to be configured or the
link will be removed upon rendering. See the next step:

Frontend: Configure the detail link to the record with TypoScript
=================================================================

For the frontend output of a haiku record link we have to configure the
page on which the plugin handling the detail view is displayed and the
parameters this plugin expects:

..  include:: /CodeSnippets/Tutorials/LinkBrowser/Classes/HaikuRecordLinkTypoScript.rst.txt

You can find the available options here: :ref:`linkhandler-typoscript_options`.
