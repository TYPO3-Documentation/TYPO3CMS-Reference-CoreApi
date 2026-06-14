:navigation-title: Relations

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Relations
..  _extbase-persistence-relations:

===========================
Object relations in Extbase
===========================

Domain objects are rarely isolated objects, for example, a :php:`Conference`
has a :php:`Location`, contains many :php:`Comment` objects, and is staffed by many :php:`Speaker`
objects who speak at many other conferences. Extbase maps these object
relations onto the relational database and loads the related objects for you
when you access the property — all without needing a :sql:`JOIN` in your code.

This page explains how relation **cardinality** is stored and loaded, and
the performance trade-off that lazy loading introduces. How to **declare**
relations in a model — the property types, :php:`#[Lazy]`, :php:`#[Cascade]`,
the :php:`ObjectStorage` getter/setter pattern — is covered in the model:

..  seealso::

    `Modelling relations in Extbase <https://docs.typo3.org/permalink/extbase-domain-model-relations>`_ — declaring relation properties, lazy and cascade attributes, ObjectStorage accessors.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-persistence-relations-cardinality:

The three relation cardinalities
================================

A relation's *cardinality* is how many objects sit on each side of the relation. Throughout this
page the cardinality is written **near:far** — the owning model you query from
first, the related model second — and the digits are never reordered, so 1:n
always reads "one owner, many related". The three common cases map to different
database layouts. The model property can look similar in each case, so the TCA
configuration is what actually decides the shape.

..  _extbase-persistence-relations-1-1:

One-to-one (1:1)
----------------

The owning object relates to exactly one other object — a :php:`Conference` has one
:php:`Location`. In a model, this is a single, typed, usually nullable, property.

In the database, the relation is stored as a single column in the owning table
and it contains the UID of the related record (for example, a :sql:`location` column in
the conference table). The TCA column is typically a
:ref:`select <t3tca:confval-select-single-foreign-table>` or
:ref:`group <t3tca:columns-group-introduction>` field with
:sql:`maxitems = 1`.

..  note::

    A single related object in a model can express several intentions that look
    identical in code but differ in TCA and meaning: a true 1:1 (both sides
    required and unique), a 1:0..1 (the relation is optional — model it as a
    nullable property), or a relation where several owning records are allowed to
    reference the *same* related record. Decide which you mean, because it drives
    whether the property is nullable and whether the related record may be shared.
    Extbase itself does not enforce uniqueness on the related object side.


..  _extbase-persistence-relations-1-n:

One-to-many (1:n)
-----------------

The owning object holds a collection of others that belong to it — a
:php:`Conference` has many :php:`Comment` objects, and a comment exists only as
part of its conference. In the model this collection is an
:php:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage` which is Extbase's container for
related objects.

In the database, the *child* records contain a column pointing back at the parent
(for example, a :sql:`conference` column on the comment table). TCA expresses
this with :ref:`type="inline" <t3tca:columns-inline-introduction>` and
:sql:`foreign_field` naming that back-reference column. No intermediate table is
involved.

Because the child belongs to the parent, a 1:n relation is the natural place for
:php:`#[Cascade('remove')]`: deleting the conference deletes its related comments. See
`Modelling relations <https://docs.typo3.org/permalink/extbase-domain-model-relations>`_
for the attribute.


..  _extbase-persistence-relations-m-n:

Many-to-many (m:n)
------------------

The owning object contains a collection of other objects that exist independently, and the
relationship runs in both directions  — a :php:`Conference` has many :php:`Speaker`
objects, and each speaker appears at many conferences. Deleting one conference
must not delete the speaker. In the model the collection is also type
:php:`ObjectStorage`.

In the database, an m:n relation is normally stored in an **intermediate
table** (an :sql:`MM` table) with one row per pairing — a row linking a
conference UID to a speaker UID. Neither domain table stores the relation
directly. TCA expresses this as
:ref:`type="select" <t3tca:columns-select>` or
:ref:`type="group" <t3tca:columns-group-introduction>` plus an :sql:`MM`
setting with the name of the intermediate table. The MM table is the recommended form: it
scales, supports relation ordering, and can be queried efficiently.

