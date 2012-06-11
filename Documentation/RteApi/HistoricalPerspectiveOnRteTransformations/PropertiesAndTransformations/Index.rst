

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


Properties and 'transformations'
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The RTE applications typically expect to be fed with content formatted
as HTML. In effect an RTE will discard content it doesn't like, for
instance fictitious HTML tags and line breaks. Also the HTML content
created by the RTE editor is not necessarily as 'clean' as you might
like.

The editor has the ability to paste in formatted content copied/cut
from other websites (in which case images are included!) or from text
processing applications like MS Word or Star Office. This is a great
feature and may solve the issue of transferring formatted content from
e.g. Word into TYPO3.

However these inherent features - good or bad - raises the issue how
to handle content in a field which we do not wish to 'pollute' with
unnecessary HTML-junk. One perspective is the fact that we might like
to edit the content with Netscape later (for which the RTE cannot be
used, see above) and therefore would like it to be 'human readable'.
Another perspective is if we might like to use only Bold and Italics
but not the alignment options. Although you can configure the editor
to display  *only* the bold and italics buttons, this does  *not*
prevent users from pasting in HTML-content copied from other websites
or from Microsoft Word which  *does* contain tables, images, headlines
etc.

The answer to this problem is a so called 'transformation' which you
can configure in the $TCA (global, authoritative configuration) and
which you may further customize through Page TSconfig (local
configuration for specific branches of the website). The issue of
transformations is best explained by the following example from the
table, tt\_content (the content elements).

