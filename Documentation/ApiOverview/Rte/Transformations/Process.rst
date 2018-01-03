.. include:: ../../../Includes.txt


.. _transformations-process:

Process illustration
^^^^^^^^^^^^^^^^^^^^

The following illustration shows the process of transformations
graphically.

.. figure:: ../Images/RteTransformationProcess.png
   :alt: RTE transformations process

   The various steps in the RTE transformations process


.. _transformations-process-step1:

Step 1: The RTE Applications
""""""""""""""""""""""""""""

This is the various possible RTE applications, including
the bare :code:`<textarea>`.


.. _transformations-process-step2:

Step 2: The RTE-specific Transformation
"""""""""""""""""""""""""""""""""""""""

Some RTEs might need to apply additional transformation of the content
in addition to the general transformation. RTE specific transformations
is normally programmed directly into the :ref:`RTE API class <rte-api>`.
In the case of "rtehtmlarea" that is
:code:`\TYPO3\CMS\Rtehtmlarea\RteHtmlAreaBase`
which extends :code:`\TYPO3\CMS\Backend\Rte\AbstractRte`.


.. _transformations-process-step3:

Step 3: The Main Transformation
"""""""""""""""""""""""""""""""

The main transformation of content between browser format for RTEs and
the database storage format. This is general for all RTEs. Normally
consists of converting links and image references from absolute to
relative and further HTML processing as needed. *This is the kind of
transformation specifically described in this section*!

The main transformations are done with :code:`\TYPO3\CMS\Core\Html\RteHtmlParser`.


.. _transformations-process-step4:

Step 4: The Database
""""""""""""""""""""

The database where the content is stored for use in both backend and
frontend.


.. _transformations-process-step5:

Step 5: Rendering the website
"""""""""""""""""""""""""""""

Content from the database is processed for display on the website.
Depending on the storage format this might also involve
"transformation" of content. For instance the internal :code:`<link>` tag
has to be converted into an HTML :code:`<a>` tag.

The processing is configurated using TypoScript.
System extension "CSS Styled Content" extension provides such an object
(:code:`lib.parseFunc_RTE`). Refer to the
:ref:`description of the TS function "parsefunc" <t3tsref:parsefunc>` for more details.


.. _transformations-process-step6:

Step 6: The Website
"""""""""""""""""""

The website made with TYPO3 CMS.


.. _transformations-process-examples:

Content Examples
""""""""""""""""

This table gives some examples of how content will look in the RTE, in
the database and on the final website.

.. note::

   These are just examples! It might not happen exactly like
   that in real life since it depends on which exact transformations you
   apply. But it illustrates the point that the content needs to be in
   different states whether in the RTE, Database or Website frontend.

.. t3-field-list-table::
 :header-rows: 1

 - :RTE,20: RTE (#1)
   :Database,20: Database (#4)
   :Website,20: Website (#6)
   :Comment,40: Comment


 - :RTE:
         <p>Hello World</p>
   :Database:
         Hello World
   :Website:
         <p>Hello World</p>
   :Comment:
         :code:`<p>` omitted in DB to make it plain-text editable.


 - :RTE:
         <p align="right">Right aligned text</p>
   :Database:
         <p align="right">Right aligned text</p>
   :Website:
         <p align="right">Right aligned text</p>
   :Comment:
         Had to keep :code:`<p>` tag in DB because align attribute was found.


 - :RTE:
         <table ...>....</table>
   :Database:
         [stripped out]
   :Website:
         -
   :Comment:
          Tables were not allowed and so were stripped.


 - :RTE:
         <a href="http://localhost/.../index.php?id=123">
   :Database:
         <link 123>
   :Website:
         <a href="Contact\_us.123.html">
   :Comment:
          Links are stored with the <link>-tag and needs processing for both
          frontend and backend.


 - :RTE:
         <img src="http://localhost/fileadmin/image.jpg">
   :Database:
         <img src="fileadmin/image.jpg">
   :Website:
         <img src="fileadmin/image.jpg">
   :Comment:
          References to images must usually be absolute paths in RTEs while
          relative in database.

