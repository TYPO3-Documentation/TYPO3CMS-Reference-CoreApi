

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


Transformation details
^^^^^^^^^^^^^^^^^^^^^^

The transformations offered by the TYPO3 core are performed by the
class "t3lib\_parsehtml\_proc". Here follows a technical and detailed
description of the transformation filters available:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   DB -> RTE
         DB -> RTE

   RTE -> DB
         RTE -> DB


.. container:: table-row

   DB -> RTE
         ts\_transform, css\_transform


.. container:: table-row

   DB -> RTE
         function t3lib\_parseHTML::TS\_transform\_rte()

   RTE -> DB
         function t3lib\_parseHTML::TS\_transform\_db()


.. container:: table-row

   DB -> RTE
         - Sections by the tags TABLE,PRE,UL,OL,H1,H2,H3,H4,H5,H6 are not
           processed and thus just passed on to the RTE.

         - The content of <BLOCKQUOTE> sections are sent recursively through the
           ts\_transform filter. The tag remains.

         - <TYPOLIST> sections are converted to <OL> or <UL> sections, the latter
           is the case if the type parameter is set to 1.

           The conversion of TYPOLIST-tags can be disabled by setting the
           'proc.typolist' option. See later.

         - <TYPOHEAD> sections are converted to <Hx>-tags. The type parameter
           ranging from 1-5 determines which H-tag will be used. If no type
           parameter is set, H6 is used.

           The conversion of TYPOHEAD-tags can be disabled by setting the
           'proc.typohead' option. See later.

         - All content outside the tags already mentioned are now processed as
           follows:

         - Every line is wrapped in <P>-tags (configurable to DIV), if a line is
           empty a &nbsp; is set and if the line happens to be wrapped in
           DIV/P-tags already, it's not wrapped again (this might be the case if
           align or class parameters has been set).

         - Then <B> tags are mapped to <STRONG> tags and <I> tags are mapped to
           <EM> tags (This is how the RTE prefers it).

         - All content between the P/DIV tags outside of other allowed HTML-tags
           are htmlspecialchar()'ed. Thus only allowed HTML code is preserved and
           other "pseudo tags" are mapped to real text.

   RTE -> DB
         - Sections by the tag PRE are not processed and thus just passed on to
           the DB.

         - <TABLE>-sections are dissolved so only the text of the table cells
           remains. Every cell represents a new line. The reason for this action
           basically is that tables are not wanted in the 'Text'-types and they
           may also be nice to get rid of in case you have transferred content
           from other websites. (This can be disabled.)(Does NOT apply to
           "css\_transform")

         - The content of <BLOCKQUOTE> sections are sent recursively through the
           ts\_transform filter. The tag remains.

         - <OL> and <UL> sections are converted to <TYPOLIST> sections. If the
           bulletlist is <OL> (ordered list with numbers) the type parameter of
           the typolist is set to 1. Bulletlists in multiple levels are not
           supported.

           The conversion of TYPOLIST-tags can be disabled by setting the
           'proc.typolist' option. See later.

           (Does NOT apply to "css\_transform")

         - <Hx> sections are converted to <TYPOHEAD>-tags. The number of the Hx-
           tag ranging from 1-5 is set as the type-number of the TYPOHEAD tag.
           <H6> is equal to type=0 (default). Also the align parameter is
           preserved as well as the class parameter if set.

           The conversion of TYPOHEAD-tags can be disabled by setting the
           'proc.typohead' option. In that case the tag is preserved with the
           parameters align and class. See later.

           (Does NOT apply to "css\_transform")

         - All content outside these block are now processed as follows:

         - All <DIV> and <P> sections are dissolved into lines (unless align
           and/or class parameters are set).

         - <BR> tags are as well converted into newlines (configurable since this
           will resolve "soft linebreaks" into paragraphs!).

         - Then <STRONG> and <EM> tags are remapped to <B> and <I> tags. (This is
           more human readable. Configurable).

         - The list of allowed tags (configurable) is preserved - all other tags
           discarded (thus junk-tags from pasted content will not survive into
           the database!).

         - The content outside the allowed tags is de-htmlspecialchar()'ed - thus
           converted back to human-readable text. Furthermore the nesting of tags
           inside of P/DIV sections is preserved. For instance this: <P>One
           <U><B>two</B> three</P></U> will be converted to <P>One <B>two</B>
           three</P>. That is the U-tags being removed, because they were falsely
           nested with the <P> tags.


