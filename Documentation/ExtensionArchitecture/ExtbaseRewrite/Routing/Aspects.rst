:navigation-title: Aspects

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Routing aspects
..  _extbase-routing-aspects:

===================================================
Routing aspects: mapping route placeholders to URLs
===================================================

A route placeholder like :samp:`{conference_slug}` is just a named capture group —
it matches any string segment in the URL. An aspect is what gives that
placeholder meaning: it translates between the raw internal value (typically a
UID) used by Extbase and the human-readable segment that appears in the URL.

Aspects are defined at enhancer level under the :yaml:`aspects` key, keyed by the
placeholder name they apply to.

..  seealso::

    *   `Routing aspects — full reference <https://docs.typo3.org/permalink/t3coreapi:routing-advanced-routing-configuration-aspects>`_ —
        all aspect types including ``LocaleModifier`` and custom mapper implementations.


..  _extbase-routing-aspects-persisted-alias:

PersistedAliasMapper
====================

The most common aspect for Extbase plugins, implemented by
:php:`\TYPO3\CMS\Core\Routing\Aspect\PersistedAliasMapper`. It looks up a
database record by its slug field to resolve a URL segment to a UID, and vice
versa when generating a URL.

..  literalinclude:: _snippets/_aspects-persisted-alias.yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

:yaml:`tableName`
    The database table that holds the records — typically the Extbase domain
    model table (:samp:`tx_{extension}_domain_model_{name}`).

:yaml:`routeFieldName`
    The field whose value is used as the URL segment. This should be a TCA
    :ref:`type slug <t3tca:columns-slug>` field so that values are guaranteed
    to be unique and URL-safe. Using a plain title field is possible but risky:
    special characters are not sanitised automatically, and duplicates cause
    resolution failures.

:yaml:`routeValuePrefix`
    Slug fields in TCA store values with a leading :samp:`/` (for example
    :samp:`/typo3camp-2025`). Set :yaml:`routeValuePrefix: '/'` to strip that prefix
    from the URL segment. Omit it for non-slug fields.

When TYPO3 receives :samp:`/conferences/typo3camp-2025`, the mapper looks up the
record with :samp:`slug = '/typo3camp-2025'` in the table and passes its UID to
the action as the :yaml:`conference` argument. When generating a URL for a
conference with UID 42, it reads the slug field and inserts the value into the
URL — no UID ever appears in the address bar.


..  _extbase-routing-aspects-persisted-pattern:

PersistedPatternMapper
======================

Implemented by :php:`\TYPO3\CMS\Core\Routing\Aspect\PersistedPatternMapper`,
this combines multiple database fields into one URL segment. Useful when no slug
field exists and adding one is not an option — for example when extending a
third-party table.

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

    aspects:
      conference_slug:
        type: PersistedPatternMapper
        tableName: tx_myextension_domain_model_conference
        routeFieldPattern: '^(?P<title>.+)-(?P<uid>\d+)$'
        routeFieldResult: '{title}-{uid}'

:yaml:`routeFieldPattern`
    A regular expression with named capture groups that matches the stored
    field value.

:yaml:`routeFieldResult`
    The template for the URL segment, using the named groups from
    :yaml:`routeFieldPattern`. Appending the UID (:samp:`{title}-{uid}`) guarantees
    uniqueness even when titles are not unique.

The :php-short:`\TYPO3\CMS\Core\Routing\Aspect\PersistedAliasMapper` is preferred
whenever a slug field is available — it is simpler and its output is cleaner.
Use :php-short:`\TYPO3\CMS\Core\Routing\Aspect\PersistedPatternMapper` when
you need to construct the URL segment from multiple fields or when upgrading
from a realurl-era configuration that used title-plus-UID URLs.

..  seealso::

    `PersistedPatternMapper reference <https://docs.typo3.org/permalink/t3coreapi:routing-aspect-PersistedPatternMapper>`_


