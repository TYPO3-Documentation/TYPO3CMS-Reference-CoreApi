.. include:: /Includes.rst.txt
.. index::
   pair: Rich text editor; Custom
.. _rte-plug:

========================
Plugging in a custom RTE
========================

TYPO3 supports any Rich Text Editor for which someone might write a
connector to the RTE API. This means that you can freely choose
whatever RTE you want to use among those available from the Extension
Repository on typo3.org.

TYPO3 comes with a built-in RTE called "ckeditor", but other RTEs
are available in the TYPO3 Extension Repository and you can implement your
own RTE if you like.

.. _rte-api:

API for rich text editors
=========================

Connecting an RTE in an extension to TYPO3 is easy. The following example is
based on the implementation of ext:rte_ckeditor.

-  In the :file:`ext_localconf.php` you can use the FormEngine's NodeResolver
   to implement your own RichTextNodeResolver and give it a higher priority
   than the Core's implementation:

    ..  literalinclude:: _ext_localconf.php
        :language: php
        :caption: EXT:my_extension/ext_localconf.php

-  Now create the class :php:`\MyVendor\MyExtension\Form\Resolver\RichTextNodeResolver`.
   The RichTextNodeResolver needs to implement the NodeResolverInterface and
   the major parts happen in the resolve() function, where, if all conditions
   are met, the RichTextElement class name is returned:

    ..  literalinclude:: _RichTextNodeResolver.php
        :language: php
        :caption: :php:`\MyVendor\MyExtension\Form\Resolver\RichTextNodeResolver`

-  Next step is to implement the RichtTextElement class. You can look up the
   code of :t3src:`rte_ckeditor/Classes/Form/Element/RichTextElement.php`, which
   does the same for ckeditor. What basically happens in its render() function,
   is to apply any settings from the fields TCA config and then printing out all
   of the html markup and javascript necessary for booting up the ckeditor.
