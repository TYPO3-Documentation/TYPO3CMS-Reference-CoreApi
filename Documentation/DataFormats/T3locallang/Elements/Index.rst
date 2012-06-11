

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


Elements
^^^^^^^^

This is the elements and their nesting in the locallang-XML format.


Elements nesting other elements (“Array” elements):
"""""""""""""""""""""""""""""""""""""""""""""""""""

All elements defined here cannot contain any string value but  *must*
contain another set of elements.

(In a PHP array this corresponds to saying that all these elements
must be arrays.)

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Element
         Element
   
   Description
         Description
   
   Child elements
         Child elements


.. container:: table-row

   Element
         <T3locallang>
   
   Description
         Document tag
   
   Child elements
         <meta>
         
         <data>
         
         <orig\_hash>
         
         <orig\_text>


.. container:: table-row

   Element
         <meta>
   
   Description
         Contains meta data about the locallang-XML file. Used in translation,
         but not inside TYPO3 directly.
   
   Child elements
         <labelContext>
         
         <description>
         
         <type>
         
         <csh\_table>


.. container:: table-row

   Element
         <data>
   
   Description
         Contains the data for translations
         
         **Notice:** The contents in the <data> tag is  *all that is needed for
         labels inside TYPO3* . Everything else is meta information for the
         translation tool!
   
   Child elements
         <languageKey>


.. container:: table-row

   Element
         <orig\_hash>
   
   Description
         Contains hash-integers for each translated label of the default label
         at the point of translation. This is used to determine if the default
         label has changed since the translation was made.
   
   Child elements
         <languageKey>


.. container:: table-row

   Element
         <orig\_text>
   
   Description
         Contains the text of the default label that was the basis of the
         translated version! The original text is used to show a diff between
         the original base of the translation and the new default text so a
         translator can quickly see what has changed.
   
   Child elements
         <languageKey>


.. container:: table-row

   Element
         <languageKey>
   
   Description
         Array of labels for a language. The "index" attribute contains
         language key.
         
         There are two cases in the context “<data>” to note:
         
         - index = “default”: Array of default labels.
         
         - index = [language key] :
           
           - If string: Pointer to external file containing translation, e.g.
             “EXT:csh\_dk/lang/dk.locallang\_csh\_web\_info.xml”
           
           - If array: Translations inline in main file (deprecated)
           
           - [If not existing,  *recommended* ]: Translations in external default
             file typo3conf/l10n/
   
   Child elements
         <label>
         
         *Alternatively, when used under <data> it can be a string pointing to
         an external "include file"!*


.. container:: table-row

   Element
         <labelContext>
   
   Description
         Array of context descriptions of the default labels.
         
         The "index" attribute contains label key
   
   Child elements
         <label>


.. ###### END~OF~TABLE ######


Elements containing values (“Value” elements):
""""""""""""""""""""""""""""""""""""""""""""""

All elements defined here must contain a string value and no other XML
tags whatsoever!

All values are in utf-8.

(In a PHP array this corresponds to saying that all these elements
must be strings or integers.)

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Element
         Element
   
   Format
         Format
   
   Description
         Description


.. container:: table-row

   Element
         <label> (under <data>)
   
   Format
         string
   
   Description
         Value of a original/translated label.
         
         The "index" attribute contains label key.


.. container:: table-row

   Element
         <label> (under <orig\_hash>)
   
   Format
         integer
   
   Description
         Hash of a translated label.
         
         The "index" attribute contains label key.


.. container:: table-row

   Element
         <label> (under <orig\_text>)
   
   Format
         string
   
   Description
         Original default value of a translated label used for making a diff if
         the original has changed.
         
         The "index" attribute contains label key.


.. container:: table-row

   Element
         <label>
         
         (child of <labelContext>)
   
   Format
         string
   
   Description
         Description of a default labels context. This should be used where it
         cannot be clear for the translation where the default labels occur.
         Sometimes the context is important for the translator in order to
         translate correctly.
         
         The "index" attribute contains label key.


.. container:: table-row

   Element
         <description>
   
   Format
         string
   
   Description
         Description of the file contents.


.. container:: table-row

   Element
         <type>
   
   Format
         string
   
   Description
         Type of content. Possible values are:
         
         - "module" : Used for labels in the backend modules.
         
         - "database" : Used for labels of database tables and fields.
         
         - "CSH" : Used for Context Sensitive Help (both database tables, fields,
           backend modules etc.)


