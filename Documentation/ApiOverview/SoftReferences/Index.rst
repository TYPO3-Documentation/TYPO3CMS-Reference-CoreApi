.. include:: /Includes.rst.txt
.. index:: Soft references
.. _soft-references:

===============
Soft references
===============

**Soft References** are references to database elements, files, email addresses,
URLs etc. which are found inside of text fields.

For example, `tt_content.bodytext` can contain soft references to pages,
content elements and files. The page reference looks like this:

.. code-block:: html

   <a href="t3://page?uid=1">link to page 1</a>

In contrast to this, the field `pages.shortcut` contains the page id of a
shortcut. This is a reference, but not a *soft* reference.

The Soft Reference parsers are used by the system to find these references and
process them accordingly in import/export actions and copy operations. Also, the
soft references are used by integrity checking functions. For example, when you
try to delete a page, TYPO3 will warn you if there are incoming page links to
this page.

All references, soft and ordinary ones, are written to the reference index
(table :sql:`sys_refindex`).

You can define which soft reference parsers to use in the TCA field
:ref:`softref <t3tca:tca_property_softref>` which is available for
TCA column types :ref:`text <t3tca:columns-text>` and
:ref:`input <t3tca:columns-input>`.

.. index::
   Soft references; Default parsers
   Soft references; SoftReferenceIndex

.. _soft-references-default-parsers:

Default soft reference parsers
==============================

The :php:`TYPO3\CMS\Core\DataHandling\SoftReference` namespace contains generic
parsers for the most well-known types, which are the default for most TYPO3
installations. This is the list of the pre-registered keys:

.. _soft-references-default-parsers-substitute:

substitute
----------

.. container:: table-row

   softref key
         substitute

   Description
         A full field value targeted for manual substitution (for import
         /export features)



.. _soft-references-default-parsers-notify:

notify
------

.. container:: table-row

   softref key
         notify

   Description
         Just report if a value is found, nothing more.


.. _soft-references-default-parsers-typolink:

typolink
--------

.. container:: table-row

   softref key
         typolink

   Description
         References to page id, record or file in typolink format. The typolink
         soft reference parser can take an additional argument, which can be
         `linklist` (`typolink['linklist']`). In this case the links will be
         separated by commas.


.. _soft-references-default-parsers-typolink-tag:

typolink\_tag
-------------

.. container:: table-row

   softref key
         typolink\_tag

   Description
         Same as typolink, but with an :html:`<a>` tag encapsulating it.

.. _soft-references-default-parsers-ext-fileref:

ext\_fileref
------------

.. container:: table-row

   softref key
         ext\_fileref

   Description
         Relative file reference, prefixed :code:`EXT:[extkey]/` - for finding
         extension dependencies.



.. _soft-references-default-parsers-email:

email
-----

.. container:: table-row

   softref key
         email

   Description
         Email highlight.



.. _soft-references-default-parsers-url:

url
---

.. container:: table-row

   softref key
         url

   Description
         URL highlights (with a scheme).



The default set up is found in
:file:`typo3/sysext/core/Configuration/Services.yaml`:

.. code-block:: yaml

  # Soft Reference Parsers
  TYPO3\CMS\Core\DataHandling\SoftReference\SubstituteSoftReferenceParser:
    tags:
      - name: softreference.parser
        parserKey: substitute

  TYPO3\CMS\Core\DataHandling\SoftReference\NotifySoftReferenceParser:
    tags:
      - name: softreference.parser
        parserKey: notify

  TYPO3\CMS\Core\DataHandling\SoftReference\TypolinkSoftReferenceParser:
    tags:
      - name: softreference.parser
        parserKey: typolink

  TYPO3\CMS\Core\DataHandling\SoftReference\TypolinkTagSoftReferenceParser:
    tags:
      - name: softreference.parser
        parserKey: typolink_tag

  TYPO3\CMS\Core\DataHandling\SoftReference\ExtensionPathSoftReferenceParser:
    tags:
      - name: softreference.parser
        parserKey: ext_fileref

  TYPO3\CMS\Core\DataHandling\SoftReference\EmailSoftReferenceParser:
    tags:
      - name: softreference.parser
        parserKey: email

  TYPO3\CMS\Core\DataHandling\SoftReference\UrlSoftReferenceParser:
    tags:
      - name: softreference.parser
        parserKey: url

Examples
========

For the `tt_content.bodytext` field of type text from the example
above, the configuration looks like this:

.. code-block:: php

   $GLOBALS['TCA']['tt_content']['columns']['bodytext'] =>
      // ...

      'config' => [
         'type' => 'text',
         'softref' => 'typolink_tag,email[subst],url',
         // ...
      ],

      // ...
   ];

This means, the parsers for the softref types `typolink_tag`, `email` and
`url` will all be applied. The email soft reference parser gets the additional
parameter `subst`.

The content could look like this:

