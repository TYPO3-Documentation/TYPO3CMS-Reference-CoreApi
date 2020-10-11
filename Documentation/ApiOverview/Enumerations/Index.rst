
.. include:: ../../Includes.txt

.. _Enumerations:

======================
Enumerations & BitSets
======================

- Use an enumeration if you have a fixed list of values.
- Use a BitSet if you have a list of boolean flags.

Do not use PHP constants directly if your code is meant to be extendable,
as constants cannot be deprecated, but the values of an enumeration or
methods of a BitSet can.

.. toctree::
   :titlesonly:

   Enumeration
   BitSet