..  _extbase-routing-aspects-static-value:

StaticValueMapper
=================

Implemented by :php:`\TYPO3\CMS\Core\Routing\Aspect\StaticValueMapper`, this maps
a fixed set of values between their internal representation and a human-readable
URL segment. Suitable for arguments that can only take a known list of values —
status flags, type identifiers, named steps in a wizard.

..  literalinclude:: _snippets/_aspects-static-value.yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

The :yaml:`map` keys are the URL segments; the values are what Extbase receives
as the argument. A request to :samp:`/conferences/status/upcoming` passes :yaml:`1`
to the action. A URL generated for status :yaml:`3` produces
:samp:`/conferences/status/past`.

Because the full set of valid values is known, TYPO3 treats the parameter as
static and omits ``cHash`` from the generated URL.

For multi-language sites, add a :yaml:`localeMap` to vary the URL segments per
language without changing the internal values:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

    aspects:
      status:
        type: StaticValueMapper
        map:
          upcoming: 1
          running: 2
          past: 3
        localeMap:
          - locale: 'de_DE.*'
            map:
              bevorstehend: 1
              laufend: 2
              vergangen: 3

..  seealso::

    `StaticValueMapper reference <https://docs.typo3.org/permalink/t3coreapi:routing-aspect-StaticValueMapper>`_


..  _extbase-routing-aspects-static-range:

StaticRangeMapper
=================

Implemented by :php:`\TYPO3\CMS\Core\Routing\Aspect\StaticRangeMapper`, this
declares that a placeholder accepts an integer within a fixed range. The
primary use case is pagination. Unlike a bare ``\d+`` requirement, a
:php-short:`\TYPO3\CMS\Core\Routing\Aspect\StaticRangeMapper` marks the parameter
as static, which eliminates ``cHash`` from paginated URLs.

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

    aspects:
      page:
        type: StaticRangeMapper
        start: '1'
        end: '100'

Set :yaml:`end` to the maximum sensible value for your use case. The example uses
:yaml:`100` pages; TYPO3 enforces a hard upper limit of 1000. Requests with a value
outside the configured range do not match the route — TYPO3 returns a 404
rather than silently passing through an out-of-range value.

..  seealso::

    `StaticRangeMapper reference <https://docs.typo3.org/permalink/t3coreapi:routing-aspect-StaticRangeMapper>`_


..  _extbase-routing-aspects-fallback:

Handling deleted or hidden records
==================================

When a :php-short:`\TYPO3\CMS\Core\Routing\Aspect\PersistedAliasMapper` cannot
resolve a slug — because the record has been deleted, hidden, or its slug
changed — TYPO3 returns a 404 by default. The :yaml:`fallbackValue` property
changes this behaviour.

..  literalinclude:: _snippets/_aspects-fallback.yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

:yaml:`fallbackValue: null` removes the argument from the route result entirely.
The action receives :php:`null` for that argument instead of a 404. Declare the
action parameter as nullable and handle it explicitly — for example by
redirecting to the list with a flash message:

..  literalinclude:: _snippets/_ConferenceController-fallback.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

A string :yaml:`fallbackValue` passes that string as the argument value instead,
which lets you show a default record rather than an error page.

..  seealso::

    `Aspect fallback value handling <https://docs.typo3.org/permalink/t3coreapi:routing-aspect-fallback-handling>`_


..  _extbase-routing-aspects-precedence:

Aspects take precedence over requirements
=========================================

If a placeholder has both a
:ref:`requirements <extbase-routing-routes-requirements>` entry and an
:yaml:`aspects` entry, the aspect wins — the :yaml:`requirements` regex is
ignored for that placeholder.
The aspect defines all valid values implicitly, so an additional regex
constraint would be redundant and is silently discarded.

With aspects configured, the next step is generating URLs from controller
actions and Fluid templates — see :ref:`extbase-routing-uri-builder`.
