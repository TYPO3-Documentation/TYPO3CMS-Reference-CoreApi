.. include:: /Includes.rst.txt


.. _csh-files:

==========================
The Language Files for CSH
==========================

The files used for storing CSH data are standard
language files, in XLIFF format and stored in an extension's
:file:`Resources/Private/Language/` folder.

The files are typically named :file:`locallang_csh_(key).xlf`,
where "key" is either the table name or the module key.

This is an extract of a typical file
(:file:`typo3/sysext/lang/locallang_csh_pages.xlf`):

.. code-block:: xml

   <?xml version="1.0" encoding="UTF-8"?>
   <xliff version="1.0" xmlns:t3="http://typo3.org/schemas/xliff">
      <file t3:id="1415814856" source-language="en" datatype="plaintext" original="messages" date="2011-10-17T20:22:33Z" product-name="lang">
         <header/>
         <body>
            <trans-unit id=".description">
               <source>A 'Page' record usually represents a webpage in TYPO3. All pages have an ID number (UID) by which they can be linked and referenced. The 'Page' record itself does not contain the content of the page. 'Page Content' records (Content Elements) are used for this.</source>
            </trans-unit>
            <trans-unit id=".details" xml:space="preserve">
               <source>The 'pages' table is the backbone of TYPO3. All records editable by the main modules in TYPO3 must belong to a page. It's exactly like files and folders on your computer's hard drive.

   &lt;b&gt;The Page Tree&lt;/b&gt;
   The pages are organized in a tree structure that reflects the organization of your website.

   &lt;b&gt;UID, PID and the page tree root&lt;/b&gt;
   All database elements have a field 'uid' which is a unique identification number. They also have a field 'pid' (page id) which holds the ID number of the page to which they belong. If the 'pid' field is zero, the record is found in the 'root.' Only administrators are allowed access to the root. Table records must be configured to either belong to a page or be found in the root.

   &lt;b&gt;Storage of Database Records&lt;/b&gt;
   Depending on the 'Type', a page may also represent general storage for database elements in TYPO3. In this case, it is not available as a webpage but is used internally in the page tree as a place to store items such as users, subscriptions, etc. Such pages are typically of the type "Folder".</source>
            </trans-unit>
            <trans-unit id="_.seeAlso" xml:space="preserve">
               <source>xMOD_csh_corebe:pagetree,
   tt_content,
   About pages | https://docs.typo3.org/typo3cms/GettingStartedTutorial/GeneralPrinciples/PageTree/</source>
               <note from="developer">A part of this string is an internal text, which must not be changed. Just copy this part into the translation field and do not change it. For more information have a look at the Tutorial.</note>
            </trans-unit>
            <trans-unit id="_.image" xml:space="preserve">
               <source>EXT:core/Resources/Public/Images/cshimages/pages_1.png,
   EXT:core/Resources/Public/Images/cshimages/pages_2.png,</source>
               <note from="developer">This string contains an internal text, which must not be changed. Just copy the original text into the translation field. For more information have a look at the Tutorial.</note>
            </trans-unit>
            <trans-unit id=".image_descr" xml:space="preserve">
               <source>The most basic fields on a page are the 'Disable Page' option, the 'Type' of page ("doktype") and the 'Page Title'.
   Pages are arranged in a page tree in TYPO3. The page from the editing form in the previous screenshot was the "Intro" page from this page tree. As you can see it belongs in the root of the page tree and has a number of subpages pages under it.</source>
            </trans-unit>
            <trans-unit id="title.description">
               <source>Enter the title of the page or folder. This field is required.</source>
            </trans-unit>
            <trans-unit id="title.details" xml:space="preserve">
               <source>The 'Page Title' is used to represent the page visually in the system, for example in the page tree. Also the 'Page Title' is used by default for navigation links on webpages.
   You can always change the 'Page Title' without affecting links to a page. This is because pages are always referenced by ID number, not their title.
   You can use any characters in the 'Page Title'.</source>
            </trans-unit>
            <trans-unit id="_title.image">
               <source>EXT:core/Resources/Public/Images/cshimages/pages_3.png</source>
               <note from="developer">This string contains an internal text, which must not be changed. Just copy the original text into the translation field. For more information have a look at the Tutorial.</note>
            </trans-unit>
            <trans-unit id="title.image_descr">
               <source>The field for the 'Page Title' has a small "Required" icon next to it; You must supply a 'Page Title'. You cannot save the new page unless you enter a title for it.</source>
            </trans-unit>
            // ...
         </body>
      </file>
   </xliff>

