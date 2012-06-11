

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


Page TSconfig
^^^^^^^^^^^^^

The RTEs can be configured by Page TSconfig. There is a top level
object name, "RTE", that is used for this. The main object paths looks
like this:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:


.. container:: table-row

   Property
         default.[...]
         
         config.[ *tablename* ].[ *field* ].[...]
         
         config.[ *tablename* ].[ *field* ].types.[ *type* ].[...]
   
   Data type
         ->RTEconf
   
   Description
         These objects contain the actual configuration of the RTE interface.
         For the properties available, refer to the table below.This is a
         description of how you can customize in general and override for
         specific fields/types.
         
         'RTE.default' configures the RTE for all tables/fields/types
         
         'RTE.config.[ *tablename* ].[ *field* ]' configures a specific field.
         The values inherit the values from 'RTE.default' in fact this is
         overriding values.
         
         'RTE.config.[ *tablename* ].[ *field* ].types.[ *type* ]' configures a
         specific field in case the 'type'-value of the field matches  *type* .
         Again this overrides the former settings.


.. container:: table-row

   Property
         [individual RTE options]
   
   Data type
         -
   
   Description
         There are other options to set for the RTE toplevel object. These
         depends on the individual RTEs though! So there can be no further
         reference in this table to these properties.
         
         Generally the "rte" (classic MSIE RTE) will set the standard for
         configuration options, so you can refer to the documentation for that
         RTE for more details. On the top level of the RTE object you will
         normally find that general collections of classes, styles etc. are
         configured.


.. ###### END~OF~TABLE ######

[page:RTE]


((generated))
"""""""""""""

Configuration examples
~~~~~~~~~~~~~~~~~~~~~~

This configuration in "Page TSconfig" will disable the RTE altogether:

::

   RTE.default.disabled = 1

In the case below the RTE is still disabled generally, but this is
overridden specifically for the table "tt\_content" where the RTE is
used in the field "bodytext"; The "disabled" flag is set to false
again which means that for Content Elements the RTE will be available.

::

   RTE.default.disabled = 1
   RTE.config.tt_content.bodytext.disabled = 0

In this example the RTE is still enabled for content elements in
generally but if the Content Element type is set to "Text" (text) then
the RTE will be disabled again!

::

   RTE.default.disabled = 1
   RTE.config.tt_content.bodytext.disabled = 0
   RTE.config.tt_content.bodytext.types.text.disabled = 1


The RTE object in Page TSconfig
"""""""""""""""""""""""""""""""

The RTE object contains configuration of the RTE application. There
are a few properties which are used externally from the RTE. The
property "disabled" will simply disable the rendering of the RTE and
"proc" is reserved to contain additional configuration of
transformations.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:


.. container:: table-row

   Property
         disabled
   
   Data type
         boolean
   
   Description
         If set, the editor is disabled.
         
         This option is evaluated in t3lib\_TCEforms where it determines if the
         RTE is rendered or not.


.. container:: table-row

   Property
         proc
   
   Data type
         ->PROC
   
   Description
         Customization of the server processing of the content - also called
         'transformations'. See table below.
         
         The transformations are only initialized, if they are configured
         (“rte\_transform” must be set for the field in the types-definition in
         TCA.)
         
         The "->PROC" object is processed in "t3lib\_parsehtml\_proc" and is
         *independant* of the particular RTE used (like transformations
         generally is!)


.. container:: table-row

   Property
         [individual RTE options]
   
   Data type
         -
   
   Description
         Each RTE may use additional properties for the RTE. Typically such
         properties relates to the features of the RTE application. For
         instance you could configure which tool bar buttons are available etc.


.. ###### END~OF~TABLE ######

[page:->RTEconf]


Configuration examples
~~~~~~~~~~~~~~~~~~~~~~

::

      0: RTE.default >
      1: RTE.default {
      2:   mainStyle_font = Arial, sans-serif
      3:   mainStyle_size = 12
      4:   mainStyle_color = black
      5:   classesParagraph = redText
      6:   classesCharacter = redText
      7:   showButtons = cut,copy,fontstyle,fontsize, textcolor,table,bgcolor
      8:   proc.preserveTables = 1
      9:    
     10:   proc.entryHTMLparser_db = 1
     11:   proc.entryHTMLparser_db {
     12:     keepNonMatchedTags = 1
     13:     xhtml_cleaning = 1
     14:   }
     15:    
     16:   mainStyleOverride_add {
     17:     P =  font-family:Arial, sans-serif; font-size:12;
     18:     H1 =  font-family:Arial, sans-serif; font-size:16;  font-weight:bold; margin-top:0;margin-bottom:10;
     19:     H2 =  font-family:Arial, sans-serif; font-size:12;  font-weight:bold; color:navy; margin-top:0;margin-bottom:10;
     20:     H3 =  font-family:Arial, sans-serif; font-size:18;  font-weight:bold;
     21:     H4 =  font-family:Arial, sans-serif; font-size:24; 
     22:     H5 =  font-family:Arial, sans-serif; font-size:20;  color:navy; font-weight:normal;  margin-top:0;margin-bottom:10;
     23:     H6 =  font-family:Arial, sans-serif; font-size:16;  font-weight:bold;
     24:   }
     25:   disablePCexamples = 0
     26: }

