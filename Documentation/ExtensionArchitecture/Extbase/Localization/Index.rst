:navigation-title: Localization

..  include:: /Includes.rst.txt
..  index:: Extbase; Localization
..  _extbase-localisation:

=======================
Localization in Extbase
=======================

..  Ported from old docs, combining two pages:
    - Extbase/Reference/Localization.rst (whole page, no old anchor —
      "Localization" title section). New anchor: extbase-localisation-translate.
    - Extbase/Reference/Domain/Model/Localization/Index.rst (whole page).
      Old anchors: extbase-model-localization, extbase-model-localizedUid.

..  todo::
    Needs review: This page was ported from the old Extbase documentation and
    needs updating to the rewrite conventions.

..  warning::
    The information on this page might be outdated!

..  _extbase-localisation-model:
..  _extbase-model-localization:

Localization of Extbase models
==============================

..  _extbase-localisation-localized-uid:
..  _extbase-model-localizedUid:

Identifiers in localized models
-------------------------------

Domain models have a main identifier :php:`uid` and an additional property
:php:`_localizedUid`.

Depending on whether the `overlay type <https://docs.typo3.org/permalink/t3coreapi:context-api-aspects-language-overlay-types>`_
language aspect is enabled (:typoscript:`LanguageAspect::OVERLAYS_ON` or
:typoscript:`LanguageAspect::OVERLAYS_MIXED`) or disabled (:typoscript:`LanguageAspect::OVERLAYS_OFF`),
the identifier contains different values.

When the overlay language aspect is enabled, then the :php:`uid`
property contains the :php:`uid` value of the default language record and
the :php:`uid` of the translated record is kept in the :php:`_localizedUid`.

+------------------------------------------------------------+-------------------------+---------------------------+
| Context                                                    | Record in language 0    | Translated record         |
+============================================================+=========================+===========================+
| Database                                                   | uid:2                   | uid:11, l10n_parent:2     |
+------------------------------------------------------------+-------------------------+---------------------------+
| Domain object values with Overlay language aspect enabled  | uid:2, _localizedUid:2  | uid:2, _localizedUid:11   |
+------------------------------------------------------------+-------------------------+---------------------------+
| Domain object values with Overlay language aspect disabled | uid:2, _localizedUid:2  | uid:11, _localizedUid:11  |
+------------------------------------------------------------+-------------------------+---------------------------+

..  hint::
    If your project uses :composer:`typo3/cms-workspaces` there is yet another
    additional property, :php:`_versionedUid`. Refer to the
    :doc:`Workspaces documentation <ext_workspaces:Index>` for details on
    workspace overlays.

..  _extbase-localisation-translate:

Translating labels
==================

This chapter covers how Extbase handles *records* across languages. Translating
the *labels* of an extension — button captions, flash messages, validation
errors — is a separate topic:

..  seealso::

    -   :ref:`Localization in Extbase <extension-localization-extbase>` — how to
        translate labels in controllers and services
    -   :ref:`LocalizationUtility API reference <extbase-localization-utility-api>` —
        all parameters of :php:`translate()`
    -   :ref:`Localization in Fluid <extension-localization-fluid>` — the
        `<f:translate>` ViewHelper