As you can see, the names of the keys inside the language file
(the "id" attribute) follow strict conventions. Each key is
divided into two parts, separated by a dot (:code:`.`). For
a database table, the first part is the name of the field
(for a backend module, an arbitrary but significant string).
The second part is a so-called "type key". The list of
type keys and their syntax is described below.

The first part of the key may be absent (as in the first entries
in the above example). This represents a general help text. This
text is never displayed directly as inline help, but appears in
the popup window when a user accesses the full CSH for a given
table or module (by selecting it from the CSH table of contents).

.. note::

   Some fields are prefixed with an underscore (:code:`_`).
   This is historical and has no meaning anymore.


.. _csh-files-syntax:

Syntax for Type Keys
====================

.. note::

   When it is mentioned that an item may contain "escaped HTML", it
   means that any tag must be written with entities. Example: do not
   write :code:`<strong>` but :code:`&lt;strong&gt;`.

description
  A short description of the table field or module feature.
  This is the text that appears in the help tool tip.

  May contained escaped HTML.

details
  A longer text detailing the table field or module feature.
  This text does not appear in the help tool tip but in the
  full popup window.

  May contained escaped HTML.

syntax
  Similar to details, but meaning to explicit the syntax to use
  in the given field.

  May contained escaped HTML.

alttitle
  Alternative title shown in CSH pop-up window.

  For database tables and fields the title from TCA is fetched by
  default, however overridden by this value if it is not blank.

  For modules you must specify this value, otherwise you will see the bare module key.

image
  Reference to an image (gif,png,jpg) which will be shown below the
  "details" and "syntax" field (but before "seeAlso").

  The reference must use the "EXT:" syntax.

  You can supply a comma-separated list of image references in order to show more
  than one image.


image\_descr
  A description displayed below the image. If several images were
  referenced, the "image\_descr" value will be split on linebreaks
  and shown under each image.


seeAlso
  Internal hyperlink system for related elements. References to other
  :code:`$TCA_DESCR` elements or URLs.

  **Syntax:**

  - Separate references by comma (,) or line breaks.

  - A reference can be:

    - either a URL (identified by the 'second part' being prefixed "http",
      see below)

    - or a [table]:[field] pair

  - If the reference is an external URL, then the reference is split on the pipe
    character (:code:`|`). The first part is the link label, while the
    second part is a fully qualified URL.

  - If the reference is to another internal :code:`$TCA_DESCR` element, the
    reference is split on the colon (:code:`:`). The first part is the *table*
    while the second is the *field*.

  External URLs will open in a blank window. Internal references will open in the same window.

  For internal references the permission for table/field read access
  will be checked and if it fails, the reference will not be shown.

  **Example:**

  .. code-block:: text

     pages:starttime , pages:endtime , tt\_content:header , Link to TYPO3.org \| http://typo3.org/


.. _csh-files-extend-label:

Extending an Existing Label
===========================

It is also possible to extend an existing label. Here is an extract from
:file:`typo3/sysext/core/Resources/Private/Language/locallang_csh_pages.xlf`:

.. code-block:: xml

   <trans-unit id="title.description.+">
      <source>This is normally shown in the website navigation.</source>
   </trans-unit>

This file also targets the "pages" table. The key :code:`title.description.+`
(note the trailing :code:`+` sign) means that this label will be added to the
existing description for the "title" field.

Thus extensions can enhance existing labels for their special purpose while
retaining the original CSH content.
