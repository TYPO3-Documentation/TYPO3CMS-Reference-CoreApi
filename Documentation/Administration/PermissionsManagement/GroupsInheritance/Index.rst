.. include:: /Includes.rst.txt

.. index:: backend, acl, permissions, user groups, user management

.. _groups-inheritance:

==================
Groups inheritance
==================

Even though TYPO3 does not limit the depth of backend user group inheritance,
it's advisable to avoid complex setups. Typically, 1 or 2 levels of inheritance
should suffice. Such flat structures offer significant advantages over more complex,
deeper inheritances, including easier maintenance, updates, and verification
of the sources of specific permissions.

..  uml:: _simple-groups-inheritance.plantuml
    :align: center
    :caption: Backend groups hierarchy with 2 levels of inheritance
    :width: 700

.. note::
    Avoid complex inheritance within backend user groups. One or two levels of inheritance should suffice and make permissions easier to maintain.