.. container:: table-row

   DB -> RTE
         ts\_preserve (deprecated)


.. container:: table-row

   DB -> RTE
         function t3lib\_parseHTML::TS\_preserve\_rte()

   RTE -> DB
         function t3lib\_parseHTML::TS\_preserve\_db()


.. container:: table-row

   DB -> RTE
         - If 'proc.preserveTags' are configured those tags are converted to
           <SPAN specialtag="...(the preserved tag rawurlencoded)...">-sections.
           Those are supposed to be let alone by the RTE.

   RTE -> DB
         - If 'proc.preserveTags' are configured <SPAN>-tags with the custom
           'specialtag' parameter set are converted back to the tag value
           contained in the specialtag-parameter.


.. container:: table-row

   DB -> RTE
         ts\_images


.. container:: table-row

   DB -> RTE
         function t3lib\_parseHTML::TS\_images\_rte()

   RTE -> DB
         function t3lib\_parseHTML::TS\_images\_db()


.. container:: table-row

   DB -> RTE
         - All <IMG>-tags are processed and if the value of the src-parameter
           happens  *not* to start with 'http' it's expected to be a relative URL
           and the current site URL is prefixed so the reference is absolute in
           the RTE as the RTE requires.

   RTE -> DB
         - All <IMG>-tags are processed and if the first part of the src-
           parameter is not the same as the current site URL, the image must be a
           reference to an external image. In that case the image is read from
           that URL and stored as a 'magic' image in the upload/ folder (can be
           disabled).

         - All magic images (that is images stored in the uploads/ folder
           (configured by TYPO3\_CONF\_VARS["BE"]["RTE\_imageStorageDir"],
           filenames prefixed with 'RTEmagicC\_' (child=actual image) and
           'RTEmagicP\_' (parent=original image))) are processed to see if the
           physical dimensions of the image on the server matches the dimensions
           set in the img-tag. If this is not the case, the user must have
           changed the dimensions and the image must be re-scaled accordingly.

         - Finally the absolute reference to the image is converted to a proper
           relative reference if the image URL is local.


.. container:: table-row

   DB -> RTE
         ts\_links


.. container:: table-row

   DB -> RTE
         function t3lib\_parseHTML::TS\_links\_rte()

   RTE -> DB
         function t3lib\_parseHTML::TS\_links\_db()


.. container:: table-row

   DB -> RTE
         - All <LINK>-tags (TypoScript specific) are converted to proper
           <A>-tags. The parameters of the <LINK>-tags are separated by space.
           The first parameter is the link reference (see typolink function in
           TSref for details on the syntax), second is the target if given (if
           '-' the target is not set), the third parameter is the class (if '-'
           the class is not set) and the fourth parameter is the title.

   RTE -> DB
         - All <A>-tags are converted to <LINK> tags, however only if they do not
           contain any parameters other than href, target and class. These are
           the only three parameters which can be represented by the TypoScript
           specific <LINK>-tag.


.. container:: table-row

   DB -> RTE
         ts\_reglinks


.. container:: table-row

   DB -> RTE
         function t3lib\_parseHTML::TS\_reglinks()

   RTE -> DB
         function t3lib\_parseHTML::TS\_reglinks()


.. container:: table-row

   DB -> RTE
         - All A-tags have URLs converted to absolute URLs if they are relative

   RTE -> DB
         - All A-tags have their absolute URLs converted to relative if possible
           (that is the URL is within the current domain).


.. ###### END~OF~TABLE ######

