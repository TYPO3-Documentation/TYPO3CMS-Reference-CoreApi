:navigation-title: Relations

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Relations
..  _extbase-persistence-relations:

===========================
Object relations in Extbase
===========================

Domain objects are rarely isolated. A :php:`Conference` is held at a
:php:`Location`, collects many :php:`Comment` objects, and is staffed by many
:php:`Speaker` objects. Extbase maps these relations onto the relational
database and loads the related objects for you when you access the property — no
:sql:`JOIN` in your own code.

From the model's point of view a relation is just a property, and Extbase offers
exactly **two shapes** for it:

*   a property that holds **one other object** — a direct, typed property; or
*   a property that holds **many objects** — an
    :php:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage`.

This page starts from those two shapes — what you write and how each behaves —
then goes behind the scenes to the TCA that drives them, explains why
"cardinality" (1:1, 1:n, …) is a property of *both* sides of a relation rather
than of a single field, and finishes with how related objects are loaded and the
lazy-loading performance trade-off.

How to **declare** relations in a model — the attributes, the
:php:`ObjectStorage` getter/setter pattern — is covered with the model:

..  seealso::

    `Modelling relations in Extbase <https://docs.typo3.org/permalink/extbase-domain-model-relations>`_ — declaring relation properties, lazy and cascade attributes, ObjectStorage accessors.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-persistence-relations-to-one:

A relation to one other object
==============================

The simplest relation points from one object to a single other one — a
:php:`Conference` is held at a :php:`Location`. In the model this is a single,
typed, usually nullable property:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

    use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

    class Conference extends AbstractEntity
    {

        protected ?Location $location = null;

        protected function getLocation(): ?Location
        {
            return $this->location;
        }

    }

The property is nullable because, from this object's side, the relation is
optional: a conference may or may not have a location set. Reading it is a plain
getter method.

In the database, the relation is stored as a **single column on the owning
table** that holds the UID of the related record (for example a :sql:`location`
column on the conference table). The related record does not know it is being
pointed at — nothing on the :php:`Location` side records the conference.

..  note::

    This is a relation to *at most one* other object (0..1). It is tempting to
    call it a "1:1 relation", but that is not what the model states: nothing
    here says a location belongs to exactly one conference, or that it knows
    about the conference at all. The cardinality language (1:1, 1:n, …) only
    becomes meaningful once both sides are declared — see
    :ref:`extbase-persistence-relations-behind`.


..  _extbase-persistence-relations-to-many:

A relation to many objects
==========================

When an object holds a collection of others, the property is an
:php-short:`\TYPO3\CMS\Extbase\Persistence\ObjectStorage` — Extbase's container for
related objects. A :php:`Conference` collects many :php:`Comment` objects, and is
staffed by many :php:`Speaker` objects; both are :php:`ObjectStorage` properties:

..  literalinclude:: _snippets/_ConferenceWithComments.php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

You iterate the storage to read the related objects, and add or remove single
objects through dedicated :php:`addComment()` / :php:`removeComment()` methods
that call :php:`attach()` and :php:`detach()`. The :php:`@var
ObjectStorage<Comment>` annotation is required so that IDEs and static analysis
know the element type.

The two collections above look identical in PHP, but they are stored
differently in the database — and that difference decides what happens when you
delete the owning object.


..  _extbase-persistence-relations-to-many-backref:

Children that belong to the parent
----------------------------------

The comments of a conference exist only as part of that conference: a comment
has no life of its own. The natural way to store this is a **back-reference
column on the child table** — a :sql:`conference` column on the comment table
holding the parent UID, so no intermediate table is needed. The most common TCA
design for such relations is
:ref:`type="inline" <t3tca:columns-inline-introduction>` with a
:sql:`foreign_field` naming that back-reference column. Other field types can
express the same relation, but inline is the usual and most convenient choice
for parent-owned children.

Because the child belongs to the parent, this is the natural place for
:php:`#[Cascade('remove')]`: deleting the conference deletes its comments. See
:ref:`Modelling relations <extbase-domain-model-relations>`
for the attribute.


..  _extbase-persistence-relations-to-many-shared:

Shared records linked through an MM table
-----------------------------------------

Speakers are different: a speaker appears at many conferences, and deleting one
conference must not delete the speaker. The related records are **shared and
exist independently**. TYPO3 offers two ways to store such a collection:

*   **An intermediate table** (an :sql:`MM` table) with one row per pairing — a
    row linking a conference UID to a speaker UID, so neither domain table stores
    the relation directly. TCA expresses this as
    :ref:`type="select" <t3tca:columns-select>` or
    :ref:`type="group" <t3tca:columns-group-introduction>` plus an :sql:`MM`
    setting naming the intermediate table.
*   **A comma-separated list** of UIDs in a single column on the owning table
    (the same :sql:`type=select` / :sql:`group` field *without* an :sql:`MM`
    setting). This avoids the extra table but does not scale, is harder to query,
    and records the relation on one side only.

Prefer the MM table for genuine many-relations: it scales, supports relation
ordering, and can be queried efficiently. The comma-separated form is acceptable
for short, fixed lists where those limitations do not matter.

..  literalinclude:: _snippets/_ConferenceWithSpeakers.php
    :caption: EXT:my_extension/Classes/Domain/Model/Conference.php

Because the related objects are shared, **never** put
:php:`#[Cascade('remove')]` on this kind of relation — removing the link must
not delete a speaker who still appears at other conferences. Removing an object
from the :php:`ObjectStorage` deletes the **link** between the two records (the
MM row, or the entry in the comma-separated list), not the speaker record itself.


