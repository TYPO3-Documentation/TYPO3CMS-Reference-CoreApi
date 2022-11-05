.. include:: /Includes.rst.txt
.. index::
   Fluid Templates; Multi-language
   Localization; Fluid templates
.. _extension-localization-fluid:

==============================
Multi-language Fluid templates
==============================

Consider you have to translate the following static texts in your Fluid
template:

.. code-block:: html
   :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

   <h3>{post.title}</h3>
   <p>By: {post.author.fullName}</p>
   <p>{post.content -> f:format.nl2br()}</p>

   <h3>Comments</h3>
   <f:for each="{post.comments}" as="comment">
     {comment.content -> f:format.nl2br()}
     <hr>
   </f:for>

To make such texts exchangeable, they have to be removed from the Fluid
template and inserted into an :ref:`XLIFF language file <xliff>`. Every text
fragment to be translated is assigned an identifier (also called key)
that can be inserted into the Fluid template.

.. index::
   pair: Fluid; Localization
   Fluid; f:translate

.. _f-translate:

The translation ViewHelper :html:`f:translate`
==============================================

To insert translations into a template, Fluid offers the ViewHelper
:ref:`f:translate <t3viewhelper:typo3-fluid-translate>`.

This ViewHelper has a property called :html:`key` where the identifier of
the text fragment prefixed by the location file can be provided.

.. code-block:: html
   :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

   <f:translate key="LLL:EXT:my_extension/Resources/Private/Language/yourFile.xlf:yourKey" />
   <!-- or as inline Fluid: -->
   {f:translate(key: 'LLL:EXT:my_extension/Resources/Private/Language/yourFile.xlf:yourKey')}


The text fragment will now be displayed in the current frontend language
defined in the site configuration, if the translation file of the requested
language can be found in the location of the prefix.

If the key is not available in the translated file or if the language file is not
found in the language, the key is looked up in the default language file. If
it is not found there, nothing is displayed.

You can provide a default text fragment in the property :html:`default` to
avoid no text being displayed:

.. code-block:: html
   :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

   <f:translate
       key="LLL:EXT:my_extension/Resources/Private/Language/yourFile.xlf:yourKey"
       default="No translation available."
   />

.. _f-translate-extbase:

The translation ViewHelper in Extbase
=====================================

In Extbase, the translation file can be detected automatically. It is therefore
possible to omit the language file prefix.

.. code-block:: html
   :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

   <f:translate key="commentHeader" />
   <!-- or as inline Fluid: -->
   {f:translate(key: 'commentHeader')}


In Extbase plugins :html:`<f:translate key="commentHeader" />` looks up the key in
:html:`LLL:EXT:my_example/Resources/Private/Language/locallang.xlf:commentHeader`.

The language string can be overridden by the values from
:typoscript:`_LOCAL_LANG`. See also :ref:`property _LOCAL_LANG in a
plugin <t3tsref:setup-plugin-local-lang-lang-key-label-key>`.

.. attention::
   This short notation triggers TypoScript parsing via the Extbase
   ConfigurationManager. It should be avoided in backend context, for example
   in backend modules.

It is possible to use the translation file of another extension by supplying
the parameter :html:`extensionName` with the UpperCamelCased extension key:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

    <f:translate key="commentHeader" extensionName="MyOtherExtension" />

..  note::
    The translation file has to be located at
    :file:`EXT:my_other_extension/Resources/Private/Language/locallang.xlf`
    in the other extension as well.

There is no fallback to the file of the original extension in this case.

By replacing all static texts with translation ViewHelpers the above example
can be replaced:

.. code-block:: html
   :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

   <h3>{post.title}</h3>
   <p><f:translate key="authorPrefix"> {post.author.fullName}</p>
   <p>{post.content -> f:format.nl2br()}</p>
   <h3><f:translate key="commentHeader"></h3>
   <f:for each="{post.comments}" as="comment">
      {comment.content -> f:format.nl2br()}
      <hr>
   </f:for>

Source of the language file
============================

If the Fluid template is called outside of an Extbase context there are two
options on how to configure the correct language file.


.. rst-class:: bignums

#.  Use the complete language string as key:

    Prefix the translation key with :html:`LLL:EXT:` and then the path to
    the translation file, followed by a colon and then the translation key.

    .. code-block:: html
       :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

       <f:translate
           key="LLL:EXT:my_extension/Resources/Private/Language/yourFile.xlf:yourKey"
       />

#.  Or provide the parameter :html:`extensionName`:

    .. code-block:: html
       :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

       <f:translate
           key="yourKey"
           extensionName="MyExtension"
       />

    If the :html:`extensionName` is provided, the translation string is searched in
    :file:`EXT:my_extension/Resources/Private/Language/locallang.xlf`.


.. index::
   Localization; sprintf
   Localization; Arguments

..  _extension-localization-fluid-arguments:

Insert arguments into translated strings
========================================

In some translation situations it is useful to insert an argument into
the translated string.

Let us assume you want to translate the following sentence:

.. code-block:: html
   :caption: Example output

   Here is a list of 5 blogs:

