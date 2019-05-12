.. include:: ../../../Includes.txt


.. _transformations-overview:

.. _transformations-tsconfig:
.. _transformations-tsconfig-examples:
.. _transformations-tsconfig-configuration:
.. _transformations-tsconfig-configuration-disabled:
.. _transformations-tsconfig-configuration-proc:
.. _transformations-tsconfig-configuration-specific:
.. _transformations-tsconfig-processing:
.. _transformations-tsconfig-processing-overrulemode:
.. _transformations-tsconfig-processing-allowtagsoutside:
.. _transformations-tsconfig-processing-allowtags:
.. _transformations-tsconfig-processing-denytags:
.. _transformations-tsconfig-processing-blockelementlist:
.. _transformations-tsconfig-processing-htmlparser:
.. _transformations-tsconfig-processing-dontremoveunknowntags_db:
.. _transformations-tsconfig-processing-allowedclasses:
.. _transformations-tsconfig-processing-keeppdivattribs:
.. _transformations-tsconfig-processing-dontfetchextpictures:
.. _transformations-tsconfig-processing-plainimagemode:
.. _transformations-tsconfig-processing-exit_entry_htmlparser:
.. _transformations-tsconfig-processing-user:

=======================
Transformation Overview
=======================

The transformation of the content can be configured by listing which
*transformation filters* to pass it through. The order of the list is
the order in which the transformations are performed when saved to the
database. The order is reversed when the content is loaded into the
RTE again.

Processing can also be overwritten by Page TSconfig, see the
:ref:`according section of the Page TSconfig reference <t3tsconfig:pageTsRte>` for details.


.. _transformations-overview-filters:

Transformation Filters
======================

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Transformation filter
         ts\_transform

   Description
         Transforms the content with regard to most of the issues related to
         content elements types 'Text' and 'Text & Images'. The mode is
         optimized for the content rendering of the static template "content
         (default)" which uses old :code:`<font>` tag style rendering.

         The mode is a "hybrid" mode which tries to save only the necessary HTML in the
         database so that content might still be easily edited without the RTE.
         For instance a text paragraph will be encapsulated in :code:`<p>` tags while
         in the database it will just be a single line ended by a line break
         character.

         .. tip::

            This transformation produces rather old style output and you should avoid it.


.. container:: table-row

   Transformation filter
         css\_transform

   Description
         Like "ts\_transform", but producing a modern markup.

         This mode is optimized for the content rendering done by "css\_styled\_content".


.. container:: table-row

   Transformation filter
         ts\_preserve

   Description
         Converts the list of preserved tags - if any - to :code:`<span>` tags with a
         custom parameter 'specialtag' which holds the value of the original
         tag.

         **Deprecated**


.. container:: table-row

   Transformation filter
         ts\_images

   Description
         Checks if any images on the page is from external URLs and if so they
         are fetched and stored in the uploads/ folder. In addition 'magic'
         images are evaluated to see if their size has changed and if so the
         image is recalculated on the server. Finally absolute URLs are
         converted to relative URLs for all local images.


.. container:: table-row

   Transformation filter
         ts\_links

   Description
         Converts the absolute URLs of links to the TypoScript specific
         <LINK>-tag. This process is designed to make links in concordance with
         the typolink function in the TypoScript frontend.

.. ###### END~OF~TABLE ######


.. _transformations-overview-meta:

Meta Transformations
====================

Meta transformations are special modes that include several filters.


.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Transformation filter
         ts

   Description
         Includes the following filters: "ts\_transform", "ts\_preserve", "ts\_images",
         "ts\_links". **Obsolete**.


.. container:: table-row

   Transformation filter
         ts\_css

   Description
         Includes the following filters: "css\_transform", "ts\_images", "ts\_links".
         Recommended transformation. Use this for your RTE-enables fields and you
         should be safe.

.. ###### END~OF~TABLE ######


In addition, it is possible to define :ref:`custom transformations <transformations-custom>`
can be created allowing your to add your own tailor made transformations with a PHP class where you
can program how content is processed to and from the database.

