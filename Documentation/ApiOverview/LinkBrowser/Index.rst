.. include:: /Includes.rst.txt
.. index:: Link Browser
.. _LinkBrowser:

============
Link browser
============

The :ref:`link browser <linkbrowser-api>` is the window in which users can configure
links in both the :ref:`rte` and the :ref:`FormEngine`. The link browser offers
tabs for the different types of links like email, page, external, file, news
record and possibly more.Each tab is rendered by a :ref:`backend link
handler <linkhandler>`. The associated link format is processed by a
:ref:`core link handler <>` and
the frontend output is processed by a :ref:`link builder <>`.

**Contents:**

..  rst-class:: compact-list
..  toctree::
    :titlesonly:

    Configuration
    Linkhandler/Index
    CoreLinkHandler
    LinkBuilder