As the number of blogs can change it is not possible to put the complete
sentence into the translation file.

We could split the sentence up into two parts. However in different languages
the number might have to appear in different positions in the sentence.

Splitting up the sentence should be avoided as the context would get lost in
translation. Especially when a translation agency is involved.

Instead it is possible to insert a placeholder in the translation file:

.. tabs::

   .. group-tab:: With arguments

      .. code-block:: xml
         :caption: EXT:my_extension/Resources/Private/Language/de.locallang.xlf

         <trans-unit id="blog.list" xml:space="preserve" approved="yes">
            <source>Here is a list of %d blogs: </source>
            <target>Eine Liste von %d Blogs ist hier: </target>
         </trans-unit>

   .. group-tab:: Bad example without arguments

      .. code-block:: xml
         :caption: Bad example! Don't use it!

         <trans-unit id="blog.list1" xml:space="preserve" approved="no">
            <source>Here is a list of </source>
            <target>Eine Liste von </target>
         </trans-unit>
         <trans-unit id="blog.list2" xml:space="preserve" approved="no">
            <source>blogs: </source>
            <target>Blogs ist hier: </target>
         </trans-unit>

Argument types
--------------

The placeholder contains the expected type of the argument to be inserted.
Common are:

:php:`%d`
    The argument is treated as an integer and presented as a (signed)
    decimal number. Example: :html:`-42`

:php:`%f`
    The argument is treated as a float and presented as a floating-point
    number (locale aware). Example: :html:`3.14159`

:php:`%s`
    The argument is treated and presented as a string. This can also be
    a numeral formatted by another ViewHelper
    Example: :html:`Lorem ipsum dolor`, :html:`59,99 €`, :html:`12.12.1980`

There is no placeholder for dates. Date and time values have to be formatted
by the according ViewHelper :html:`<f:format.date>`, see section
:ref:`localization of date output <extension-localization-fluid-date>` .

For a complete list of placeholders / specifiers see
`PHP function sprintf <https://www.php.net/manual/en/function.sprintf.php>`__.

Order of the arguments
----------------------

More than one argument can be supplied. However for grammatical reasons
the ordering of arguments may be different in the various languages.

One easy example are names. In English the first name is displayed followed by
a space and then the family name. In Chinese the family name comes first
followed by no space and then directly the first name. By the following
syntax the ordering of the arguments can be made clear:

.. code-block:: xml
   :caption: EXT:my_extension/Resources/Private/Language/zh.locallang.xlf

   <trans-unit id="blog.author" xml:space="preserve" approved="yes">
      <source>%1$s %2$s</source>
      <target>%2$s%1$s</target>
   </trans-unit>

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

    <f:translate
       key="author"
       arguments="{1: blog.author.firstName, 2: blog.author.lastname}"
    />

The authors name would be displayed in English as :html:`Lina Wolf` while
it would be displayed in Chinese like :html:`吴林娜` (WúLínnà).


.. index:: Localization; Date output
.. _extension-localization-fluid-date:

Localization of date output
===========================

It often occurs that a date or time must be displayed in a template.
Every language area has its own convention on how the date is to be
displayed: While in Germany, the date is displayed in the form
`Day.Month.Year`, in the USA the form
`Month/Day/Year` is used. Depending on the language, the date
must be formatted different.

Generally the date or time is formatted by the
:html:`<f:format.date>` ViewHelper:

.. code-block:: html
   :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

   <f:format.date date="{dateObject}" format="d.m.Y" />
   <!-- or -->
   {dateObject -> f:format.date(format: 'd.m.Y')}

The date object :html:`{dateObject}` is displayed with the date
format given in the parameter :html:`format`. This format string must
be in a format that is readable by the PHP function :php:`date()`
and declares the format of the output.

..  seealso::
    *   :ref:`f:format.date in the ViewHelper Reference <t3viewhelper:typo3-fluid-format-date>`
    *   `PHP function date() <https://www.php.net/manual/en/function.date.php>`__

The table below shows some important
placeholders:

================ =========================================================== =========
Format character Description                                                 Example
================ =========================================================== =========
d                Day of the month as number, double-digit, with leading zero 01 ... 31
m                Month as number, with leading zero                          01 ... 12
Y                Year as number, with 4 digits                               2011
y                Year as number, with 2 digits                               11
H                Hour in 24 hour format                                      00 ... 23
i                Minutes, with leading zero                                  00 ... 59
================ =========================================================== =========

Depending on the language area, another format string should be used.

Here we combine the :html:`<f:format.date>`
ViewHelper with the :html:`<f:translate>` ViewHelper to supply a localized
date format:

.. code-block:: html
   :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

   <f:format.date date="{dateObject}" format="{f:translate(key: 'dateFormat')}" />

Then you can store another format string for every language in the
:file:`locallang.xlf` file.

.. tip::

    There are other formatting ViewHelpers for adjusting the output of
    currencies or big numbers. These ViewHelpers all starts with
    :html:`<f:format`. You can find an overview of these ViewHelpers in
    the :doc:`ViewHelper Reference: format <t3viewhelper:typo3/fluid/latest/Format/Index>`.
