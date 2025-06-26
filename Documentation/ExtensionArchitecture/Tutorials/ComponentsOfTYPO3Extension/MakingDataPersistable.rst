:navigation-title: Persistance

..  include:: /Includes.rst.txt
..  _making-data-persistable:

======================
Persistence in Extbase
======================

Create an entity class and repository:

*   Add `example-extension/Classes/Domain/Model/{entity name}.php`

    * Inside the file create a PHP class matching the filename and extend from`TYPO3\CMS\Extbase\DomainObject\AbstractEntity`
    * Add database columns as class properties, using type declarations matching your domain model properties
    * Add getter and setter for each property

* Add `example-extension/Classes/Domain/Repository/{entity name}Repository.php`

    * Like with the model before, create a PHP class matching the naming schema and extend from `TYPO3\CMS\Extbase\Persistence\Repository`

* Add tests according to :ref:`Testing <t3coreapi:testing>`

    * Test getters and setters for entity class
    * Test find methods of repository
    * Test if test subject is an instance of the correct superclass
