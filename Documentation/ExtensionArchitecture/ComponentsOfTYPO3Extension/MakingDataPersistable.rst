.. _making-data-persistable:

===================================
Making Data Persistable by Extbase
===================================

Create an Entity Class and Repository
-------------------------------------

* Add `./Classes/Domain/Model/{entity name}.php`
  * Extend `TYPO3\CMS\Extbase\DomainObject\AbstractEntity`
  * Add database columns as class properties
  * Add getter and setter for each property
* Add `./Classes/Domain/Repository/{entity name}Repository.php`
  * Extend `TYPO3\CMS\Extbase\Persistence\Repository`
* Add tests
  * Test getters and setters for entity class
  * Test find methods of repository
  * Test if test subject is an instance of the correct superclass
