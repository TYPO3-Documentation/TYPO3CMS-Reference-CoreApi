:navigation-title: Localization

..  include:: /Includes.rst.txt
..  _extbase-model-localization:

==============================
Localization of Extbase models
==============================

..  _extbase-model-localizedUid:

Identifiers in localized models
===============================

Domain models have a main identifier :php:`uid` and an additional property
:php:`_localizedUid`.

Depending on whether the
:typoscript:`languageOverlayMode` mode is enabled (:typoscript:`true` or
:typoscript:`'hideNonTranslated'`) or disabled (:typoscript:`false`),
the identifier contains different values.

When :typoscript:`languageOverlayMode` is enabled, then the :php:`uid`
property contains the :php:`uid` value of the default language record,
the :php:`uid` of the translated record is kept in the :php:`_localizedUid`.

+----------------------------------------------------------+-------------------------+---------------------------+
| Context                                                  | Record in language 0    | Translated record         |
+==========================================================+=========================+===========================+
| Database                                                 | uid:2                   | uid:11, l10n_parent:2     |
+----------------------------------------------------------+-------------------------+---------------------------+
| Domain object values with `languageOverlayMode` enabled  | uid:2, _localizedUid:2  | uid:2, _localizedUid:11   |
+----------------------------------------------------------+-------------------------+---------------------------+
| Domain object values with `languageOverlayMode` disabled | uid:2, _localizedUid:2  | uid:11, _localizedUid:11  |
+----------------------------------------------------------+-------------------------+---------------------------+

..  hint::
    In case your project uses :composer:`typo3/cms-workspaces` there is yet another
    additional property, :php:`_versionedUid`. Refer to the
    :doc:`Workspaces documentation <ext_workspaces:Index>` for details on
    workspace overlays.

.. TODO: Explain workspaces in Extbase context
