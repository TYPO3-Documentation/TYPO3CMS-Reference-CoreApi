.. include:: /Includes.rst.txt
.. index:: Soft references
.. _soft-references:

===============
Soft references
===============

"Soft References" are references to database elements, files, email
addresses, URLs etc. which are found inside text fields.

For example, `tt_content.bodytext` can contain soft references to pages,
to content elements, to files etc. The page reference can look
like this:

.. code-block:: html

   <a href="t3://page?uid=1">link to page 1</a>

In contrast to this, the field `pages.shortcut` contains the page id
of a shortcut. This is a reference, but not a *soft* reference.

The Soft Reference parsers are used by the system to find these
references and process them accordingly in import/export actions and
copy operations. Also, the soft references are used by integrity
checking functions. For example, when you try to delete a page,
TYPO3 will warn you if there are incoming page links to this page.

All references, soft and ordinary ones, are
written to the reference index (table `sys_refindex`).

Which soft reference parsers will be used can be defined in the TCA
field :ref:`softref <t3tca:columns-text-properties-softref>` which is
available for TCA column types :ref:`text <t3tca:columns-text>`
and :ref:`input <t3tca:columns-input>`.


.. index::
   Soft references; Default parsers
   Soft references; SoftReferenceIndex

.. _soft-references-default-parsers:

Default soft reference parsers
==============================

The :php:`TYPO3\CMS\Core\Database\SoftReferenceIndex`
class contains generic parsers for the most well-known types
which are default for most TYPO3 installations. This
is the list of the possible keys:


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
         References to page id, record, file in typolink format. The typolink
         soft reference parser can take an additional argument which can be
         `linklist` (`typolink['linklist']`). In this case the links will be
         separated by commas.


.. _soft-references-default-parsers-typolink-tag:

typolink\_tag
-------------

.. container:: table-row

   softref key
         typolink\_tag

   Description
         As typolink, with an :code:`<a>` tag encapsulating it.

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



The default set up is found in :file:`typo3/sysext/core/Configuration/DefaultConfiguration.php`:

.. code-block:: php

    'SC_OPTIONS' => [
        'GLOBAL' => [
            'softRefParser' => [
                'substitute' => \TYPO3\CMS\Core\Database\SoftReferenceIndex::class,
                'notify' => \TYPO3\CMS\Core\Database\SoftReferenceIndex::class,
                'typolink' => \TYPO3\CMS\Core\Database\SoftReferenceIndex::class,
                'typolink_tag' => \TYPO3\CMS\Core\Database\SoftReferenceIndex::class,
                'ext_fileref' => \TYPO3\CMS\Core\Database\SoftReferenceIndex::class,
                'email' => \TYPO3\CMS\Core\Database\SoftReferenceIndex::class,
                'url' => \TYPO3\CMS\Core\Database\SoftReferenceIndex::class,
            ],
        ],
        // ...
    ],

Examples
========

For the `tt_content.bodytext` field of type text from the example
above, the configuration looks like this::

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
parameter 'subst'.

The content could look like this:

.. code-block:: html

   <p><a href="t3://page?uid=96">Congratulations</a></p>
   <p>To read more about <a href="http://example.org/some-cool-feature">this cool feature</a></p>
   <p>Contact: email@example.org</p>

The parsers will return an array containing information about the references
contained in the string::

   [
       'content' => '
          <p><a href="{424242}">Congratulations</a></p>
          <p>To read more about <a href="{softref:78910}">this cool feature</a></p>
          <p>Contact: {softref:123456}</p>
       ',
       'elements' => [
           [
               'matchString' => '<a href="t3://page?uid=96">',
               'error' => 'There is a glitch in the universe, page 42 not found.',
               'subst' => [
                   'type' => 'db','424242',
                   'tokenValue' => 't3://page?uid=96',
                   'recordRef' => 'pages:96',
               ]
           ],
           [
               'matchString' => '<a href="http://example.org/some-cool-feature">',
               'subst' => [
                   'type' => 'string',
                   'tokenID' => '78910',
                   'tokenValue' => 'http://example.org/some-cool-feature',
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
       ],
   ],


The result array
----------------

In most cases the result array contains two keys: :php:`content` and :php:`elements`.


Key :php:`content`
~~~~~~~~~~~~~~~~~~

This part contains the input content. Links to be substitutet have been
replaced by soft reference tokens.

For example: :html:' <p>Contact: {softref:123456}</p>'

Tokens are strings like {softref:123456} which are placeholders for a values
extracted by a Soft reference parser.

For each token there in an entry in the :php:`elements` key which has a
:php:`subst` key defining the tokenID and the tokenValue. See below.


Key :php:`elements`
~~~~~~~~~~~~~~~~~~~

This part is an array of arrays, each with these keys:

* :php:`matchString`: The value of the match. This is only for informational
   purposes to show what was found.
* :php:`error`: An error message can be set here, like "file not found" etc.
* :php:`subst`: If this array is found there MUST be a token in the output
   content as well!

   * :php:`tokenID`: The tokenID string corresponding to the token in output
      content, `{softref:[tokenID]}`. This is typically an md5 hash of a string
      defining uniquely the position of the element.
   * :php:`tokenValue`: The value that the token substitutes in the text.
      Basically, if this value is inserted instead of the token the content
      should match what was inputted originally.
   * :php:`type`: the type of substitution. `file` is a relative file reference,
      `db` is a database record reference, `string` is a manually
      modified string content (email, external url, phone number)
   * :php:`relFileName`: (for `file` type): Relative filename.
   * :php:`recordRef`: (for `db` type): Reference to DB record on the form
      [table]:[uid].


.. index:: Soft references; Custom parsers
.. _soft-references-custom-parsers:

User-defined soft reference parsers
===================================

Soft References can also be user-defined. It is easy to set them up by
simply adding new keys in
:code:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['GLOBAL']['softRefParser']`. Use key
names based on the extension you put it in, e.g. :code:`tx_myextensionkey`.

The class containing the soft reference parser must have a function
named :code:`findRef`. Please refer to class
:php:`TYPO3\CMS\Core\Database\SoftReferenceIndex`
for API usage and expected return values.


.. index::
   Soft references; Usage
   BackendUtility; softRefParserObj

Using the soft reference parser
===============================

To use the soft reference parser in your own extensions, use
:php:`\TYPO3\CMS\Backend\Utility\BackendUtility::softRefParserObj` to get
the parser for a specific soft reference type. For an example, take a look at
:php:`\TYPO3\CMS\Linkvalidator\LinkAnalyzer::analyzeRecord`.
