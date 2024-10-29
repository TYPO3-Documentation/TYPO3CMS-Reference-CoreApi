:orphan:

..  include:: /Includes.rst.txt
..  _Enumerations:
..  _Enumerations-How-to-use:

============
Enumerations
============

..  versionchanged:: 14.0
    The abstract class :php:`\TYPO3\CMS\Core\Type\Enumeration` was deprecated
    with TYPO3 v13.0 and removed with TYPO3 v14.0. Classes extending
    :php:`Enumeration` need to be converted into PHP built-in
    `backed enums <https://www.php.net/manual/en/language.enumerations.backed.php>`__.

Migration to backed enums
=========================

Class definition:

..  literalinclude:: _Enumerations/_StateExtendingEnumeration.php
    :language: php
    :caption: EXT:my_extension/Classes/Enumeration/State.php

should be converted into:

..  literalinclude:: _Enumerations/_StateBackedEnum.php
    :language: php
    :caption: EXT:my_extension/Classes/Enumeration/State.php

Existing method calls must be adapted.

..  seealso::
    *   `PHP: Backed enumerations <https://www.php.net/manual/en/language.enumerations.backed.php>`__
    *   :ref:`Enumerations in Extbase models <extbase-model-enumerations>`
