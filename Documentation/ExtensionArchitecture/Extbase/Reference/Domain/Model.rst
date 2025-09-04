.. include:: /Includes.rst.txt

.. index:: Extbase; Model

.. _extbase-model:

=====
Model
=====

All classes of the domain model should inherit from the class
:php:`\TYPO3\CMS\Extbase\DomainObject\AbstractEntity`.

An entity is an object fundamentally defined not by its attributes, but by a
thread of continuity and identity for example a person or a blog post.

Objects stored in the database are usually entities as they can be identified
by the :sql:`uid` and are persisted, therefore have continuity.

**Example:**

.. include:: /CodeSnippets/Extbase/Domain/AbstractEntity.rst.txt

Connecting the model to the database
====================================

It is possible to define models that are not persisted to the database. However in
the most common use cases you want to save your model to the database and load
it from there. See :ref:`extbase-Persistence`.

Properties
==========

The properties of a model can be defined either as public
class properties:

.. include:: /CodeSnippets/Extbase/Domain/ModelWithPublicProperty.rst.txt

Or public getters:

.. include:: /CodeSnippets/Extbase/Domain/ModelWithPublicGetters.rst.txt

A public getter takes precedence over a public property. Getters have the
advantage that you can make the properties themselves protected and decide
which ones should be mutable.

.. note::
   Making model's properties :php:`private` does not work in Extbase models: The parent
   classes need to access the models properties directly. If your model must
   not be extended you can mark it as :php:`final` and thereby prevent
   other developers from extending your model.

It is also possible to have getters for
properties that are not persisted and get created on the fly:

.. include:: /CodeSnippets/Extbase/Domain/ModelWithAdditionalGetters.rst.txt

One disadvantage of using additional getters is that properties that are only
defined as getters do not get displayed in the debug output in Fluid, they do
however get displayed when explicitly called:

.. code-block:: html
   :caption: Debugging different kind of properties

   Does not display "combinedString":
   <f:debug>{post.info}</f:debug>

   But it is there:
   <f:debug>{post.info.combinedString}</f:debug>

Relations
==========

Extbase supports different types of hierarchical relationships
between domain objects.
Relationships can be defined as unidirectional or as multidimensional in the model.

On the side of a relationship that can only have one counterpart, you must
decide whether it is allowed that no counterpart exists (allow null).


Nullable relations
------------------

There are two ways to allow :php:`null` for a property in PHP:

Nullable property types have been introduced with PHP 7.1 and can therefore
be used in any modern TYPO3 version:

.. code-block:: php
   :caption: Example for a nullable property

   protected ?Person $secondAuthor = null;

Union types, that can also be used to allow :php:`null`, have been introduced with
PHP 8.0.

.. code-block:: php
   :caption: Example for union type of null and Person

   protected Person|null $secondAuthor = null;

Both declarations have the same meaning.


1:1-relationship
----------------

A blog post can have, in our case, exactly one additional info attached to it.
The info always belongs to exactly one blog post. If the blog post gets deleted,
the info does get related.

.. include:: /CodeSnippets/Extbase/Domain/Optional1on1.rst.txt

1:n-relationship
----------------

A blog can have multiple posts in it. If a blog is deleted all of its posts
should be deleted. However a blog might get displayed without displaying the
posts therefore we load the posts of a blog lazily:

.. include:: /CodeSnippets/Extbase/Domain/Relationship1onN2.rst.txt

.. note::
   Note the subtle differences here. The methods :php:`setPosts()` and
   :php:`getPosts()` refer simultaneously to all blog posts.
   They expect and hence provide an :php:`ObjectStorage` object.

   The methods :php:`addPost()` and :php:`removePost()` refer to a single
   post object that is added to the list or removed from.

.. attention::
   It is possible to get an array of objects from an :php:`ObjectStorage`
   by calling :php:`$this->posts->toArray()`. However doing so and looping
   the resulting array might cause performance problems.

Each post belongs to exactly one blog, of course a blog does not get deleted
when one of its posts gets deleted.

.. include:: /CodeSnippets/Extbase/Domain/Relationship1onN1.rst.txt

A post can also have multiple comments and each comment belongs to exactly
one blog. However we never display a comment without its post therefore we do
not need to store information about the post in the comment's model: The
relationship is unidirectional.

.. include:: /CodeSnippets/Extbase/Domain/Relationship1onNUni.rst.txt

The model of the comment has no property to get the blog post in this case.

n:1-relationships
-----------------

n:1-relationships are the same like 1:n-relationsships but from the
perspective of the object:

Each post has exactly one main author but an author can write several blog
posts or none at all. He can also be a second author and no main author.

.. include:: /CodeSnippets/Extbase/Domain/RelationshipNon1Uni.rst.txt

Once more the model of the author does not have a property containing the
authors posts. If you would want to get all posts of an author you would have
to make a query in the PostRepository taking one or both relationships (first
author, second author) into account.

m:n-relationship
-----------------

A blog post can have multiple categories, each category can belong to
multiple blog posts.

.. include:: /CodeSnippets/Extbase/Domain/RelationshipNonM.rst.txt

Event
-----

The PSR-14 event :ref:`AfterObjectThawedEvent` is available to modify values
when creating domain objects.


Eager loading and lazy loading
===============================

By default, Extbase loads all child objects with the parent object (so for
example, all posts of a blog). This behavior is called eager loading.
The annotation :php:`@TYPO3\CMS\Extbase\Annotation\ORM\Lazy` causes Extbase to
load and build the objects only when they
are actually needed (lazy loading). This can lead to a significant
increase in performance.

On cascade remove
==================

The annotation :php:`@TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")` has
the effect that, if a blog is deleted, its posts will also be deleted
immediately. Extbase usually leaves all child objects' persistence unchanged.

Besides these two, there are a few more annotations available, which will be used
in other contexts. For the complete list of all Extbase
supported annotations, see the chapter :ref:`extbase-annotations`.

..  _extbase-model-localizedUid:

Identifiers in localized models
================================

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
    In case your project uses :t3ext:`workspaces` there is yet another
    additional property, :php:`_versionedUid`. Refer to the
    :doc:`Workspaces documentation <ext_workspaces:Index>` for details on
    workspace overlays.

.. TODO: Explain workspaces in Extbase context
