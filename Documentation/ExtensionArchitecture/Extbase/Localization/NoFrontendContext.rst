:navigation-title: Without frontend context

..  include:: /Includes.rst.txt
..  index:: Extbase; Localization
..  _extbase-localisation-no-frontend:

=========================================
Localization outside the frontend context
=========================================

When rendering a typical frontend request, TYPO3 resolves the active site and
language aspect before any Extbase code executes. However, backend modules, CLI
commands, and custom middleware operate outside this standard pipeline and
frequently lack a language context. This guide outlines how localization behaves
in non-frontend environments and how to explicitly manage languages in your
Extbase code.

..  note::
    For a broader look at establishing execution environments outside the
    frontend (such as configuring storage PIDs), see :ref:`extbase-no-frontend`.

..  _extbase-localisation-no-frontend-default:

Understanding the default behavior
==================================

If no language context is explicitly provided, Extbase queries the Context API
and falls back to a default fallback state:

*   **Fallback Target:** An initialized
    :php-short:`\TYPO3\CMS\Core\Context\LanguageAspect` with an ID of 0.
*   **Overlay Mode:** OVERLAYS_ON_WITH_FLOATING.

**The Impact:** Your backend modules or CLI commands will behave as if they are
executing against a site configured with `fallbackType: strict` in the default
language. **Only default language records will be returned.**

While acceptable for simple tasks, this default behavior breaks features like
CLI commands that send localized email alerts, generate localized reports, or
export multi-language datasets.

..  _extbase-localisation-no-frontend-explicit:

Setting the language explicitly
===============================

To query records in a specific locale, you must manually pass the language
aspect to your query settings.

The following CLI command demonstrates how to fetch a frontend user's preferred
language from their record, resolve it against the site configuration, and query
the repository using that specific context. The command sends a reminder about
upcoming conferences to all frontend users, in the language stored on their user
record.

..  literalinclude:: _snippets/_ConferenceReminderCommand.php
    :caption: EXT:my_extension/Classes/Command/ConferenceReminderCommand.php
    :emphasize-lines: 39, 43, 45-46

Because this method relies on :php:`findAllForLanguageAspect()`, the exact same
repository logic remains reusable across both the frontend (where the aspect is
provided natively) and CLI commands (where you supply it manually). See also
:ref:`extbase-localisation-query-settings`.

..  tip::
    **UI Text vs. Database Records:** Query settings only affect data records.
    If you need to translate email subject lines or template text strings
    (labels) in your command, use the Core Language Service instead. See
    :ref:`extension-localization-php`.

..  _extbase-localisation-no-frontend-backend:

Backend modules
===============

How you manage localization in backend modules depends entirely on whether your
module interacts with the page tree.

..  _extbase-localisation-no-frontend-backend-without-page:

Global modules (no page tree)
-----------------------------
Modules that manage global records independently of specific pages (for example,
global settings, system reports, or job queues) do not have a page and so do not
have a site configuration to take a `fallbackType` from. They default to the
primary language aspect. You must explicitly specify target languages in your
query settings.

..  _extbase-localisation-no-frontend-backend-with-page:

Page-bound modules (with page tree)
-----------------------------------

If your module utilizes the backend page tree navigation component, TYPO3 knows
exactly which page the editor is viewing. Because pages map directly to sites,
you can automatically inherit the site's full localization rules—including
the site's languages, language titles for the language selector, and fallback
types.

To match the exact translation behavior your visitors see on the live frontend,
resolve the site language from the active page and generate the aspect using the
factory. Then hand the aspect to
:php:`findAllForLanguageAspect()` (see
:ref:`extbase-localisation-query-settings-aspect`) to add it to the query
settings and execute the query.

..  literalinclude:: _snippets/_ConferenceModuleController.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceModuleController.php
    :emphasize-lines: 24-25, 28, 35

Using :php:`LanguageAspectFactory::createFromSiteLanguage()` ensures your backend
module's data listings stay perfectly synchronized with the frontend site
configuration.

..  seealso::

    -   :ref:`extbase-no-frontend-backend-module` for more general information on
        using Extbase in backend modules.
    -   :ref:`extbase-persistence-storagepid-backend` describes where backend
        modules look for records, which is also
        resolved differently without a site.

..  _extbase-localisation-no-frontend-relations:

How relations are handled
=========================

Relational fields follow the exact same translation mapping rules used
throughout TYPO3. They are automatically resolved based on the specific language
aspect assigned to the parent query.

If you rely on the fallback environment (the default language aspect), any
relational child records fetched inside your commands will resolve to the
default language. If you explicitly fetch a parent record in a localized
language, its underlying relations will automatically match that localized
language context.
