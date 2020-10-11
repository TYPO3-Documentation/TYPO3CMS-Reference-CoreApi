
.. include:: ../../Includes.txt

.. _BitSet:

==================
How To Use BitSets
==================

To efficiently handle boolean flags, bit sets can be used since TYPO3 v10.

Class :php:`\TYPO3\CMS\Core\Type\BitSet` provides a TYPO3 implementation of a :php:`BitSet`.
It can be used standalone and accessed from the outside, but we recommend creating
specific :php:`BitSet` classes that extend the TYPO3 :php:`BitSet` class.

The functionality is best described by an example:

::

   <?php
   declare(strict_types = 1);

   define('PERMISSIONS_NONE', 0b0); // 0
   define('PERMISSIONS_PAGE_SHOW', 0b1); // 1
   define('PERMISSIONS_PAGE_EDIT', 0b10); // 2
   define('PERMISSIONS_PAGE_DELETE', 0b100); // 4
   define('PERMISSIONS_PAGE_NEW', 0b1000); // 8
   define('PERMISSIONS_CONTENT_EDIT', 0b10000); // 16
   define('PERMISSIONS_ALL', 0b11111); // 31

   $bitSet = new \TYPO3\CMS\Core\Type\BitSet(PERMISSIONS_PAGE_SHOW | PERMISSIONS_PAGE_NEW);
   $bitSet->get(PERMISSIONS_PAGE_SHOW); // true
   $bitSet->get(PERMISSIONS_CONTENT_EDIT); // false

This is directly using the TYPO3 Core class. Implementing that via an extending class
makes it clearer and easier to use:

::

   <?php
   declare(strict_types = 1);

   class Permissions extends \TYPO3\CMS\Core\Type\BitSet
   {
       public const NONE = 0b0; // 0
       public const PAGE_SHOW = 0b1; // 1
       public const PAGE_EDIT = 0b10; // 2
       public const PAGE_DELETE = 0b100; // 4
       public const PAGE_NEW = 0b1000; // 8
       public const CONTENT_EDIT = 0b10000; // 16
       public const ALL = 0b11111; // 31

       /**
        * @param int $permission
        * @return bool
        */
       public function hasPermission(int $permission): bool
       {
           return $this->get($permission);
       }

       /**
        * @return bool
        */
       public function hasAllPermissions(): bool
       {
           return $this->get(static::ALL);
       }

       /**
        * @param int $permission
        */
       public function allow(int $permission): void
       {
           $this->set($permission);
       }
   }

   $permissions = new Permissions(Permissions::PAGE_SHOW | Permissions::PAGE_NEW);
   $permissions->hasPermission(Permissions::PAGE_SHOW); // true
   $permissions->hasPermission(Permissions::CONTENT_EDIT); // false
