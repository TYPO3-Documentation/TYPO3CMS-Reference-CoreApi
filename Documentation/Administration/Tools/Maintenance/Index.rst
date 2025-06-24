:navigation-title: Maintenance

..  include:: /Includes.rst.txt
..  _admin-tools-maintenance:

=========================
Maintenance (Admin Tools)
=========================

Only available if :composer:`typo3/cms-install` is installed.

The backend module :guilabel:`Admin Tools > Maintenance` offers tools
to system maintainers that are necessary during development or updates.

Some of the tools available here include:

..  todo: describe the other tools

..  contents::

..  _admin-tools-maintenance-flush-cache:

Flush TYPO3 and PHP Cache
=========================

By clicking the button :guilabel:`Flush cache` you can flush all caches. This is
necessary during development if you changed files like
:ref:`Fluid templates <fluid-templates>`, :ref:`TypoScript files <typoscript>`,
or PHP files.

It is also necessary to flush caches after installing or updating extensions.

You can achieve the same effect by calling

..  code-block:: bash

    ddev typo3 cache: flush

..  note::
    Flushing the cache via the "Clear cache" buttons in the
    Top Bar does not have the same effect. It does not flush
    PHP related caches.

..  _admin-tools-maintenance-database-analyzer:

Analyze Database Structure
==========================

Aside its name this tool does not only analyze the database structure but also
offers to fix it for you.

Database changes can be necessary when TCA files where changed or
extensions installed / updated.

..  _admin-tools-maintenance-create-admin:

Create Administrative User
==========================

This tool can be used to create a new administrative backend user with or
without maintainer privileges.

You can also create a new backend user from the console:

..  code-block:: bash

    ddev typo3 backend:user:create

and from the module :guilabel:`System > Backend Users`. The latter cannot
grant system maintainer rights but is available to all admins.
