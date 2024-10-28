..  include:: /Includes.rst.txt
..  index:: Enumerations; Usage
..  _Enumerations-How-to-use:

=======================
How to use enumerations
=======================

..  _Enumerations-Create-an-Enumeration:

Create an enumeration
=====================

To create a new enumeration you have to extend the class
:php:`\TYPO3\CMS\Core\Type\Enumeration`. Make sure your enumeration is marked as
:php:`final`, this ensures your code only receives a known set of values.
Otherwise adding more values by extension will lead to undefined behavior in
your code.

Values are defined as constants in your implementation. The names of the
constants must be given in uppercase.

A special, optional constant :php:`__default` represents the default value of
your enumeration, if it is present. In that case the enumeration can be
instantiated without a value and will be set to the default.

..  index:: Enumerations; Example

Example:

..  literalinclude:: _Enumerations/_LikeWildcard.php
    :language: php
    :caption: EXT:my_extension/Classes/Enumeration/LikeWildcard.php


..  _Enumerations-Use-an-Enumeration:

Use an enumeration
==================

You can create an instance of the :php:`Enumeration` class like you would
usually do, or you can use the :php:`Enumeration::cast()` method for
instantiation. The :php:`Enumeration::cast()` method can handle:

*   :php:`Enumeration` instances (where it will simply return the value) and
*   simple types with a valid :php:`Enumeration` value,

whereas the "normal" :php:`__construct()` will always try to create a new
instance.

That allows to deprecate enumeration values or do special value
casts before finding a suitable value in the enumeration.

Example:

..  literalinclude:: _Enumerations/_SomeClass.php
    :language: php
    :caption: EXT:my_extension/Classes/SomeClass.php


Exceptions
==========

If the enumeration is instantiated with an invalid value, a
:php:`\TYPO3\CMS\Core\Type\Exception\InvalidEnumerationValueException` is thrown.
This exception must be caught, and you have to decide what the appropriate
behavior should be.

..  attention::
    Always be prepared to handle exceptions when instantiating
    enumerations from user defined values!

Example:

..  literalinclude:: _Enumerations/_SomeClass2.php
    :language: php
    :caption: EXT:my_extension/Classes/SomeClass.php


..  _Enumerations-Implement-custom-logic:

Implement custom logic
======================

Sometimes it makes sense to not only validate a value, but also to
have custom logic as well.

For example, the :php:`\TYPO3\CMS\Core\Versioning\VersionState` enumeration
contains values of version states. Some of the values indicate that the state is
a "placeholder". This logic can be implemented by a custom method:

..  literalinclude:: _Enumerations/_VersionState.php
    :language: php
    :caption: EXT:core/Classes/Versioning/VersionState.php

The method can then be used in your class:

..  literalinclude:: _Enumerations/_SomeClass3.php
    :language: php
    :caption: EXT:my_extension/Classes/SomeClass.php