.. code-block:: html

   <p><a href="t3://page?uid=96">Congratulations</a></p>
   <p>To read more about <a href="https://example.org/some-cool-feature">this cool feature</a></p>
   <p>Contact: email@example.org</p>

The parsers will return an instance of
:php:`TYPO3\CMS\Core\DataHandling\SoftReference\SoftReferenceParserResult`
containing information about the references contained in the string.
This object has two properties: :php:`$content` and :php:`$elements`.

Property :php:`$content`
------------------------

.. code-block:: html

    <p><a href="{softref:424242}">Congratulations</a></p>
    <p>To read more about <a href="{softref:78910}">this cool feature</a></p>
    <p>Contact: {softref:123456}</p>

This property contains the input content. Links to be substituted have been
replaced by soft reference tokens.

For example: :html:`<p>Contact: {softref:123456}</p>`

Tokens are strings like `{softref:123456}` which are placeholders for values
extracted by a soft reference parser.

For each token there is an entry in :php:`$elements` which has a
:php:`subst` key defining the :php:`tokenID` and the :php:`tokenValue`. See
below.

Property :php:`$elements`
-------------------------

.. code-block:: php

    [
        [
            'matchString' => '<a href="t3://page?uid=96">',
            'error' => 'There is a glitch in the universe, page 42 not found.',
            'subst' => [
                'type' => 'db',
                'tokenID' => '424242',
                'tokenValue' => 't3://page?uid=96',
                'recordRef' => 'pages:96',
            ]
        ],
        [
            'matchString' => '<a href="https://example.org/some-cool-feature">',
            'subst' => [
                'type' => 'string',
                'tokenID' => '78910',
                'tokenValue' => 'https://example.org/some-cool-feature',
            ]
        ],
        [
            'matchString' => 'email@example.org',
            'subst' => [
                'type' => 'string',
                'tokenID' => '123456',
                'tokenValue' => 'test@example.com',
            ]
        ]
    ]

This property is an array of arrays, each with these keys:

*  :php:`matchString`: The value of the match. This is only for informational
   purposes to show, what was found.
*  :php:`error`: An error message can be set here, like "file not found" etc.
*  :php:`subst`: exists on a successful match and defines the token from
   :php:`content`

   *  :php:`tokenID`: The tokenID string corresponding to the token in output
      content, `{softref:[tokenID]}`. This is typically a md5 hash of a string
      uniquely defining the position of the element.
   *  :php:`tokenValue`: The value that the token substitutes in the text.
      If this value is inserted instead of the token, the content
      should match what was inputted originally.
   *  :php:`type`: the type of substitution. :php:`file` is a relative file
      reference, :php:`db` is a database record reference, :php:`string` is a
      manually modified string content (email, external url, phone number)
   *  :php:`relFileName`: (for :php:`file` type): Relative filename.
   *  :php:`recordRef`: (for :php:`db` type): Reference to DB record on the form
      `<table>:<uid>`.

.. index:: Soft references; Custom parsers
.. _soft-references-custom-parsers:

User-defined soft reference parsers
===================================

Soft Reference Parsers can also be user-defined. It is easy to set them up by
registering them in your Services.(yaml|php) file. This will load them
via dependency injection:

.. code-block:: yaml

    VENDOR\Extension\SoftReference\YourSoftReferenceParser:
      tags:
        - name: softreference.parser
          parserKey: your_key

Don't forget to clear the hard caches in the admin tool after modifying DI
configuration.

The soft reference parser class registered there must implement
:php:`TYPO3\CMS\Core\DataHandling\SoftReference\SoftReferenceParserInterface`.
This interface describes the :php:`parse` method, which takes 5 parameters in
total as arguments: :php:`$table`, :php:`$field`, :php:`$uid`, :php:`$content`
and an optional argument :php:`$structurePath`. The return type must be an
instance of
:php:`TYPO3\CMS\Core\DataHandling\SoftReference\SoftReferenceParserResult`.
This model possesses the properties :php:`$content` and :php:`$elements` and has
appropriate getter methods for them. The structure of these properties has been
already described above. This result object should be created by its own factory
method :php:`SoftReferenceParserResult::create`, which expects both
above-mentioned arguments to be provided. If the result is empty,
:php:`SoftReferenceParserResult::createWithoutMatches` should be used instead.
If :php:`$elements` is an empty array, this method will also be used internally.

.. index::
   Soft references; Usage
   BackendUtility; softRefParserObj

Using the soft reference parser
===============================

To get an instance of a soft reference parser, it is recommended to use the
:php:`TYPO3\CMS\Core\DataHandling\SoftReference\SoftReferenceParserFactory`
class. This factory class already holds all registered instances of the parsers.
They can be retrieved with the :php:`getSoftReferenceParser` method. You
have to provide the desired key as the first and only argument.

.. code-block:: php

    $softReferenceParserFactory = GeneralUtility::makeInstance(SoftReferenceParserFactory::class);
    $softReferenceParser = $softReferenceParserFactory->getSoftReferenceParser('your_key');
