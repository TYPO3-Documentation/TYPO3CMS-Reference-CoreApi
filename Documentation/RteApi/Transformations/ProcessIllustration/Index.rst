.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt
.. include:: Images.txt


Process illustration
^^^^^^^^^^^^^^^^^^^^

The following illustration shows the process of transformations
graphically.


Part 1: The RTE Applications
""""""""""""""""""""""""""""

This is the various possible RTE applications. They can be based on
DHTML, Active-X, Java, Flash or whatever.


Part 2: The RTE Specific Transformation
"""""""""""""""""""""""""""""""""""""""

Some RTEs might need to apply additional transformation of the content
in addition to the general transformation. An example is "rteekit"
which requires a full HTML document for editing (and which will return
a full document). In that case the RTE specific transformation must
add/remove this html-document wrapper.

RTE specific transformations is normally programmed directly into the
rte-api extension class. In the case of "rteekit" that is
"tx\_rteekit\_base" which extends "t3lib\_rteapi"


Part 3: The Main Transformation
"""""""""""""""""""""""""""""""

The main transformation of content between browser format for RTEs and
the database storage format. This is general for all RTEs. Normally
consists of converting links and image references from absolute to
relative and further HTML processing as needed.  *This is the kind of
transformation specifically described on the coming pages* !

The main transformations is done with "t3lib\_parsehtml\_proc".


Part 4: The Database
""""""""""""""""""""

The database where the content is stored for use in both backend and
frontend.


Part 5: Rendering the website
"""""""""""""""""""""""""""""

Content from the database is processed for display on the website.
Depending on the storage format this might also involve
"transformation" of content. For instance the internal "<link>" tag
has to be converted into an HTML <a> tag.

The processing normally takes place with TypoScript Templates, the
"CSS Styled Content" extension (TS object path "lib.parseFunc\_RTE")


Part 6: The Website
"""""""""""""""""""

The website made with TYPO3.

|img-39|


Content Examples
""""""""""""""""

This table gives some examples of how content will look in the RTE, in
the database and on the final website.

**Notice:** This is only examples! It might not happen exactly like
that in real life since it depends on which exact transformations you
apply. But it illustrates the point that the content needs to be in
different states whether in the RTE, Database or Website frontend.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   RTE (#1)
         RTE (#1)

   Database (#4)
         Database (#4)

   Website (#6)
         Website (#6)

   Comment
         Comment


.. container:: table-row

   RTE (#1)
         <p>Hello World</p>

   Database (#4)
         Hello World

   Website (#6)
         <p>Hello World</p>

   Comment
         <p> omitted in DB to make it plain-text editable.


.. container:: table-row

   RTE (#1)
         <p align="right">Right aligned text</p>

   Database (#4)
         <p align="right">Right aligned text</p>

   Website (#6)
         <p align="right">Right aligned text</p>

   Comment
         Had to keep <p> tag in DB because align attribute was found.


.. container:: table-row

   RTE (#1)
         <table ...>....</table>

   Database (#4)
         [stripped out]

   Website (#6)
         -

   Comment
         Tables were not allowed, so stripped.


.. container:: table-row

   RTE (#1)
         <a href="http://localhost/.../index.php?id=123">

   Database (#4)
         <link 123>

   Website (#6)
         <a href="Contact\_us.123.html">

   Comment
         Links are stored with the <link>-tag and needs processing for both
         frontend and backend.


.. container:: table-row

   RTE (#1)
         <img src="http://localhost/fileadmin/image.jpg">

   Database (#4)
         <img src="fileadmin/image.jpg">

   Website (#6)
         <img src="fileadmin/image.jpg">

   Comment
         References to images must usually be absolute paths in RTEs while
         relative in database.


.. ###### END~OF~TABLE ######


