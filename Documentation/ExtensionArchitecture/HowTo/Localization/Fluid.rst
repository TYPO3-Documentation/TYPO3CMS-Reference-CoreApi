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

Insert variables in translated strings
======================================

.. todo: remove fluff

In the above example, we have outputted the blog post
author's name simply by using ``{blog.author.fullName}``. Many
languages have special rules on how names are to be used - especially in
Thailand, it is common to only show the first name and place the word
"Khan" in front of it (which is a polite form). We want to enhance our
template now as far as it can to output the blog author's name
according to the current language. In German and English, this is the
form "first name last name" and in Thai "Khan first name".

Also, for these use cases, the ``translate`` ViewHelper can
be used. With the aid of the array ``arguments,`` values can be
embedded into the translated string. To do this, the syntax of the PHP
function ``sprintf`` is used.

If we want to implement the above example, we must assign the
first name and the last name of the blog author separate to the
``translate`` ViewHelper:


.. code-block:: html
   :caption: EXT:blog_example/Resources/Private/Templates/SomeTemplate.html

   <f:translate key="name" arguments="{1:post.author.firstName, 2: post.author.lastName}" />

How should the corresponding string in the
:file:`locallang.xml` file looks like? It describes in
which position the placeholder is to be inserted. For English and
German it looks like this:

.. code-block:: html
   :caption: EXT:blog_example/Resources/Private/Language/locallang.xlf

   <label index="name">%1$s %2$s</label>

Important are the placeholder strings ``%1$s`` and
``%2$s``. These will be replaced with the assigned parameters.
Every placeholder starts with the % sign, followed by the position
number inside the arguments array, starting with 1, followed by the $
sign. After that, the usual formatting specifications follow - in the
example, it is the data type ``string (s)``. Now we can define
for Thai that "Khan" followed by the first name should be
output:

.. code-block:: html
   :caption: EXT:blog_example/Resources/Private/Language/th.locallang.xlf

   <label index="name">Khan %1$s</label>

.. tip::

    The keys in the argument array of the ViewHelper have no
    relevance. We recommend to give them numbers like the positions
    (starting with 1), because it is easily understandable.

.. tip::

    For a full reference of the formatting options for
    ``sprintf`` you should have a look at the PHP documentation:
    *http://php.net/manual/de/function.sprintf.php*.


.. index:: Localization; TypoScript

Changing localized terms using TypoScript
=========================================


.. todo: does this work in TYPO3 or only extbase?

If you use an existing extension for a customer project, you
sometimes find out that the extension is insufficient translated or that
the translations have to be adjusted. TYPO3 offers the possibility to
overwrite the localization of a term by TypoScript. Fluid also supports
this.

If, for example, you want to use the text "Remarks" instead of the
text "Comments", you have to overwrite the identifier
``comment_header`` for the English language. For this, you can
add the following line to your TypoScript template:

.. code-block:: typoscript
   :caption: EXT:blog_example/Configuration/TypoScript/setup.typoscript

   plugin.tx_blogexample._LOCAL_LANG.default.comment_header = Remarks

With this, you will overwrite the localization of the term
``comment_header`` for the default language in the blog
example. So you can adjust the translation of the texts like you wish,
without changing the :file:`locallang.xml` file.

Until now, we have shown how to translate a static text of templates.
Of course, an extension's data must be
translated according to the national language. We will show this in the
next section.
