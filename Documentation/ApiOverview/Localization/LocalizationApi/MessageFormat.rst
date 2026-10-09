:navigation-title: Arguments in a label

..  include:: /Includes.rst.txt
..  index::
    pair: Localization; Arguments
    pair: Localization; ICU MessageFormat
..  _localization-message-format:

=============================================
Arguments in a label: sprintf and ICU plurals
=============================================

A label can carry values that TYPO3 fills in when it translates. Pass them as
an array to the translation call, after the label reference. **The keys of
that array decide how TYPO3 reads the label**:

*   A list, so keys `0`, `1`, `2`, makes TYPO3 treat the label as a
    `sprintf() <https://www.php.net/manual/en/function.sprintf.php>`_ format
    string, with `%s` and `%d` as the placeholders.
*   An array with names as keys makes TYPO3 read the label as an
    `ICU MessageFormat <https://unicode-org.github.io/icu/userguide/format_parse/messages/>`_
    pattern, with `{name}` as the placeholder.

..  _localization-message-format-icu:

Plurals and selections with ICU MessageFormat
=============================================

..  versionadded:: 14.2
    :changelog: feature-104546-1737580000

ICU MessageFormat picks one wording by a value. Use it where a count or a
gender changes the sentence, because the rules for that differ per language.
A German label needs two forms for a count, a Polish one needs four, and
`sprintf()` cannot express either.

Write the pattern into the label as it stands:

..  literalinclude:: _codesnippets/_locallang_icu.xlf
    :language: xml
    :caption: EXT:my_extension/Resources/Private/Language/locallang.xlf

`{count, plural, …}`
    Chooses by the plural category of the value: `one`, `other`, and the
    categories of the current language. `=0` matches exactly zero, which gives
    a sentence like "no items" its own wording. A `#` inside a branch prints
    the number.

`{gender, select, …}`
    Chooses by an exact value. `other` catches the rest.

`{name}`
    Prints the value.

Then pass the values under their names:

..  code-block:: php
    :caption: EXT:my_extension/Classes/MyClass.php (excerpt)

    $this->getTranslator()->label(
        'my_extension.messages:file_count',
        ['count' => 5],
    );

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/MyTemplate.fluid.html

    <f:translate key="my_extension.messages:file_count"
        arguments="{count: files}" />

TYPO3 reads the plural rules of the current locale, and falls back to `en_US`
where it knows no locale. So the same label gives "5 files" in English and
"5 Dateien" in German, each with the forms of that language.

Where a pattern is invalid, TYPO3 returns the label unchanged, with the braces
still in it. A sentence of curly braces on a page is the sign to look for a
typo in the pattern.

..  _localization-message-format-sprintf:

Positional values with `sprintf()`
==================================

A list of values keeps the behavior that TYPO3 always had: the label is a
`sprintf()` format string.

..  code-block:: php
    :caption: EXT:my_extension/Classes/MyClass.php (excerpt)

    $this->getTranslator()->label(
        'my_extension.messages:greeting_sprintf',
        ['World'],
    );

TYPO3 uses `vsprintf()` here, which reports a count of values that does not
match the count of placeholders. A label with one `%s` and no value therefore
raises an error instead of printing an empty string.

Do not mix the two. A label written for `sprintf()` keeps its `%s` untouched
when the call passes named values. An ICU pattern reaches the output with its
braces when the call passes a list.
