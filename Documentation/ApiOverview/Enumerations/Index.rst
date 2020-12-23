
.. include:: /Includes.rst.txt
.. index::
   PHP; Constants
   Deprecation; Constants
   ! Enumerations
   ! Bitsets
.. _Enumerations:

======================
Enumerations & BitSets
======================

- Use an enumeration if you have a fixed list of values.
- Use a bitset if you have a list of boolean flags.

Do not use PHP constants directly if your code is meant to be extendable,
as constants cannot be deprecated, but the values of an enumeration or
methods of a BitSet can.

.. toctree::
   :titlesonly:

   Enumeration
   BitSet


Background and history
======================

PHP has no enumeration concept as part of the language up to date. Therefore
the `TYPO3 Core`:pn: includes a custom enumeration implementation.

In TYPO3 enumerations are implemented by extending the abstract class
:php:`TYPO3\CMS\Core\Type\Enumeration`. It was originally implemented similar to
`SplEnum <https://www.php.net/manual/en/class.splenum.php>`__ which is
unfortunately part of the unmaintained package
`PECL spl_types <https://pecl.php.net/package/spl_types>`__.

It was proposed to include an enumeration concept in future versions of PHP (see
`Enumeration proposal in PHP <https://wiki.php.net/rfc/enumerations>`__) this
might make it possible to drop the concept from the `Core`:pn:.
