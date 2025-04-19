:navigation-title: Relations

..  _extbase-model-relations:

================================
Relations between Extbase models
================================

Extbase supports different types of hierarchical relationships
between domain objects.
All relationships can be defined unidirectional or multidimensional in the model.

On the side of the relationship that can only have one counterpart, you must
decide whether it is possible to have no relationship (allow null) or not.


..  _extbase-model-nullable-relations:

Nullable relations
==================

There are two ways to allow :php:`null` for a property in PHP:

*   Mark the type declaration as nullable by prefixing the type name with a
    question mark:

    ..  code-block:: php
        :caption: Example for a nullable property

        protected ?Person $secondAuthor = null;

*   Use a union type:

    ..  code-block:: php
        :caption: Example for a union type of null and Person

        protected Person|null $secondAuthor = null;

Both declarations have the same meaning.

..  _extbase-model-relations-one-one:

1:1-relationship
================

A blog post can have, in our case, exactly one additional info attached to it.
The info always belongs to exactly one blog post. If the blog post gets deleted,
the info does get related.

..  include:: /CodeSnippets/Extbase/Domain/Optional1on1.rst.txt

..  _extbase-model-relations-one-many:

1:n-relationship
================

A blog can have multiple posts in it. If a blog is deleted all of its posts
should be deleted. However a blog might get displayed without displaying the
posts therefore we load the posts of a blog lazily:

..  include:: /CodeSnippets/Extbase/Domain/Relationship1onN2.rst.txt

..  note::
    Note the subtle differences here. The methods :php:`setPosts()` and
    :php:`getPosts()` refer simultaneously to all blog posts.
    They expect and hence provide an :php:`ObjectStorage` object.

    The methods :php:`addPost()` and :php:`removePost()` refer to a single
    post object that is added to the list or removed from.

..  attention::
    It is possible to get an array of objects from an :php:`ObjectStorage`
    by calling :php:`$this->posts->toArray()`. However doing so and looping
    the resulting array might cause performance problems.

Each post belongs to exactly one blog, of course a blog does not get deleted
when one of its posts gets deleted.

..  include:: /CodeSnippets/Extbase/Domain/Relationship1onN1.rst.txt

A post can also have multiple comments and each comment belongs to exactly
one blog. However we never display a comment without its post therefore we do
not need to store information about the post in the comment's model: The
relationship is unidirectional.

..  include:: /CodeSnippets/Extbase/Domain/Relationship1onNUni.rst.txt

The model of the comment has no property to get the blog post in this case.

..  _extbase-model-relations-many-one:

n:1-relationships
=================

n:1-relationships are the same like 1:n-relationsships but from the
perspective of the object:

Each post has exactly one main author but an author can write several blog
posts or none at all. He can also be a second author and no main author.

..  include:: /CodeSnippets/Extbase/Domain/RelationshipNon1Uni.rst.txt

Once more the model of the author does not have a property containing the
authors posts. If you would want to get all posts of an author you would have
to make a query in the PostRepository taking one or both relationships (first
author, second author) into account.

..  _extbase-model-relations-many-many:

m:n-relationship
================

A blog post can have multiple categories, each category can belong to
multiple blog posts.

..  include:: /CodeSnippets/Extbase/Domain/RelationshipNonM.rst.txt


..  _extbase-model-lazy-loading:

Eager loading and lazy loading
==============================

By default, Extbase loads all child objects with the parent object (so for
example, all posts of a blog). This behavior is called eager loading.
The annotation :php:`@TYPO3\CMS\Extbase\Annotation\ORM\Lazy` causes Extbase to
load and build the objects only when they
are actually needed (lazy loading). This can lead to a significant
increase in performance.

..  _extbase-model-cascade-remove:

On cascade remove
=================

The annotation :php:`@TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")` has
the effect that, if a blog is deleted, its posts will also be deleted
immediately. Extbase usually leaves all child objects' persistence unchanged.

Besides these two, there are a few more annotations available, which will be used
in other contexts. For the complete list of all Extbase
supported annotations, see the chapter :ref:`extbase-annotations`.
