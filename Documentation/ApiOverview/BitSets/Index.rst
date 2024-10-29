..  include:: /Includes.rst.txt

..  index::
    PHP; Constants
    Deprecation; Constants
    ! Enumerations
    ! Bitsets
..  _Enumerations:

======================
Bitsets & Enumerations
======================

*   Use an enumeration, if you have a fixed list of values.
*   Use a bitset, if you have a list of boolean flags.

Do not use PHP constants directly, if your code is meant to be extendable,
as constants cannot be deprecated, but the values of an enumeration or
methods of a bitset can.

..  toctree::
    :titlesonly:

    Enumeration
    BitSet


Background and history
======================

Before version 8.1, PHP had no enumeration concept as part of the language.
Therefore the TYPO3 Core includes a custom enumeration implementation.

In TYPO3, enumerations are implemented by extending the abstract class
:php:`\TYPO3\CMS\Core\Type\Enumeration`. It was originally implemented similar
to :php:`\SplEnum` which is unfortunately part of the unmaintained package
`PECL spl_types`_.

With PHP version 8.1, an enumeration concept was implemented (see the
`Enumeration documentation`_ for more details). This makes it possible to drop
the custom enumeration concept from the Core in a future TYPO3 version.

..  _PECL spl_types: https://pecl.php.net/package/spl_types
..  _Enumeration documentation: https://www.php.net/manual/en/language.enumerations.php