In this example all the configuration except line 8-14 ("proc."
configuration) is defining the RTE applications internal features.
These options will vary depending on the RTE used. In this case the
configuration is for the classic MSIE Active-X RTE in the extension
"rte".


The ->PROC object
"""""""""""""""""

This object contains configuration of the transformations used. These
options are  *universal for all RTEs* and used inside the class
"t3lib\_parsehtml\_proc".

The main objective of these options is to allow for minor
configuration of the transformations. For instance you may disable the
mapping between <B>-<STRONG> and <I>-<EM> tags which is done by the
'ts\_transform' transformation. Or you could disable the default
transfer of images from external URL to the local server. This is all
possible through the options.

Notice how many properties relates to specific transformations only!
Also notice that the meta-transformations "ts" and "ts\_css" implies
other transformations like "ts\_transform" and "css\_transform" which
means that options limited to "ts\_transform" will also work for "ts"
of course.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         Property:
   
   Data type
         Data type:
   
   Description
         Description:


.. container:: table-row

   Property
         overruleMode
   
   Data type
         List of RTE transformations
   
   Description
         This can overrule the RTE transformation set from TCA.
         
         Notice, this is a  *comma list* of transformation keys. (Not a "dash-
         list" like in $TCA).


.. container:: table-row

   Property
         typolist
   
   Data type
         boolean
   
   Description
         *(Applies for “ts\_transform” only)*
         
         This enables/disables the conversion between <TYPOLIST> and <UL>
         sections. Default (if unset) is that "typolist" is enabled.
         
         **Example that disables "typolist":**
         
         typolist = 0


.. container:: table-row

   Property
         typohead
   
   Data type
         boolean
   
   Description
         *(Applies for “ts\_transform” only)*
         
         This enables/disables the conversion between <TYPOHEAD> and <Hx>
         sections.
         
         **Example that disables "typohead":**
         
         typohead = 0


.. container:: table-row

   Property
         preserveTags
   
   Data type
         list of tags
   
   Description
         (DEPRECATED)
         
         Here you may specify a list of tags - possibly user-defined pseudo
         tags - which you wish to preserve from being removed by the RTE. See
         the information about preservation in the description of
         transformations.
         
         **Example:**
         
         In the default TypoScript configuration of content rendering the tags
         typotags <LINK>, <TYPOLIST> and <TYPOHEAD> are the most widely used.
         However the <TYPOCODE>-tag is also configured to let you define a
         section being formatted in monospace. Lets also imaging, you have
         defined a custom tag, <MYTAG>. In order to preserve these tag from
         removal by the RTE, you should configure like this.
         
         ::
         
            RTE.default.proc {
              preserveTags = TYPOCODE, MYTAG
            }
         
         Relates to the transformation 'ts\_preserve'


.. container:: table-row

   Property
         dontConvBRtoParagraph
   
   Data type
         boolean
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only (function
         divideIntoLines))*
         
         By default <BR> tags in the contentare converted to paragraphs.
         Setting this value will  *prevent* the convertion of <BR>-tags to new-
         lines (chr(10))


.. container:: table-row

   Property
         internalizeFontTags
   
   Data type
         boolean
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only (function
         divideIntoLines))*
         
         This splits the content into font-tag chunks.
         
         If there are any <P>/<DIV> sections inside of them, the font-tag is
         wrapped AROUND the content INSIDE of the P/DIV sections and the outer
         font-tag is removed.
         
         This functions seems to be a good choice for pre-processing content if
         it has been pasted into the RTE from e.g. star-office.
         
         In that case the font-tags is normally on the OUTSIDE of the sections.


.. container:: table-row

   Property
         allowTagsOutside
   
   Data type
         commalist of strings
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only (function
         divideIntoLines))*
         
         Enter tags which are allowed outsideof <P> and <DIV> sections when
         converted back to database.
         
         Default is “img”
         
         Example:
         
         IMG,HR


.. container:: table-row

   Property
         allowTagsInTypolists
   
   Data type
         commalist of strings
   
   Description
         *(Applies for “ts\_transform” only)*
         
         Enter tags which are allowed inside of <typolist> tags when content is
         sent to the database.
         
         Default is “br,font,b,i,u,a,img,span”


.. container:: table-row

   Property
         allowTags
   
   Data type
         commalist of strings
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only (function
         getKeepTags))*
         
         Tags to allow. Notice, this list is  *added* to the default list,
         which you see here:
         
         b,i,u,a,img,br,div,center,pre,font,hr,sub,sup,p,strong,em,li,ul,ol,blo
         ckquote,strike,span
         
         If you wish to deny some tags, see below.


.. container:: table-row

   Property
         denyTags
   
   Data type
         commalist of strings
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only (function
         getKeepTags))*
         
         Tags from above list to disallow.


.. container:: table-row

   Property
         transformBoldAndItalicTags
   
   Data type
         boolean
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only (function
         getKeepTags))*
         
         Default is to convert b and i tags to strong and em tags respectively
         in the direction of the database, and to convert back strong and em
         tags to b and i tags in the direction of the RTE.
         
         This transformation may be disabled by setting this property to 0.


.. container:: table-row

   Property
         HTMLparser\_rte
         
         HTMLparser\_db
   
   Data type
         ->HTMLparser
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only (function
         getKeepTags))*
         
         This is additional options to the HTML-parser calls which strips of
         tags when the content is prepared for the RTE and DB respectively. You
         can configure additional rules, like which other tags to preserve,
         which attributes to preserve, which values are allowed as attributes
         of a certain tag etc.
         
         .nestingGlobal for HTMLparser\_db is set by default to
         “b,i,u,a,center,font,sub,sup,strong,em,strike,span”unless another
         value is set.
         
         Also B/I tags are mapped to STRONG/EM tags in the RTE direction and
         vise versa.
         
         This parsing is done on a per-line basis, so you cannot expect the
         paragraph tags (P or DIV) to be included.
         
         **Notice** the ->HTMLparser options, “keepNonMatchedTags” and
         “htmlSpecialChars” is NOT observed. They are preset internally


.. container:: table-row

   Property
         dontRemoveUnknownTags\_db
   
   Data type
         boolean
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only (function
         HTMLcleaner\_db))*
         
         Direction: To database
         
         Default is to remove all unknown tags in the content going to the
         database. (See HTMLparser\_db above for default tags). Generally this
         is a very usefull thing, because all kinds of bogus tags from pasted
         content like that from Word etc. will be removed to have clean content
         in the database.
         
         However this disables that and allows all tags, that are not in the
         HTMLparser\_db-list.


.. container:: table-row

   Property
         dontUndoHSC\_db
   
   Data type
         boolean
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only (function
         HTMLcleaner\_db))*
         
         Direction: To database
         
         Default is to re-convert literals to characters (that is &lt; to <)
         outside of HTML-tags. This is disabled by this boolean. (HSC means
         HtmlSpecialChars - which is a PHP function)


.. container:: table-row

   Property
         dontProtectUnknownTags\_rte
   
   Data type
         boolean
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only (function
         setDivTags))*
         
         Direction: To RTE
         
         Default is that tags unknown to HTMLparser\_rte is “protected” when
         sent to the RTE. This means they are converted from eg <MYTAG> to
         &lt;MYTAG&gt;. This is normally very fine, because it can be edited
         plainly by the editor and when returned to thedatabase the tag is (by
         default, disabled by .dontUndoHSC\_db) converted back.
         
         Setting this option will prevent unknown tags from becoming protected.


.. container:: table-row

   Property
         dontHSC\_rte
   
   Data type
         boolean
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only (function
         setDivTags))*
         
         Direction: To RTE
         
         Default is that all content outside of HTML-tags is passed through
         htmlspecialchars(). This will disable that. (opposite to
         .dontUndoHSC\_db)
         
         This option disables the default htmlspecialchars() conversion.


.. container:: table-row

   Property
         dontConvAmpInNBSP\_rte
   
   Data type
         boolean
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only (function
         setDivTags))*
         
         Direction: To RTE
         
         By default all &nbsp; codes are NOT converted to &amp;nbsp; which they
         naturally word (unless .dontHSC\_rte is set). You can disable that by
         this flag.


.. container:: table-row

   Property
         allowedFontColors
   
   Data type
         list of HTMLcolors
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only (function
         getKeepTags))*
         
         Direction: To DB
         
         If set, this is the only colors which will be allowed in font-tags!
         Case insensitive.


.. container:: table-row

   Property
         allowedClasses
   
   Data type
         list of strings
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only (function
         getKeepTags))*
         
         Direction: To DB
         
         Allowed general classnames when content is stored in database. Could
         be a list matching the number of defined classes you have.Case-
         insensitive.
         
         This might be a really good idea to do, because when pasting in
         content from MS word for instance there are a lot of <SPAN> and <P>
         tags which may have class-names in. So by setting a list of allowed
         classes, such foreign classnames are removed.
         
         If a classname is not found in this list, the default is to remove the
         class-attribute.


.. container:: table-row

   Property
         skipAlign
         
         skipClass
   
   Data type
         boolean
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only (function
         divideIntoLines))*
         
         If set, then the align and class attributes of <P>/<DIV> sections
         (respectively) will be ignored. Normally <P>/<DIV> tags are preserved
         if one or both of these attributes are present in the tag. Otherwise
         it's removed.


.. container:: table-row

   Property
         keepPDIVattribs
   
   Data type
         list of tag attributes (strings)
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only (function
         divideIntoLines))*
         
         “align” and “class” are the only attributes preserved for <P>/<DIV>
         tags. Here you can specify a list of other attributes to preserve.


.. container:: table-row

   Property
         remapParagraphTag
   
   Data type
         string / boolean
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only (function
         divideIntoLines))*
         
         When <P>/<DIV> sections are converted to be put into the database, the
         tag - P or DIV - is preserved. However setting this options to either
         P or DIV will force the section to be converted to the one or the
         other.
         
         If the value is set true (1), then it works as a general disable-flag
         for the whole section-convertion stuff here and the result will be no
         tags preserved what so ever. Just removed.


.. container:: table-row

   Property
         useDIVasParagraphTagForRTE
   
   Data type
         string
   
   Description
         *(Applies for “ts\_transform” only and "css\_transform" (function
         TS\_transform\_rte))*
         
         Use <DIV>-tags for sections when converting lines from database to
         RTE. Default is <P>. Applies only to lines which has NO tag wrapped
         around already.


.. container:: table-row

   Property
         preserveDIVSections
   
   Data type
         boolean
   
   Description
         *(Applies for “ts\_transform” and "css\_transform" only)*
         
         If set, div sections will be treated just like blockquotes. They will
         be treated recursively as external blocks.


.. container:: table-row

   Property
         preserveTables
   
   Data type
         boolean
   
   Description
         *(Applies for “ts\_transform”)*
         
         If set, tables are preserved


.. container:: table-row

   Property
         dontFetchExtPictures
   
   Data type
         boolean
   
   Description
         *(Applies for “ts\_images”)*
         
         If set, images from external urls are not fetched for the page if
         content is pasted from external sources. Normally this process of
         copying is done.


.. container:: table-row

   Property
         plainImageMode
   
   Data type
         boolean/string
   
   Description
         *(Applies for “ts\_images”)*
         
         If set, all “plain” local images (those that are not magic images)
         will be cleaned up in some way.
         
         If the value is just set, then the style attribute will be removed
         after detecting any special width/height CSS attributes (which is what
         the RTE will set if you scale the image manually) and the border
         attribute is set to zero.
         
         You can also configure with special keywords. So setting
         “plainImageMode” to any of the value below will perform special
         processing:
         
         “lockDimensions” : This will read the real dimensions of the image
         file and force these values into the <img> tag. Thus this option will
         prevent any user applied scaling in the image!
         
         “lockRatio” : This will allow users to scale the image but will
         automatically correct the height dimension so the aspect ratio from
         the original image file is preserved.
         
         “lockRatioWhenSmaller” : Like “lockRatio”, but will not allow any
         scaling larger than the original size of the image.


.. container:: table-row

   Property
         exitHTMLparser\_rte
         
         exitHTMLparser\_db
         
         entryHTMLparser\_rte
         
         entryHTMLparser\_db
   
   Data type
         boolean/->HTMLparser
   
   Description
         *(Applies for all kinds of processing)*
         
         Allows you to enable/disable the HTMLparser for the content before
         (entry) and after (exit) the content is processed with the predefined
         processors (e.g. ts\_images or ts\_transform).
         
         There is no default values set.


.. container:: table-row

   Property
         disableUnifyLineBreaks
   
   Data type
         boolean
   
   Description
         *(Applies for all kinds of processing)*
         
         When entering the processor all \r\n linebreaks are converted to \n
         (13-10 to 10). When leaving the processor all \n is reconverted to
         \r\n (10 to 13-10).
         
         This options disables that processing...


.. container:: table-row

   Property
         usertrans.[user-defined transformation key]
   
   Data type
         -
   
   Description
         Custom option-space for userdefined transformations.
         
         See example from section about custom transformations.


.. ###### END~OF~TABLE ######

[page:->PROC]

