.. include:: ../../Includes.txt






.. _enumerations:

Enumerations
------------

Since version 6.2, TYPO3 CMS provides an Enumeration implementation.
Enumeration should be used if you have a fixed list of values and they
should always be prefered of constants. That is because constants can't
be deprecated but values of a enumeartion can.


.. _enumerations-using:

Using Enumerations
^^^^^^^^^^^^^^^^


.. _enumreations-create:

Create an Enumeration
"""""""""""""""""""""

To create a new Enumeration you have to extend the class :code:`TYPO3\CMS\Core\Type\Enumeration`.
Values are defined via constants in your implementation. 
The names of the constants must be in uppercase.

There is a special constant :code:`__default` that could have the default value of your enumeration.
If the default is set the Enumeration can be instantiated without a value and will get the
value defined as default.

.. code-block:: php

  class LikeWildcard extends \TYPO3\CMS\Core\Type\Enumeration
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
 
.. _enumerations-use:

Use an Enumeration
""""""""""""""""""

If you would like to use an Enumeration you must instantiate it always
via the :code:`Enumeration::cast()` method.

The :code:`::cast()` itself calls the constructor of the enumeration if it's
not always an instance of the enum.

That is required to deprecate values of the enumeration or do special value
casts before trying to find a suitable value in the enumeration.


.. code-block:: php
  
  $likeWildcardLeft = LikeWildcard::cast(LikeWildcard::LEFT);
  
  $valueFromDatabase = 1;
  $likeWildcardLeft->equals($valueFromDatabase); // will cast the value automatically
                                                 // to an Enumeration. Result is true.
 
  $enumeationWithValueFromDb = LikeWildcard::cast($valueFromDatabase);
  // Remember to always use ::cast and never use the constant directly
  $enumeationWithValueFromDb->equals(LikeWildcard::cast(LikeWildcard::RIGHT));
  
.. important::
If you use an Enumeration and instantiate it with a value defined by a user you
must handle possible exceptions.

If the Enumeration is instantiated with an invalid value an 
:code:`TYPO3\CMS\Core\Type\Exception\InvalidEnumerationValueException` is thrown.
This Exception must be catched and you have to decide what the default behavior sould
be.


.. code-block:: php
  
  try {
    $foo = LikeWildcard::cast($valueFromPageTs);
  } catch (\TYPO3\CMS\Core\Type\Exception\InvalidEnumerationValueException) {
    $foo = LikeWildcard::cast(LikeWildcard::NONE);
  }
  
  
.. _enumerations-custom-logic:

Implement custom logic
""""""""""""""""""""""

Sometimes it does not just make sense to validate a value but to also add custom
logic.

For example the :code:`TYPO3\CMS\Core\Versioning\VersionState` enumeration contains
values of version states. Some of there values indicate that the state is a "placeholder".
This logic is implemented by a custom method.

.. code-block:: php

  class VersionState extends \TYPO3\CMS\Core\Type\Enumeration
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
  
  