A relation can alternatively be stored as a **comma-separated list** of UIDs in
a single column in the owning table (the same :sql:`type=select` / :sql:`group`
field *without* an :sql:`MM` setting). This avoids the extra table but does not
scale, is hard to query, and only records the relation on one side. It is better to use an
MM table for genuine m:n relations; the CSV form is acceptable for short,
one-directional lists.

Because the related objects are shared, **never** put :php:`#[Cascade('remove')]`
on an m:n relation — removing the link must not delete a speaker who still
belongs to other conferences. Removing an object from :php:`ObjectStorage`
deletes the row in the MM table, and not the speaker record.

..  literalinclude:: _snippets/_ConferenceWithSpeakers.php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php (m:n to Speaker)


..  _extbase-persistence-relations-loading:

How Extbase loads related objects
=================================

By default Extbase loads a relation **eagerly**: when the parent object is
hydrated, its related objects are loaded in the same operation and the property
contains ready-to-use objects. You access :php:`$conference->getLocation()` or
iterate :php:`$conference->getComments()` and the objects are simply there.

The order of children inside a relation is **not** controlled by repository
queries — there is no query to override, because Extbase loads the children as
part of the parent. Child ordering comes from the TCA of the relation
(:sql:`foreign_sortby` / :sql:`foreign_default_sortby`), not from
:php:`$defaultOrderings` or :php:`setOrderings()`. This can catch developers out:

..  seealso::

    `Ordering in Extbase relations <https://docs.typo3.org/permalink/extbase-domain-repository-ordering-relations>`_ — why repository sort orders do not affect relation children.


..  _extbase-persistence-relations-lazy:

Lazy loading and the N+1 query trap
===================================

Eager loading is convenient but not without a cost. Loading a list of 50 conferences,
each with an eagerly loaded :php:`ObjectStorage` of comments, means that Extbase
loads every comment about every conference upfront — even if the list view never
displays them.

Marking the relation as :php:`#[Lazy]` defers loading: Extbase installs a lightweight
placeholder and loads the related objects only when you first access the
property. A singular relation receives a
:php:`\TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy`; an
:php:`ObjectStorage` becomes a
:php:`\TYPO3\CMS\Extbase\Persistence\Generic\LazyObjectStorage`. Both resolve
on first access.

Lazy loading solves the *load-everything-up-front* problem but introduces its
opposite — the **N+1 query problem**. Consider a template that *does* need
the lazy relation for each row:

..  literalinclude:: _snippets/_NPlusOne.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/List.fluid.html

If this were a lazy relation, it would run **one** query to fetch 50 conferences then
**one more query per conference** to load comments — 51 queries run on on this one page. The fact that the query is lazy would
not mean less work here; it would spread the same work across many small queries, which is usually
slower than one larger one.

The rule of thumb:

*   **Eager (the default)** when you usually need the related objects, for example,
    a detail view that always renders location and all comments.
*   **Lazy** (:php:`#[Lazy]`) when you usually *do not* need the relation, for example,
    a list view that shows only titles, where loading every child would be
    wasted work.
*   If a list view *does* need related data for every row, neither is
    ideal. It is often best to step outside the ORM and fetch
    what the view needs in a single query.

..  seealso::

    `When to drop out of the ORM <https://docs.typo3.org/permalink/extbase-domain-repository-dbal>`_ — using raw DBAL from a repository when relation loading creates a performance problem.

The lazy-versus-eager decision is per relation and reversible — it is a property
attribute rather than a schema change — so measure performance with real data before optimising.

..  seealso::

    `Persistence and the Extbase ORM <https://docs.typo3.org/permalink/extbase-concepts-persistence>`_ — the ORM mental model.

    `Querying the database with Extbase <https://docs.typo3.org/permalink/extbase-persistence-queries>`_ — storagePid, query settings, and debugging.

    `Modelling relations in Extbase <https://docs.typo3.org/permalink/extbase-domain-model-relations>`_ — declaring relations in the model.

With relations and queries now understood, you have the full persistence picture
of an Extbase extension. For everything that the ORM does not do —
aggregates, bulk writes, complex joins — see
:ref:`extbase-domain-repository-dbal`.
