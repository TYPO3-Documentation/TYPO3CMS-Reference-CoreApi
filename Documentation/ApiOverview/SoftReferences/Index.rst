..  include:: /Includes.rst.txt
..  index:: Soft references
..  _soft-references:

===============
Soft references
===============

Soft references are references to database elements, files, email addresses,
URLs, etc. which are found inside of text fields.

For example, the :sql:`tt_content.bodytext` database field can contain soft
references to pages, content elements and files. The page reference looks like
this:

..  code-block:: html

    <a href="t3://page?uid=1">link to page 1</a>

In contrast to this, the field :sql:`pages.shortcut` contains the page ID of a
shortcut. This is a reference, but not a *soft* reference.

The soft reference parsers are used by the system to find these references and
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

..  index::
    Soft references; Default parsers
    Soft references; SoftReferenceIndex

..  _soft-references-default-parsers:

Default soft reference parsers
==============================

The :php:`\TYPO3\CMS\Core\DataHandling\SoftReference` namespace contains generic
parsers for the most well-known types, which are the default for most TYPO3
installations. This is the list of the pre-registered keys:

..  _soft-references-default-parsers-substitute:

substitute
    A full field value targeted for manual substitution (for import/export
    features).

..  _soft-references-default-parsers-typolink:

typolink
    References to page ID, record or file in typolink format. The typolink
    soft reference parser can take an additional argument, which can be
    `linklist` (`typolink['linklist']`). In this case the links will be
    separated by commas.

..  _soft-references-default-parsers-typolink-tag:

typolink\_tag
    Same as :ref:`typolink <soft-references-default-parsers-typolink>`, but with
    an :html:`<a>` tag encapsulating it.

..  _soft-references-default-parsers-ext-fileref:

ext\_fileref
    Relative file reference, prefixed :code:`EXT:[extkey]/` - for finding
    extension dependencies.

..  _soft-references-default-parsers-email:

email
    Email highlight.

..  _soft-references-default-parsers-url:

url
    URL highlights (with a scheme).

The default setup is found in :t3src:`core/Configuration/Services.yaml`:

..  literalinclude:: _Services.yaml
    :language: yaml
    :caption: Excerpt from EXT:core/Configuration/Services.yaml

..  _soft-references-examples:

Examples
========

For the :sql:`tt_content.bodytext` field of type text from the example
above, the configuration looks like this:

..  literalinclude:: _tt_content_bodytext.php
    :language: php
    :caption: Excerpt from EXT:frontend/Configuration/TCA/tt_content.php

This means, the parsers for the soft reference types `typolink_tag`, `email` and
`url` will all be applied. The email soft reference parser receives the
additional parameter `subst`.

The content could look like this:

..  code-block:: html

    <p><a href="t3://page?uid=96">Congratulations</a></p>
    <p>To read more about <a href="https://example.org/some-cool-feature">this cool feature</a></p>
    <p>Contact: email@example.org</p>

The parsers will return an instance of
:php:`\TYPO3\CMS\Core\DataHandling\SoftReference\SoftReferenceParserResult`
containing information about the references contained in the string.
This object has two properties: :php:`$content` and :php:`$elements`.

Property :php:`$content`
------------------------

..  code-block:: html

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

..  code-block:: php

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

*   :php:`matchString`: The value of the match. This is only for informational
    purposes to show, what was found.
*   :php:`error`: An error message can be set here, like "file not found" etc.
*   :php:`subst`: exists on a successful match and defines the token from
    :php:`content`

    *   :php:`tokenID`: The tokenID string corresponding to the token in output
        content, `{softref:[tokenID]}`. This is typically a md5 hash of a string
        uniquely defining the position of the element.
    *   :php:`tokenValue`: The value that the token substitutes in the text.
        If this value is inserted instead of the token, the content
        should match what was inputted originally.
    *   :php:`type`: the type of substitution. :php:`file` is a relative file
        reference, :php:`db` is a database record reference, :php:`string` is a
        manually modified string content (email, external url, phone number)
    *   :php:`relFileName`: (for :php:`file` type): Relative filename.
    *   :php:`recordRef`: (for :php:`db` type): Reference to DB record on the form
        `<table>:<uid>`.

..  index:: Soft references; Custom parsers
..  _soft-references-custom-parsers:

User-defined soft reference parsers
===================================

Soft reference parsers can be user-defined. They are set up by
registering them in your :file:`Services.yaml` file. This will load them
via :ref:`dependency injection <Dependency-Injection>`:

..  literalinclude:: _YourSoftReferenceParser.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions <dependency-injection-in-extensions>`.

Do not forget to clear the hard caches in :guilabel:`System > Maintenance`
or via the :bash:`cache:flush` :ref:`CLI <symfony-console-commands>` command
after modifying the :abbr:`DI (Dependency Injection)` configuration.

The soft reference parser class registered there must implement
:t3src:`core/DataHandling/SoftReference/SoftReferenceParserInterface.php`.
This interface describes the :php:`parse` method, which takes 5 parameters in
total as arguments:

*   :php:`$table`
*   :php:`$field`
*   :php:`$uid`
*   :php:`$content`
*   :php:`$structurePath` (optional)

The return type must be an instance of
:t3src:`core/DataHandling/SoftReference/SoftReferenceParserResult.php`.
This model possesses the properties :php:`$content` and :php:`$elements` and has
appropriate getter methods for them. The structure of these properties has been
described in the :ref:`examples <soft-references-examples>` section. This
result object should be created by its own factory method
:php:`SoftReferenceParserResult::create()`, which expects both
above-mentioned arguments to be provided. If the result is empty,
:php:`SoftReferenceParserResult::createWithoutMatches()` should be used instead.
If :php:`$elements` is an empty array, this method will also be used internally.

..  index::
    Soft references; Usage
    BackendUtility; softRefParserObj

Using the soft reference parser
===============================

To get an instance of a soft reference parser, it is recommended to use the
:php:`\TYPO3\CMS\Core\DataHandling\SoftReference\SoftReferenceParserFactory`
class. This factory class already holds all registered instances of the parsers.
They can be retrieved with the :php:`getSoftReferenceParser()` method. You
have to provide the desired key as the first and only argument.

..  literalinclude:: _MyController.php
    :language: php
    :caption: EXT:my_extension/Classes/MyController.php
