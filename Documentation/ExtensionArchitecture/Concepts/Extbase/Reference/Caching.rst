.. include:: /Includes.rst.txt

.. index:: Extbase; Caching
.. _extbase_caching_of_actions_and_records:

==============================
Caching of actions and records
==============================

Furthermore, Extbase is clearing the TYPO3 cache automatically for update processes. This is called
*Automatic cache clearing*. This functionality is activated by default. If a domain object is
inserted, changed, or deleted, then the cache of the corresponding page in which the object is
located is cleared.  Additionally the setting
of TSConfig :ref:`TCEMAIN.clearCacheCmd <t3tsconfig:pagetcemain-clearcachecmd>` is evaluated for this page.

Figure B-2 is an example that is explained below:

.. figure::  /Images/ManualScreenshots/b-ExtbaseReference/figure-b-2.png
    :align: center

    Figure B-2: For the sysfolder in which the data was stored, the setting
    :ref:`TCEMAIN.clearCacheCmd <t3tsconfig:pagetcemain-clearcachecmd>` defines that the cache of
    the page *Blog* should be emptied.

The frontend plugin is on the page *Blog* with the *11*. As a storage folder for all the Blogs and
Posts the SysFolder *BLOGS* is configured. If an entry is changed, the cache of the SysFolder
*BLOGS* is emptied and also the TSConfig configuration
:ref:`TCEMAIN.clearCacheCmd <t3tsconfig:pagetcemain-clearcachecmd>` for the SysFolder is evaluated.
This contains a comma-separated list of Page IDs, for which the cache should be emptied. In this
case, when updating a record in the SysFolder *BLOGS* (e.g., Blogs, Posts, Comments), the cache of
the page *Blog*, with ID 11, is cleared automatically, so the changes are immediately visible.

Even if the user enters incorrect data in a form (and this form will be
displayed again), the cache of the current page is deleted to force a new
representation of the form.

The automatic cache clearing is enabled by default, you can use the TypoScript configuration
:ref:`persistence.enableAutomaticCacheClearing <persistence-enableAutomaticCacheClearing>` to disable
it.
