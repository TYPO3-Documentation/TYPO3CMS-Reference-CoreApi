
.. include:: ../../Includes.txt

.. _Enumerations-How-to-use:

=======================
How To Use Enumerations
=======================


.. _Enumerations-Create-an-Enumeration:

Create an Enumeration
=====================

To create a new enumeration you have to extend the class :php:`TYPO3\CMS\Core\Type\Enumeration`,
make sure your enumeration is marked :php:`final`, this ensures your code only receives a known
set of values. Otherwise adding more values by extension will lead to undefined behavior in your code.

Values are defined as constants in your implementation. The names of the constants must be given in uppercase.

A special, optional constant :php:`__default` represents the default value of your enumeration
if it is present. In that case the enumeration can be instantiated without a value and
will be set to the default.

Example::

   final class LikeWildcard extends \TYPO3\CMS\Core\Type\Enumeration
   {
      const __default = self::BOTH;

      /** @var int Do not use any wildcard */
      const NONE = 0;

      /** @var int Use wildcard on left side */
      const LEFT = 1;

      /** @var int Use wildcard on right side */
      const RIGHT = 2;

      /** @var int Use wildcard on both sides */
      const BOTH = 3;
   }


.. _Enumerations-Use-an-Enumeration:

Use an Enumeration
==================

You can create an instance of the :php:`Enumeration` class like you would usually do,
or you can use the :php:`Enumeration::cast()` method
for instantiation. The :php:`Enumeration::cast()` method can handle both :php:`Enumeration`
instances (where it will simply return the value) and simple types with a valid :php:`Enumeration`
value, whereas the "normal" :php:`__construct` will always try to create a new instance.

That allows to deprecate enumeration values or do special value
casts before finding a suitable value in the enumeration.

Example::

   $likeWildcardLeft = LikeWildcard::cast(LikeWildcard::LEFT);

   $valueFromDatabase = 1;

   // will cast the value automatically to an enumeration.
   // Result is true.
   $likeWildcardLeft->equals($valueFromDatabase);

   $enumerationWithValueFromDb = LikeWildcard::cast($valueFromDatabase);

   // Remember to always use ::cast and never use the constant directly
   $enumerationWithValueFromDb->equals(LikeWildcard::cast(LikeWildcard::RIGHT));


Exceptions
==========

If the enumeration is instantiated with an invalid value an
:php:`TYPO3\CMS\Core\Type\Exception\InvalidEnumerationValueException` is thrown.
This exception must be caught and you have to decide what the appropriate
behavior should be.

.. important::

   Always be prepared to handle exceptions when instantiating
   enumerations from user defined values!

Example::

   try {
      $foo = LikeWildcard::cast($valueFromPageTs);
   } catch (\TYPO3\CMS\Core\Type\Exception\InvalidEnumerationValueException) {
      $foo = LikeWildcard::cast(LikeWildcard::NONE);
   }


.. _Enumerations-Implement-custom-logic:

Implement Custom Logic
======================

Sometimes it not only makes sense to validate a value but to also
have custom logic as well..

For example, the :php:`TYPO3\CMS\Core\Versioning\VersionState` enumeration contains
values of version states. Some of the values indicate that the state is a "placeholder".
This logic can be implemented by a custom method::

   final class VersionState extends \TYPO3\CMS\Core\Type\Enumeration
   {
      const __default = self::DEFAULT_STATE;
      const NEW_PLACEHOLDER_VERSION = -1;
      const DEFAULT_STATE = 0;
      const NEW_PLACEHOLDER = 1;
      const DELETE_PLACEHOLDER = 2;
      const MOVE_PLACEHOLDER = 3;
      const MOVE_POINTER = 4;

      /**
       * @return bool
       */
      public function indicatesPlaceholder()
      {
         return (int)$this->__toString() > self::DEFAULT_STATE;
      }
   }

   $myVersionState = VersionState::cast($versionStateValue);
   if ($myVersionState->indicatesPlaceholder()) {
      echo 'The state indicates that this is a placeholder';
   }

..
