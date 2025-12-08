:navigation-title: Label references

..  include:: /Includes.rst.txt
..  _label-reference:

==============================
Label references / LLL strings
==============================

..  versionadded:: 14.0
    Translation domain mapping has been introduced as an additional, shorter
    syntax for label references. It complements the existing file-based
    `LLL:` notation.

TYPO3 supports two equivalent formats for referencing translatable labels:

*   the **legacy file-based syntax** starting with `LLL:`, and
*   the **new translation domain-based syntax** introduced in TYPO3 v14.

Both formats resolve to the same translation entries and can be used
interchangeably.

Examples:

..  code-block:: php

    // Legacy file-based syntax
    $languageService->sL('LLL:EXT:my_extension/Resources/Private/Language/locallang_forms.xlf:submit');

    // New domain-based syntax (TYPO3 v14+)
    $languageService->sL('my_blog.frontend.forms:submit');

Label references are used throughout TYPO3 — in PHP, TypoScript, Fluid templates,
and configuration files — to access localized strings that are translated into
the current language at runtime.

If a different language is set or a language file is
`overridden <https://docs.typo3.org/permalink/t3coreapi:xliff-translating-custom>`_,
the path is automatically adjusted.

..  contents:: Table of contents

..  _label-reference-domain:

Translation domain mapping for label reference
==============================================

Translation domains are an additional syntax for referencing language labels
in TYPO3. They provide a domain-based notation that complements the existing
file-based `LLL:` syntax.

The domain syntax has the form:

..  code-block::php

    package[.subdomain...].resource

    For example:

    my_extension.messages:comment_saved

package
    refers to the extension key (for example, `backend` for `EXT:backend`).
subdomain
    is optional and can be used to group related labels.
resource
    usually corresponds to a translation file, such as `messages`.

The domain notation removes explicit file paths and extensions, improving
readability while remaining fully compatible with existing `LLL:EXT:` references.

Example:

..  code-block:: html

    // Domain-based reference
    <f:translate
        key="my_extension.comment:domain_model.title"
    />

    // Equivalent file-based reference
    <f:translate
        key="LLL:EXT:my_extension/Resources/Private/Language/locallang_comment.xlf:domain_model.title"
    />

The legacy file-based syntax will continue to be supported and is not deprecated.
Both formats can be used interchangeably.

..  _translation-domain-format:

Translation domain format
-------------------------

The domain format defines two parts: the *package part* (extension key) and the
*resource part*, separated by a dot.

The resource part leaves out previous historical
names, especially `locallang.xlf` and the `locallang_` prefix.

The resource identifier appears before the colon in the resource part (below `comment`).

.. code-block:: php
   :caption: Example usage of "package.resource:identifier"

    $languageService->sL('my_extension.comment:domain_model.title');

..  _translation-domain-resolution:

Translation domain resolution
-----------------------------

Translation domains are resolved deterministically and mapped to existing
language files within an extension. This section describes how the mapping
and name generation work internally.

The command :bash:`vendor/bin/typo3 language:domain:list` lists all available
translation domains with their translations and label counts:

..  code-block:: bash

    # List domains in active extensions
    vendor/bin/typo3 language:domain:list

    # Filter by extension
    vendor/bin/typo3 language:domain:list --extension=backend

.. _translation-domain-mapping:

Deterministic file-based translation domain mapping
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

TYPO3 automatically resolves translation domains to language files
inside each extension. This allows you to use short, domain-based references
without worrying about exact file names or paths.

Language files are discovered in the :directory:`Resources/Private/Language/`
directory of each installed extension. The system builds a mapping between file names
and domain identifiers, ensuring that each domain corresponds to an existing
file.

If multiple files can map to the same domain (for example,
:file:`locallang_db.xlf` and :file:`db.xlf` in the same directory),
the simplified name takes precedence, and the prefixed variant is ignored.

All mappings are cached internally for performance.

Compared to traditional file-based lookups, the domain mapping approach
reduces file system operations. Extension label files are
discovered once during initialization, and their mapping is reused from
cache for subsequent lookups.

.. _translation-domain-rules:

