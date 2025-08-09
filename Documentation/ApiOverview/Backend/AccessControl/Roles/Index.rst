.. include:: /Includes.rst.txt
.. index:: pair: Backend; Roles

.. _access-control-roles:

=====
Roles
=====

Another popular approach to setting up users is roles. This
concept is basically about identifying certain roles that users can
take and then allow for a very easy application of these roles to
users.

TYPO3 access control is far more flexible and allows for such detailed
configuration that it lies very far from the simple and straight
forward concept of roles. This is necessary as the foundation of a
system like TYPO3 should fit many possible usages.

However it is perfectly possible to create groups that act like "roles".
This is what you should do:

#. Identify the roles you need; Developer, Administrator, Editor, Super
   User, User, ... etc.

#. Configure a group for each role: attribute permissions needed to
   fulfill each role.

#. Consider having a general group which all other groups include - this
   would basically configure a shared set of permissions for all users.