.. container:: table-row

   Element
         <csh\_table>
   
   Format
         string
   
   Description
         (Only when the type is "CSH"!)
         
         For CSH it is important to know what "table" the labels belong to. A
         "table" in the context of CSH is an identification of a group of
         labels. This can be an actual table name (containing all CSH for a
         single table) or it can be module names etc. with a prefix to
         determine type. See CSH section in "Inside TYPO3" for more details.
         
         **Examples:**
         
         ::
         
            <csh_table>xMOD_csh_corebe</csh_table> (General Core CSH)
            <csh_table>_MOD_tools_em</csh_table> (For Extension Mgm. module)
            <csh_table>pages</csh_table> (For "pages" table)


.. ###### END~OF~TABLE ######


<T3locallangExt>
""""""""""""""""

External include files contains a sub-set of the tags of the
<T3locallang> format. Basically they contain the <data>, <orig\_hash>
and <orig\_text> tags but with "<languageKey>" tags inside only for
the specific language they used.

When the include file is read the information for the selected
language key is read from each of the three tags and merged into the
internal array.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Element
         Element
   
   Description
         Description
   
   Child elements
         Child elements


.. container:: table-row

   Element
         <T3locallangExt>
   
   Description
         Document tag for the external include files of "<T3locallang>"
   
   Child elements
         <data>
         
         <orig\_hash>
         
         <orig\_text>


.. container:: table-row

   Element
         <data>
   
   Description
         *See <data> element of <T3locallang> above.*
   
   Child elements


.. container:: table-row

   Element
         <orig\_hash>
   
   Description
         *See <data> element of <T3locallang> above.*
   
   Child elements


.. container:: table-row

   Element
         <orig\_text>
   
   Description
         *See <data> element of <T3locallang> above.*
   
   Child elements


.. ###### END~OF~TABLE ######


Example: locallang-XML file for a backend module
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This example shows a standard locallang-XML file for a backend module.
Notice how the <orig\_hash> section is included which means that
translators can spot if an original label changes. However the
"<orig\_text>" section would have been needed if translators were
supposed to also see the difference. But typically that is not enabled
since it takes a lot of space up.

::

   <T3locallang>
       <meta type="array">
           <description>Standard Module labels for Extension Development Evaluator</description>
           <type>module</type>
           <csh_table/>
           <labelContext type="array"/>
       </meta>
       <data type="array">
           <languageKey index="default" type="array">
               <label index="mlang_tabs_tab">ExtDevEval</label>
               <label index="mlang_labels_tabdescr">The Extension Development Evaluator tool.</label>
           </languageKey>
           <languageKey index="dk" type="array">
               <label index="mlang_tabs_tab">ExtDevEval</label>
               <label index="mlang_labels_tabdescr">Evalueringsværktøj til udvikling af extensions.</label>
           </languageKey>
   ....
       </data>
       <orig_hash type="array">
           <languageKey index="dk" type="array">
               <label index="mlang_tabs_tab" type="integer">114927868</label>
               <label index="mlang_labels_tabdescr" type="integer">187879914</label>
           </languageKey>
       </orig_hash>
   </T3locallang>


Example: locallang-XML file (CSH) with reference to external include file
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The main XML file looks like this. Notice the tag "csh\_table" has a
value which is important for CSH content so it can be positioned in
the right category.

In the <data> section you can see all default labels. But notice how
the value for the "dk" translation is a reference to an external file!
The contents of that file is shown below this listing.

::

   <T3locallang>
       <meta type="array">
           <description>CSH for Web&gt;Info module(s) (General Framework)</description>
           <type>CSH</type>
           <csh_table>_MOD_web_info</csh_table>
           <labelContext type="array"/>
       </meta>
       <data type="array">
           <languageKey index="default" type="array">
               <label index=".alttitle">Web &gt; Info module</label>
               <label index=".description">The idea of the Web&gt;Info ...</label>
               <label index=".details">Conceptually the Web&gt;Info mod...functionality.</label>
               <label index="_.seeAlso">_MOD_web_func,</label>
               <label index="_.image">EXT:lang/cshimages/pagetree_overview_10.png</label>
               <label index=".image_descr">The Web&gt;Info module a.... &quot;info_pagetsconfig&quot;.</label>
           </languageKey>
           <languageKey index="dk">EXT:csh_dk/lang/dk.locallang_csh_web_info.xml</languageKey>
       </data>
   </T3locallang>

The include file (for "dk") looks like below.

::

   <T3locallangExt>
       <data type="array">
           <languageKey index="dk" type="array">
               <label index="pagetree_overview.alttitle">Sidetræ overblik</label>
           </languageKey>
       </data>
       <orig_hash type="array">
           <languageKey index="dk" type="array">
               <label index="pagetree_overview.alttitle" type="integer">92312309</label>
           </languageKey>
       </orig_hash>
       <orig_text type="array">
           <languageKey index="dk" type="array">
               <label index="pagetree_overview.alttitle">Pagetree Overview</label>
           </languageKey>
       </orig_text>
   </T3locallangExt>

135


