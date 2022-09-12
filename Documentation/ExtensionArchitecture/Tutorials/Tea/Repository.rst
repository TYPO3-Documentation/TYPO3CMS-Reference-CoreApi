..  include:: /Includes.rst.txt

..  index::
    Tutorial Tea; Repository
..  _extbase_tutorial_tea_repositoy:

==========
Repository
==========

A basic repository can be quite a short class. The shortest possible
repository is an empty class inheriting from
:php:`TYPO3\CMS\Extbase\Persistence\Repository`:

..  code-block:: php
    :caption: EXT:tea/Classes/Domain/Repository/Product/TeaRepository.php

    <?php

    declare(strict_types=1);

    namespace TTN\Tea\Domain\Repository\Product;

    use TYPO3\CMS\Extbase\Persistence\Repository;

    class TeaRepository extends Repository
    {
    }

The model the repository should deliver is derived from the namespace and
name of the repository. A repository with the fully qualified name
:php:`TTN\Tea\Domain\Repository\Product\TeaRepository` therefore delivers
models with the fully qualified name :php:`TTN\Tea\Domain\Model\Product\Tea`
without further configuration.

In the EXT:tea extension some additional settings are required. These can be
done directly in the Repository or in a
`trait <https://www.php.net/manual/en/language.oop5.traits.php>`__. It is
important to know, that a trait overrides parameters and method from the
parent class but can be overridden from the current class.

The :php:`TeaRepository` configures the :php:`$defaultOrderings` directly in
the repository class and imports additional settings from the trait.

..  include:: /CodeSnippets/Tutorials/Tea/Classes/Domain/Repository/TeaRepository.rst.txt

We override the protected parameter :php:`$defaultOrderings` here. This parameter
is also defined in the parent class
:php:`TYPO3\CMS\Extbase\Persistence\Repository` and used here when querying
the database.

The trait itself is also defined in the extension:

..  include:: /CodeSnippets/Tutorials/Tea/Classes/Domain/Repository/StoragePageAgnosticTrait.rst.txt

Here we inject the :php:`$querySettings` and allow to fetch tea objects from
all pages. We then set these as default query settings.

The advantage of using a trait here instead of defining the parameters and
methods directly in the repository is, that the code can be reused without
requiring inheritance. Repositories of non-related models should not inherit
from each other.

Using the repository
====================

The :php:`TeaRepository` can now be used in a controller or another class
after it was injected by :ref:`Dependency Injection <Dependency-Injection>`:

..  include:: /CodeSnippets/Tutorials/Tea/Classes/Domain/Repository/InjectRepository.rst.txt

Then it can be used:

..  include:: /CodeSnippets/Tutorials/Tea/Classes/Domain/Repository/UseRepository.rst.txt

The method :php:`$this->teaRepository->findAll()` that is called here is
defined in the parent class :php:`Repository`.

You can also add additional methods here to query the database. See chapter
:ref:`"Repository" in the Extbase reference <extbase-repository>`. As this
example is very basic we do not need custom find methods.
