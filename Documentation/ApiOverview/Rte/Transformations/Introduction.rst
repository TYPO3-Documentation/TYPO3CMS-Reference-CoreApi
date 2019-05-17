.. include:: ../../../Includes.txt


.. _transformations-introduction:

============
Introduction
============

Transformation of content between the database and an RTE is needed if
the format of the content in the database is different than the format
understood by an RTE. A simple example could be that bold-tags in the
database :code:`<b>` should be converted to :code:`<strong>` tags in the RTE or that
references to images in :code:`<img>` tags in the database should be relative
while absolute in the RTE. In such cases a transformation is needed to
do the conversion both ways: from database (DB) to RTE and from RTE to
DB.

Generally transformations are needed for two reasons:

- **Data Formats:** If the agreed format of the stored content in TYPO3
  is different from the HTML format the RTE produces. This could be
  issues like XHTML, banning of certain tags or maybe a hybrid format in
  the database. (See section 3 in the illustration some pages ahead)

- **RTE specifics:** If the RTE has special requirements to the content
  before it can be edited and if that format is different from what we
  want to store in the database. For instance an RTE could require a
  full HTML document with :code:`<html>`, :code:`<head>` and :code:`<body>` - obviously we don't
  want that in the database and likewise we will have to wrap content in
  such a dummy-body before it can be edited.


.. _transformations-hybrid-modes:

Hybrid Modes
============

Many of the transformations performed back and forth in the TYPO3
backend date back to when it was a challenge to incorporate a RTE
in a browser. It was then sometimes needed to fall back an a simple
:code:`<textarea>` where rich text had to be presented in a simple enough
way so that editors could work with it with no visual help.

This is what the mode :code:`css_transform` tries to achieve: maintain a
data format that is as human readable as possible while still offering
an RTE for editing if applicable.

To know the details of those transformations, please refer to the
:ref:`transformations-overview`. Here is a short example of a
hybrid mode:


.. _transformations-hybrid-modes-db:

In Database
-----------

This is how the content in the database could look for a hybrid mode
(such as :code:`css_transform`):

.. code-block:: html
   :linenos:

   This is line number 1 with a <link 123>link</link> inside
   This is line number 2 with a <b>bold part</b> in the text
   <p align="center">This line is centered.</p>
   This line is just plain


As you can see the TYPO3-specific tag,
:code:`<link>` is used for the link to page 123. This tag is designed to be
easy for editors to insert. It is of course converted to a real :code:`<a>`
tag when the page is rendered in the frontend. Further line 2 shows
bold text. In line 3 the situation is that the paragraph should be
centered - and there seems to be no other way than wrapping the line
in a :code:`<p>` tag with the "align" attribute. Not so human readable but we
can do no better without an RTE. Line 4 is just plain.

Generally this content will be processed before output on a page of
course. Typically the rule will be this: "Wrap each line in a :code:`<p>` tag
which is not already wrapped in a :code:`<p>` tag and convert all
TYPO3-specific :code:`<link>`-tags to real :code:`<a>` tags." and thus the final
result will be valid HTML.


.. _transformations-hybrid-modes-rte:

In RTE
------

The content in the database can easily be edited as plain text thanks
to the "hybrid-mode" used to store the content. But when the content
above from the database has to go into the RTE it *will not* work if
every line is not wrapped in a :code:`<p>` tag! The same is true for the
:code:`<link>` tag, which has to be converted for the RTE to understand it.
This is what eventually goes into the RTE:

.. code-block:: xml

   <p>This is line number 1 with a <a href="index.php?id=123">link</a> inside</p>
   <p>This is line number 2 with a <strong>bold part</strong> in the text</p>
   <p align="center">This line is centered.</p>
   <p>This line is just plain</p>


This process of conversion from one format to the other is what
transformations do!


.. _transformations-configuration:

Configuration
=============

Transformations are mainly defined in the
'special configurations' of the $TCA "types"-configuration.
See label 'special-configuration' in older versions of the TCA-Reference.

In addition :ref:`transformations can be fine-tuned by Page TSconfig <t3tsconfig:pageTsRte>`
which means that RTE behaviour can be determined even on page branch level!


.. _transformations-where:

Where Transformations are Performed
===================================

The transformations you can do with TYPO3 are done in the class
:code:`\TYPO3\CMS\Core\Html\RteHtmlParser`. There is typically a function for each
direction; From DB to RTE (suffixed :code:`_rte`) and from RTE to DB
(suffixed :code:`_db`).

The transformations are invoked in two cases:

- **Before content enters the editing form** This is done by the RTE API
  itself, calling the method :code:`\TYPO3\CMS\Backend\Rte\AbstractRte::transformContent()`.

- **Before content is saved in the database** This is done in
  :code:`\TYPO3\CMS\Core\DataHandling\DataHandler` class and the transformation is triggered by a pseudo-
  field from the submitted form! This field is added by the RTE API
  (calling :code:`\TYPO3\CMS\Backend\Rte\AbstractRte::triggerField()`). Lets say the fieldname is
  :code:`data[tt_content][456][bodytext]` then the trigger field is named
  :code:`data[tt_content][456][_TRANSFORM_bodytext]` and in :code:`\TYPO3\CMS\Core\DataHandling\DataHandler`
  this pseudo-field will be detected and used to trigger the
  transformation process from RTE to DB. Of course the pseudo field will
  never go into the database (since it is not found in :code:`$TCA`).

The rationale for transformations is discussed in :ref:`appendix-a`.

