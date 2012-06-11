

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Introduction
^^^^^^^^^^^^

Transformation of content between the database and an RTE is needed if
the format of the content in the database is different than the format
understood by an RTE. A simple example could be that bold-tags in the
database <b> should be converted to <strong> tags in the RTE or that
references to images in <img> tags in the database should be relative
while absolute in the RTE. In such cases a transformation is needed to
do the conversion both ways; From database (DB) to RTE and from RTE to
DB.

Generally transformations are needed for two reasons:

- **Data Formats;** If the agreed format of the stored content in TYPO3
  is different from the HTML format the RTE produces. This could be
  issues like XHTML, banning of certain tags or maybe a hybrid format in
  the database. (See section 3 in the illustration some pages ahead)

- **RTE specifics** ; If the RTE has special requirements to the content
  before it can be edited and if that format is different from what we
  want to store in the database. For instance an RTE could require a
  full HTML document with <html>, <head> and <body> - obviously we don't
  want that in the database and likewise we will have to wrap content in
  such a dummy-body before it can be edited. (This is the case with
  “rteekit”, see section 4 in the illustration some pages ahead).


Hybrid modes
""""""""""""

The traditional challenge of incorporating an RTE in TYPO3 has been
that the RTE was available only to a limited set of browsers,
typically MSIE on Windows. Therefore if an RTE was supported it had to
be backwards compatible with situations where content was to be edited
from regular <textarea>'s with no visual formatting.

Among the transformations in TYPO3 there are two modes,
“ts\_transform” and “css\_transform”, which are trying to maintain a
data format that is as human readable as possible while still offering
an RTE for editing if applicable.

To know the details of those transformations, please refer to the
tables in the next section. More historical background can also be
obtained later in this document. But here is a short example of a
hybrid mode:

In Database:

This is how the content in the database couldlook for a hybrid mode
(such as “css\_transform”). As you can see the TYPO3-specific tag,
“<link>” is used for the link to page 123. This tag is designed to be
easy for editors to insert. It is of course converted to a real <a>
tag when the page is rendered in the frontend. Further line 2 shows
bold text. In line 3 the situation is that the paragraph should be
centered - and there seems to be no other way than wrapping the line
in a <p> tag with the “align” attribute. Not so human readable but we
can do no better without an RTE. Line 4 is just plain.

Generally this content will be processed before output on a page of
course. Typically the rule will be this: “Wrap each line in a <p> tag
which is not already wrapped in a <p> tag and convert all
TYPO3-specific <link>-tags to real <a> tags.” and thus the final
result will be valid HTML.

::

   This is line number 1 with a <link 123>link</link> inside
   This is line number 2 with a <b>bold part</b> in the text
   <p align=”center”>This line is centered.</p>
   This line is just plain

In RTE:

The content in the database can easily be edited as plain text thanks
to the “hybrid-mode” used to store the content. But when the content
above from the database has to go into the RTE it  *will not* work if
every line is not wrapped in a <p> tag! The same is true for the
<link> tag; it has to be converted so the RTE understands it:

::

   <p>This is line number 1 with a <a href=”index.php?id=123”>link</a> inside</p>
   <p>This is line number 2 with a <strong>bold part</strong> in the text</p>
   <p align=”center”>This line is centered.</p>
   <p>This line is just plain</p>

This process of conversion from the one format to the other is what
transformations do!


Configuration
"""""""""""""

Transformations are mainly defined in the “Special Configuration” of
the $TCA "types"-configuration. There is detailed description of this
in the $TCA section of this document.

In addition transformations can be fine-tuned by Page TSconfig which
means that RTE behaviour can be determined even on page branch level!
Details about this are found later in this chapter about the RTE API.


Where transformations are performed
"""""""""""""""""""""""""""""""""""

The transformations you can do with TYPO3 is done in the class
“t3lib\_parsehtml\_proc”. There are typically a function for each
direction; From DB to RTE (suffixed “\_rte”) and from RTE to DB
(suffixed “\_db”).

The transformations are invoked in two cases:

- **Before content enters the editing form** This is done by the RTE API
  itself, calling the method t3lib\_rteapi::transformContent(). See
  examples of this in the extensions “rte”, “rtehtmlarea” and “rteekit”.
  In particular “rteekit” is interesting because it not only calls the
  system transformations but also does some Ekit-specific processing
  since a whole HTML document has to be used in “Ekit” Java RTE which
  means that the HTML document body must be wrapped/stripped off as a
  part of the transformation process.

- **Before content is saved in the database** This is done in
  t3lib\_tcemain class and the transformation is triggered by a pseudo-
  field from the submitted form! This field is added by the RTE API
  (calling t3lib\_rteapi::triggerField()). Lets say the fieldname is
  “data[tt\_content][456][bodytext]” then the trigger field is named
  “data[tt\_content][456][\_TRANSFORM\_bodytext]” and in t3lib\_tcemain
  this pseudo-field will be detected and used to trigger the
  transformation process from RTE to DB. Of course the pseudo field will
  never go into the database (since it is not found in $TCA).

The concept of transformations is discussed in more detail a few pages
ahead (" `Historical perspective on RTE transformations
<#Historical%20perspective%20on%20RTE%20transformations%7Coutline>`_
").

