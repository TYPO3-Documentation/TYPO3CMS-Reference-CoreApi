.. include:: /Includes.rst.txt
.. index:: Localization; Records

.. _extension-localization-record-translation:

=============================
Record translation
=============================

With TYPO3, you can localize the data sets in the backend. For records to be
translatable in the TYPO3 backend certain additional fields are needed.

All additional fields get added to the database automatically on the next call
to :guilabel:`Admin Tools -> Administration -> Database compare`.

You can finde a complete list of the required fields and their default TCA
configuration in the :ref:`TCA Reference, chapter Language
fields <t3tca:fields_language>`.

Depending on the technique you use to display the translated records in the
frontend you need to take measures to ensure the correct language is displayed
and that all fallback scenarios are considered.

Localized records as Extbase models
===================================

See chapters :ref:`Multi-language-domain-objects`,
:ref:`extebase_model_localized_id` and :ref:`extbase-repository-localization`.

Localization in DBAL Queries
============================

On using the DBAL :ref:`QueryBuilder <database-query-builder>` some automatic
restrictions are applied by the :ref:`database-restriction-builder`. This does
not include language settings and overlays.

.. attention::
   When you use the QueryBuilder you have to build the queries for the language
   overlays yourself.

   There is an issue about this: :forge:`88955`.

Localization in TypoScript
==========================

All common ways to query records in TypoScript automatically apply the language
settings and query the correct overlays. See
:ref:`extension-localization-typoscript-objects`.
