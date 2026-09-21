:navigation-title: Writing records

..  include:: /Includes.rst.txt
..  index:: Extbase; Localization
..  _extbase-localisation-writing:

=================================
Writing records from the frontend
=================================

Everything about reading records applies to plugins that only display data.
As soon as a plugin writes — a registration form, a comment, a submitted
conference proposal — the language question changes shape: not "which records
do I get back", but "what language does the record I just created belong to".

..  _extbase-localisation-writing-default:

New records are created in the default language
===============================================

When Extbase persists a new object it fills in the language fields itself:

*   The language field is set to :php:`0`, the default language, unless the
    object already carries a language of its own.
*   The translation parent field is set to :php:`0`.

A record submitted by a visitor browsing the Polish version of a site is
therefore stored as a default-language record, not as a Polish one. Setting the
language explicitely on the object before persisting it stores the record in that language:

..  literalinclude:: _snippets/_ConferenceControllerLanguage.php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php
    :emphasize-lines: 21-22

That is enough to file a record under a language. It is not enough to make it
a translation.

..  _extbase-localisation-writing-translations:

Extbase does not create translations
====================================

A translation is a record that points at the record it translates, through the
translation parent field. Extbase always writes :php:`0` into that field when
it creates a record, and never writes anything else into it.

The consequence is that Extbase can create a record *in* a language, but it
cannot create a record that is *a translation of* another record. Two records
written this way — one with the language field set to English, one to Polish —
remain two unrelated records. Nothing connects them, and no overlay will ever
combine them.

Editing an existing translation does work: when a translated record is fetched
and modified, Extbase writes the changes back to the translated record rather
than to its default-language original.

..  _extbase-localisation-writing-consequences:

What this means for a multilingual site
=======================================

On a site using `fallbackType: strict`, records without a translation are not
shown. Records created through a frontend form are default-language records
without a translation. A visitor who submits a conference proposal on the
Polish site will therefore not see it on the Polish site afterwards — it
exists, but the language configuration hides it until somebody actually relates it to
its default language parent and so translates it.

On `fallback` the same record stays visible in every language, because
untranslated records show through from the default language.

..  _extbase-localisation-writing-alternatives:

When to use something else
==========================

Extbase persistence is a good fit for frontend writes when the object is
structurally simple: a single record, no relations to create alongside it, and
no translation involved. Registration forms, contact requests and comments are
all comfortably within that.

Beyond it, other tools are a better fit:

*   The :ref:`DataHandler <tce-database-basics>` creates real
    translations, maintains relations and respects workspaces and record
    history. Anything that has to produce a translated record belongs here.
*   :doc:`EXT:form <ext_form:Index>` covers form-shaped work — building,
    validating and processing forms — without hand-writing a controller for
    it.
*   A mixture is often the right answer: Extbase for reading and for the
    simple write, the DataHandler for the step that creates or updates a
    translation.

..  _extbase-localisation-writing-relations:

What this means for relations
=============================

Relations are where frontend writing most often outgrows Extbase.

Extbase can persist relations of an object it creates, but it does so with the
same limitation as everywhere else: the related records are written as
default-language records too, and no translation relationship is established
between them and anything else. An object graph created from a frontend form
is therefore entirely default-language, however the form was labelled. This goes
with the exception of language setting being applied explicitely in the query, so
it is the developers responsibility to provide that. But still no valid translation
record, connected to its default language record, can be created purely by Extbase.

Where a frontend form has to create or modify a translated object together
with its relations, the DataHandler is the appropriate tool, rather than
Extbase persistence with corrections applied afterwards.
