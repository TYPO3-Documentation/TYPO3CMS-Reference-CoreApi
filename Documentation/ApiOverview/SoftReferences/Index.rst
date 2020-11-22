.. include:: /Includes.rst.txt


.. _soft-references:

===============
Soft References
===============

"Soft References" are references to database elements, files, email
addresses, URLs etc. which are found inside text fields. The
:code:`<link[page_id]>` tag found in bodytext fields is an example of this.

The Soft Reference parsers are used by the system to find these
references and process them accordingly in import/export actions and
copy operations. Also, the soft references are used by integrity
checking functions.


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
         References to page id or file, possibly with anchor/target, possibly
         comma-separated list.



.. _soft-references-default-parsers-typolink-tag:

typolink\_tag
-------------

.. container:: table-row

   softref key
         typolink\_tag

   Description
         As typolink, but searching for a :code:`<link>` tag encapsulating it.



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


.. _soft-references-custom-parsers:

User-defined Soft Reference Parsers
===================================

Soft References can also be user-defined. It is easy to set them up by
simply adding new keys in
:code:`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['GLOBAL']['softRefParser']`. Use key
names based on the extension you put it in, e.g. :code:`tx_myextensionkey`.

The class containing the soft reference parser must have a function
named :code:`findRef`. Please refer to class
:php:`TYPO3\CMS\Core\Database\SoftReferenceIndex`
for API usage and expected return values.

Using the soft reference parser
===============================

To use the soft reference parser in your own extensions, use
:php:`\TYPO3\CMS\Backend\Utility\BackendUtility::softRefParserObj` to get
the parser for a specific soft reference type. For an example, take a look at
:php:`\TYPO3\CMS\Linkvalidator\LinkAnalyzer::analyzeRecord`.
