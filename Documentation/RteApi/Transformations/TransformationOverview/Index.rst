.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


Transformation overview
^^^^^^^^^^^^^^^^^^^^^^^

The transformation of the content can be configured by listing which
*transformation filters* to pass it through. The order of the list is
the order in which the transformations are performed when saved to the
database. The order is reversed when the content is loaded into the
RTE again.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Transformation filter
         Transformation filter:

   Description
         Description:


.. container:: table-row

   Transformation filter
         ts\_transform

   Description
         Transforms the content with regard to most of the issues related to
         content elements types 'Text' and 'Text w/Image'. The mode is
         optimized for the content rendering of the static template "content
         (default)" which uses old <font> tag style rendering.The mode is a
         "hybrid" mode which tries to save only the necessary HTML in the
         database so that content might still be easily edited without the RTE.
         For instance a text paragraph will be encapsulated in <p> tags while
         in the database it will just be a single line ended by a line break
         character.(Supports the "cms" extension)


.. container:: table-row

   Transformation filter
         css\_transform

   Description
         Like "ts\_transform", but headers and bulletlists are preserved as
         <Hx> tags and <OL> / <UL> (TYPOLIST and TYPOHEAD are still converted
         to Hx and OL/UL, but not reversely...) and tables are preserved
         (PROC.preserveTables is disabled).The mode is optimized for the
         content rendering done by "css\_styled\_content" or similar.


.. container:: table-row

   Transformation filter
         ts\_preserve

   Description
         Converts the list of preserved tags - if any - to <SPAN>-tags with a
         custom parameter 'specialtag' which holds the value of the original
         tag.Deprecated.


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


.. container:: table-row

   Transformation filter
         ts\_reglinks

   Description
         Converts the absolute URLs of links to relative. Keeping the <A>-tag.


.. container:: table-row

   Transformation filter
         Meta transformation:

   Description
         Description:


.. container:: table-row

   Transformation filter
         ts

   Description
         Meta-mode which is basically a substitute for this list:
         ts\_transform,ts\_preserve,ts\_images,ts\_links. This is the one used
         specifically for the two 'Text'-types of the content elements ("cms"
         extension).


.. container:: table-row

   Transformation filter
         ts\_css

   Description
         Like "ts", a meta-mode which is a substitute for the list:
         css\_transform,ts\_images,ts\_links. It is designed to be the new,
         modern transformation used by most RTE cases, because it converts
         links between <A> and <LINK> but preserves all other content while
         still making it as human readable as possible (that means simple
         <P>-tags are resolved into simple lines.)


.. ###### END~OF~TABLE ######

In addition, custom transformations can be created. This allows you to
create your own tailor made transformations with a PHP class where you
can program how content is processed to and from the database. See
section later.