Domain Generation Rules
-----------------------

Domain names are derived from file paths using the following transformation
rules:

1.  The base path :directory:`Resources/Private/Language/` is omitted.

2.  Standard filename patterns:

    *   :file:`locallang.xlf` → `.messages`
    *   :file:`locallang_module.xlf` → `.module`
    *   :file:`locallang_wizard.xlf` → `.wizard`

3.  Subdirectories are converted to dot notation:

    *   :file:`Backend/locallang_dashboard.xlf` → `.backend.dashboard`
    *   :file:`Frontend/locallang_forms.xlf` → `.frontend.forms`

4.  Site Set labels receive the `.sets` prefix:

    *   :file:`Configuration/Sets/Blog/labels.xlf` → `.sets.blog`

5.  Case conversion:

    *   UpperCamelCase → snake_case (`UserProfile` → `user_profile`)
    *   snake_case → preserved (`user_profile` → `user_profile`)

6.  Locale prefixes do not affect the resource identifier used for resolving.
    They are evaluated later for locale-specific translations:

    *   `de.locallang.xlf` → `messages`
    *   `de-AT.wizard.xlf` → `wizard`

..  rubric:: Examples

The following examples show how typical language file paths map to translation
domains in custom extensions:

*   :file:`EXT:my_site/Resources/Private/Language/locallang.xlf`
    → `my_site.messages`

*   :file:`EXT:my_site/Resources/Private/Language/locallang_module.xlf`
    → `my_site.module`

*   :file:`EXT:my_blog/Resources/Private/Language/Backend/locallang_dashboard.xlf`
    → `my_blog.backend.dashboard`

*   :file:`EXT:my_blog/Resources/Private/Language/Frontend/locallang_forms.xlf`
    → `my_blog.frontend.forms`

*   :file:`EXT:news_comments/Configuration/Sets/Blog/labels.xlf`
    → `news_comments.sets.blog`

..  _label-reference-legacy:

Legacy file-based lLabel references
===================================

The legacy label reference format uses the `LLL:` prefix and an explicit
path to an XLIFF translation file within an extension.

The general format is:

..  code-block:: text

    LLL:EXT:<extension_key>/<path_to_xliff_file>:<identifier>

Example:

..  code-block:: text

    LLL:EXT:my_extension/Resources/Private/Language/locallang_db.xlf:mytable.myfield

This syntax remains fully supported and can be mixed with
translation domain-based references as needed.

..  _label-reference-storage:

File paths in legacy label references
-------------------------------------

Localized labels are stored in files with
`XLIFF format <https://docs.typo3.org/permalink/t3coreapi:xliff>`_.
Most XLIFF files are located in
:folder:`EXT:my_extension/Resources/Private/Language/` and its subfolders.

In some cases the locations are different:

*   **Site sets** – Localization files for site set definitions are stored in
    the site set folder, for example:
    :file:`EXT:my_extension/Configuration/Sets/MySet/labels.xlf`
*   **Content blocks** – Third-party extensions can define their own structure.
    For example, the extension
    :composer:`friendsoftypo3/content-blocks` stores labels alongside the
    content block definitions:
    :file:`EXT:my_extension/Configuration/Sets/MySet/labels.xlf`

..  _label-reference-resolve:

Resolving localized labels
==========================

In many cases, such as the
`label of a TCA field <https://docs.typo3.org/permalink/t3tca:confval-columns-label>`_,
you can use a label reference, and TYPO3 will resolve it.

If label references are not resolved, you can do it manually:

..  _label-reference-resolve-fluid:

Fluid: Using the f:translate ViewHelper
---------------------------------------

Use the :ref:`f:translate <t3viewhelper:typo3-fluid-translate>` ViewHelper to
insert translated strings in Fluid templates.

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

    <f:translate key="my_extension.your_file.xlf:yourKey" />
    <!-- or as inline Fluid: -->
    {f:translate(key: 'my_extension.your_file.xlf:yourKey')}

See also: `The translation ViewHelper f:translate
<https://docs.typo3.org/permalink/t3coreapi:f-translate>`_

