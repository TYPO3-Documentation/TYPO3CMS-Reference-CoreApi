:orphan:

.. _csh:

=======================================
Context sensitive help has been removed
=======================================

.. versionchanged:: 12.0
   The context sensitive help (CSH) has been removed.


Migration
=========

Important CSH texts need to be migrated to a TCA `description`, to
make the information available for all users.

An example for a TCA description is the `protected` column in the
`sys_redirect` TCA.

The TCA option `['interface']['always_description']` can be removed from
any TCA definition.
