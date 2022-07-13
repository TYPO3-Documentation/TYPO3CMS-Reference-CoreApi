

.. index:: Repositories; API

Public Repository API
=====================

Each repository provides the following public methods:

`add($object)`
    Adds a new object.

`findAll()` and `countAll()`
    returns all domain objects (or the number of them) it is responsible for.

`findByUid($uid)`
    Returns the domain object with this UID.

`findByProperty($propertyValue)` and `countByProperty($propertyValue)`
    Magic finder method. Finding all objects (or the number of them) for the property *property* having
    a value of `$propertyValue` and returns them in an array, or the number as an integer value.

`findOneByProperty($propertyValue)`
    Magic finder method. Finds the first object, for which the given property *property* has the value
    `$propertyValue`.

`remove($object)` and `removeAll()`
    Deletes an object (or all objects) in the repository.

`replace($existingObject, $newObject)`
    Replaces an object of the repositories with another.

`update($object)`
    Updates the persisted object.


.. index:: Repositories; Custom find methods

Custom find methods in repositories
-----------------------------------

A repository can be extended with own finder methods. Within this methods, you can use the ``Query`` object,
to formulate a request:

.. todo: Enhance this code snippet. Add the surrounding class.


.. code-block:: php
   :caption: EXT:my_extension/Classes/Domain/Repository/ModelRepository.php

   // use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
   // use Ex\BlogExample\Domain\Model\Category;

    /**
     * Find blogs, which have the given category.
     *
     * @param Category $category
     *
     * @return QueryResult
     */
    public function findWithCategory(Category $category) : QueryResult
    {
        $query = $this->createQuery();
        $query->matching($query->contains('categories', $category));
        return $query->execute();
    }

Create a ``Query`` object within the repository through `$this->createQuery()`. You can give the query
object a constraint using `$query->matching($constraint)`. The following comparison operations for
generating a single condition are available:

`$query->equals($propertyName, $operand, $caseSensitive);`
    Simple comparison between the value of the property provided by `$propertyName` and the operand.
    In the case of strings, you can specify additionally whether the comparison is case-sensitive.

`$query->in($propertyName, $operand);`
    Checks if the value of the property `$propertyName` is present within the series of values in `$operand`.

`$query->contains($propertyName, $operand);`
    Checks whether the specified property `$propertyName` containing a collection has an element
    `$operand` within that collection.

`$query->like($propertyName, $operand);`
    Comparison between the value of the property specified by `$propertyName` and a string $operand.
    In this string, the %-character is interpreted as a placeholder (similar to * characters in search
    engines, in reference to the SQL syntax).

`$query->lessThan($propertyName, $operand);`
    Checks if the value of the property `$propertyName` is less than the operand.

`$query->lessThanOrEqual($propertyName, $operand);`
    Checks if the value of the property `$propertyName` is less than or equal to the operand.

`$query->greaterThan($propertyName, $operand);`
    Checks if the value of the property `$propertyName` is greater than the operand.

`$query->greaterThanOrEqual($propertyName, $operand);`
    Checks if the value of the property `$propertyName` is greater than or equal to the operand.

Since 1.1 (TYPO3 4.3), `$propertyName` is not necessarily only a simple property-name but also can be a "property path".
    Example: `$query->equals('categories.title', 'tools')` searches for objects having a category titled
    "tools" assigned. If necessary, you can combine multiple conditions with boolean operations.

`$query->logicalAnd($constraint1, $constraint2);`
   Two conditions are joined with a logical *and* that returns a condition.
   Multiple parameters are allowed, at least 2. As of TYPO3 version 12, passing the
   parameters as an array is not allowed. Use the following migration:

   .. code-block:: php
      :caption: EXT:my_extension/Classes/Domain/Repository/ModelRepository.php

       $constraints = [];

       if (...) {
          $constraints[] = $query->equals('propertyName1', 'value1');
       }

       if (...) {
          $constraints[] = $query->equals('propertyName2', 'value2');
       }

       $query = $this->createQuery();

       $numberOfConstraints = count($constraints);
       if ($numberOfConstraints === 1) {
           $query->matching(reset($constraints));
       } elseif ($numberOfConstraints >= 2) {
           $query->matching($query->logicalAnd(...$constraints));
       }

`$query->logicalOr($constraint1, $constraint2);`
   Two conditions are joined with a logical *or*, that returns a condition.
   A minimum of two parameters are allowed. As of TYPO3 version 12, passing the
   parameters as an array is not allowed. For a migration, check the
   description above for :php:`logicalAnd`.

`$query->logicalNot($constraint);`
    Returns a condition that inverts the result of the given condition (logical *not*).

In the section ":ref:`individual_database_queries`" in Chapter 6, you can find a comprehensive example for building queries.