..  _extbase-persistence-relations-behind:

Behind the scenes: TCA, unidirectional and bidirectional relations
==================================================================

The model property tells you *that* there is a relation and whether it holds one
object or many. It does **not**, on its own, tell you the full shape of the
relation. That comes from the :abbr:`TCA (Table Configuration Array)` of the
column: whether there is a back-reference field, an MM table, a
:sql:`maxitems` limit, or an explicit :sql:`relationship` setting. Extbase reads
that TCA and maps each column to one of its internal relation kinds — a single
related object, a collection with a back-reference, or a collection through an MM
table.

The examples above are all **unidirectional**: you can navigate from the
conference to its location, comments and speakers, but not back. A
:php:`Location` usually does not know which conference is held there; a :php:`Speaker`
does not list the conferences they speak at. Each relation is declared once, on
the owning side only.

This is why the classic cardinality labels do not apply to a single property.
Terms like **1:1**, **1:n**, **n:1** and **n:m** describe how *both* ends of a
relation are constrained — and you only know both ends when the relation is
**bidirectional**, declared on each side:

*   :php:`Conference` → :php:`Location` on its own is *a relation to one other
    object*. Whether it is "1:1" (each location used by exactly one conference)
    or "n:1" (many conferences share a location) depends on a constraint that
    lives on the :php:`Location` side — and nothing in the conference model
    states it.
*   Likewise *a relation to many* becomes a "1:n" only if the child side is
    constrained to a single parent. As written, the comment relation simply
    collects children; it does not, by itself, forbid a comment from being
    attached elsewhere.

For everyday extension code this rarely matters, because Extbase relations are
overwhelmingly unidirectional — you model the direction you actually navigate and
leave the other side unaware. Reach for a bidirectional relation only when you
genuinely need to navigate *and* query from both ends; it means declaring and
maintaining the relation, and its TCA, on both models.

..  tip::

    When you do need cardinality made explicit in TCA, the
    :ref:`relationship <t3tca:columns-select>` key
    (:php:`'oneToOne'`, :php:`'manyToOne'`, :php:`'oneToMany'`)
    declares it on the field. Extbase honours it when deciding whether a column
    is a single relation or a collection.


..  _extbase-persistence-relations-loading:

How Extbase loads related objects
=================================

By default Extbase loads a relation **eagerly**: when the parent object is
hydrated, its related objects are loaded in the same operation and the property
already contains ready-to-use objects. You call :php:`$conference->getLocation()`
or iterate :php:`$conference->getComments()` and the objects are simply there.

The order of children inside a collection is **not** controlled by repository
queries — there is no query to override, because Extbase loads the children as
part of the parent. Child ordering comes from the TCA of the relation
(:sql:`foreign_sortby` / :sql:`foreign_default_sortby`), not from
:php:`$defaultOrderings` or :php:`setOrderings()`. This catches developers out:

..  seealso::

    `Ordering in Extbase relations <https://docs.typo3.org/permalink/extbase-domain-repository-ordering-relations>`_ — why repository sort orders do not affect relation children.


..  _extbase-persistence-relations-lazy:

Lazy loading and the N+1 query trap
===================================

Eager loading is convenient but not free. Loading a list of 50 conferences, each
with an eagerly loaded :php:`ObjectStorage` of comments, means Extbase loads
every comment of every conference up front — even if the list view never displays
them.

Marking the relation :php:`#[Lazy]` defers loading: Extbase installs a
lightweight placeholder and loads the related objects only on first access. A
single relation receives a
:php:`\TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy`; an
:php:`ObjectStorage` becomes a
:php:`\TYPO3\CMS\Extbase\Persistence\Generic\LazyObjectStorage`. Both resolve on
first access.

Lazy loading solves the *load-everything-up-front* problem but introduces its
opposite — the **N+1 query problem**. Consider a template that *does* need the
relation for every row:

..  literalinclude:: _snippets/_NPlusOne.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/List.fluid.html

If this were a lazy relation, it would run **one** query to fetch 50 conferences
and then **one more query per conference** to load comments — 51 queries for one
page. Making the relation lazy would not mean less work here; it would spread the
same work across many small queries, which is usually slower than one larger one.

The rule of thumb:

*   **Eager (the default)** when you usually need the related objects — for
    example a detail view that always renders the location and all comments.
*   **Lazy** (:php:`#[Lazy]`) when you usually *do not* need the relation — for
    example a list view that shows only titles, where loading every child would
    be wasted work.
*   If a list view *does* need related data for every row, neither is ideal. It
    is often best to step outside the ORM and fetch what the view needs in a
    single query.

..  seealso::

    `When to drop out of the ORM <https://docs.typo3.org/permalink/extbase-domain-repository-dbal>`_ — using raw DBAL from a repository when relation loading creates a performance problem.

The lazy-versus-eager decision is per relation and reversible — it is a property
attribute, not a schema change — so measure with real data before optimising.

..  seealso::

    *   `Persistence and the Extbase ORM <https://docs.typo3.org/permalink/extbase-concepts-persistence>`_ — the ORM mental model.

    *   `Querying the database with Extbase <https://docs.typo3.org/permalink/extbase-persistence-queries>`_ — storagePid, query settings, and debugging.

    *   `Modelling relations in Extbase <https://docs.typo3.org/permalink/extbase-domain-model-relations>`_ — declaring relations in the model.

With relations and queries understood, you have the full persistence picture of
an Extbase extension. For everything the ORM does not do — aggregates, bulk
writes, complex joins — see :ref:`extbase-domain-repository-dbal`.
