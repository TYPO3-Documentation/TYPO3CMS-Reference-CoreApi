.. include:: /Includes.rst.txt
.. index::
   Fluid Templates; Multi-language
   Localization; Fluid templates
.. _extension-localization-fluid:

==============================
Multi-language Fluid templates
==============================

.. tip::
   Texts can also be translated direclty in the PHP code, for example in
   a ViewHelper. See :ref:`extension-localization-php`.

Consider you have to translate the following static texts in your Fluid
template:

.. code-block:: html
   :caption: EXT:blog_example/Resources/Private/Templates/SomeTemplate.html

   <h3>{post.title}</h3>
   <p>By: {post.author.fullName}</p>
   <p>{post.content -> f:format.nl2br()}</p>

   <h3>Comments</h3>
   <f:for each="{post.comments}" as="comment">
     {comment.content -> f:format.nl2br()}
     <hr>
   </f:for>

To make such texts exchangeable, they have to be removed from the Fluid
template and inserted into a
:ref:`language file <extension-localization-language-file>`. Every text
fragment which is to be translated is given an identifier (also called key)
that can be inserted in the Fluid template.

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


The text fragment will now me output in the current frontend language
defined in the site configuration if the translation file of the requested
langauge can be found in the location of the prefix.

If the key is not found in the translated file or if the language file is not
found in the language the key is searched in the default language file. If
it is not found there an error is thrown. This error can be prevented by
providing a default text fragment in the property :html:`default`:

.. code-block:: html
   :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

   <f:translate
       key="LLL:EXT:my_extension/Resources/Private/Language/yourFile.xlf:yourKey"
       default="No translation available."
   />

.. _f-translate-extbase:

The translation ViewHelper in Extbase
=====================================

In Extbase the translation file can be automatically detected. It is therefore
possible to omit the language file prefix.

.. code-block:: html
   :caption: EXT:blog_example/Resources/Private/Templates/SomeTemplate.html

   <f:translate key="comment_header" />
   <!-- or as inline Fluid: -->
   {f:translate(key: 'comment_header')}


:html:`<f:translate key="comment_header" />` looks up the key in
:html:`LLL:EXT:blog_example/Resources/Private/Language/locallang.xlf:comment_header`
**and** overrides the values from :typoscript:`_LOCAL_LANG` Extbase TypoScript.

.. attention::
   This short notation triggers TypoScript parsing via the Extbase
   ConfigurationManager. It should be avoided in backend context, for example
   in backend modules.

It is possible to use the translation file of another extension by supplying
the parameter :html:`extensionName` with the UpperCamelCased extension key:

.. code-block:: html
   :caption: EXT:blog_example/Resources/Private/Templates/SomeTemplate.html

   <f:translate key="comment_header" extensionName="MyExtendedBlogExample"/>

There is no fallback to the file of the original Extension in this case.

By replacing all static texts with translation ViewHelpers the above text
can be replaced:

.. code-block:: html
   :caption: EXT:blog_example/Resources/Private/Templates/SomeTemplate.html

   <h3>{post.title}</h3>
   <p><f:translate key="author_prefix"> {post.author.fullName}</p>
   <p>{post.content -> f:format.nl2br()}</p>
   <h3><f:translate key="comment_header"></h3>
   <f:for each="{post.comments}" as="comment">
      {comment.content -> f:format.nl2br()}
      <hr>
   </f:for>

Source of the language file
============================

If the Fluid template is called outside of an Extbase context there are two
options on how to configure the correct language file.

Use the complete language string as key:

Prefix the translation key with :html:`LLL:EXT:` and then the path to
the translation file, followed by a colon and then the translation key.

.. code-block:: html
   :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

   <f:translate
       key="LLL:EXT:my_extension/Resources/Private/Language/yourFile.xlf:yourKey"
   />

Or provide the parameter :html:`extensionName`:

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
translation. Especially when a translation agency is involved

Instead it is possible to insert a placeholder in the translation file:

.. tabs::

   .. group-tab:: With arguments

      .. code-block:: xml
         :caption: EXT:blog_example/Resources/Private/Language/de.locallang.xlf

         <trans-unit id="blog.list" xml:space="preserve" approved="yes">
            <source>Here is a list of %d blogs: </source>
            <target>Eine Liste von %d Blogs ist hier: </target>
         </trans-unit>

   .. group-tab:: Bad example without arguments

      .. code-block:: xml
         :caption: Bad example!

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
by the according ViewHelper first.

For a complete list of placeholders / specifiers see
`PHP function sprintf <https://www.php.net/manual/en/function.sprintf.php>`__

Order of the arguments
----------------------

More then one argument can be supplied. However for grammatical reasons
the ordering of arguments has to be different in different languages.

One easy example are names. In English the first name is displayed followed by
a space and then the family name. In Chinese the family name comes first
followed by no space and then directly the first name. By the following
syntax the ordering of the arguments can be made clear:

.. code-block:: xml
   :caption: EXT:blog_example/Resources/Private/Language/zh.locallang.xlf

   <trans-unit id="blog.author" xml:space="preserve" approved="yes">
      <source>%1$s %2$s</source>
      <target>%2$s%1$s</target>
   </trans-unit>

.. code-block:: html
   :caption:

   <f:translate
       key="blog.author"
       arguments="{1: blog.author.firstName, 2: blog.author.lastname}"
   >

The authors name would be displayed in English as :html:`Lina Wolf` while
it would be displayed in Chinese like :html:`吴林娜` (WúLínnà).