..  _label-reference-resolve-typoscript:

TypoScript: Using the getText property
--------------------------------------

The :ref:`getText property LLL <t3tsref:data-type-gettext-lll>` can be used to
fetch translations from a language file and render them in the current language.

..  code-block:: typoscript
    :caption: EXT:site_package/Configuration/TypoScript/setup.typoscript

    lib.blogListTitle = TEXT
    lib.blogListTitle {
        data = LLL : my_extension.your_file.xlf:yourKey
    }

Make sure to leave spaces around the colon following `LLL` (as required by
general getText syntax).

See also:
`Output localized strings with TypoScript
<https://docs.typo3.org/permalink/t3coreapi:extension-localization-typoscript-gettext>`_

..  _label-reference-resolve-php:

PHP: Using the LanguageService
------------------------------

In PHP localized labels can be retrieved via the
:php-short:`\TYPO3\CMS\Core\Localization\LanguageService`, which can be created
using the :php-short:`\TYPO3\CMS\Core\Localization\LanguageServiceFactory`.

The recommended way to determine the correct
:php-short:`LanguageService` instance depends on context:

*   **Frontend:** use the language in the current request object
    (:php-short:`Psr\Http\Message\ServerRequestInterface`) or the default site
    language.
*   **Backend:** use the language of the logged-in backend user.
*   **CLI:** determine the language programmatically depending on your use case
    (for example, when sending emails via scheduler tasks).

For more details, see
`Localization in PHP <https://docs.typo3.org/permalink/t3coreapi:extension-localization-php>`_.

Once you have the correct LanguageService instance, you can resolve labels as follows:

..  code-block:: php

    use TYPO3\CMS\Core\Localization\LanguageService;

    private function translateSomething(
        LanguageService $languageService,
        string $labelReference
    ): string {
        return $languageService->sL($labelReference);
    }

..  _label-reference-deprecated:

Replacing deprecated language labels
====================================

..  deprecated:: 14.0
    With TYPO3 v14 a number of labels and localization files have been deprecated.

The first time after deleting a cache that a label is used an entry such
as the following is written to the deprecation log.
(See `Enabling the deprecation log <https://docs.typo3.org/permalink/t3coreapi:deprecation-enable-errors>`_).

The Extension Scanner does not detect the usage of deprecated localization
labels. Developers must rely on runtime deprecation logs to identify these
occurrences.

Deprecated labels are marked with attribute `x-unused-since="14.0"` in the XLIFF
1.2 localization file and with `subState="deprecated"` in XLIFF 2.0. They will
be removed with the next major TYPO3 version.

It is possible to use these tags to deprecate labels in third party extensions
as well.

To ease migration for Extension developers and projects the development
command :bash:`vendor/bin/typo3 language:domain:search` can be used to search
for specific label contents. :composer:`typo3/cms-lowlevel` needs to be
installed.

For example if you used the now deprecated label reference
`LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime`

You can use the following command:

..  code-block:: bash

    vendor/bin/typo3 language:domain:search --search starttime

    core.db.general file EXT:core/Resources/Private/Language/db/general.xlf
    =======================================================================

    +-----------------+--------------------+
    | Label Reference | Label Content (en) |
    +-----------------+--------------------+
    | starttime       | Publish Date       |
    +-----------------+--------------------+


To search for any label reference key or content containing "starttime". If
the label content fits your purpose you can switch your label reference to the
new location:

..  code-block:: diff
    :caption: Fluid Template (diff)

    - <f:translate id="LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime" />
    + <f:translate id="starttime" domain="core.db.general" />

..  code-block:: diff
    :caption: TCA definition (diff)

     'my_special_starttime' => [
    -    'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
    +    'label' => 'core.db.general:starttime',
         'config' => [
             'type' => 'datetime',
             'default' => 0,
         ],
     ],

..  code-block:: diff
    :caption: PHP controller or service (diff)

    - $languageService->sL('LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime')
    + $languageService->sL('core.db.general:starttime')

If you can find no suitable label for your use case consider moving the label
to your own extensions XLIFF localization files.
