.. include:: /Includes.rst.txt

.. index:: Extbase; Caching
.. _extbase_caching:

==============================
Caching
==============================

Extbase clears the TYPO3 cache automatically for update processes. This is called
*Automatic cache clearing*. This functionality is activated by default. If a domain object is
inserted, changed, or deleted, then the cache of the corresponding page in which the object is
located is cleared.  Additionally the setting
of TSConfig :ref:`TCEMAIN.clearCacheCmd <t3tsref:pagetcemain-clearcachecmd>` is evaluated for this page.

The frontend plugin is on the page *Blog* with *uid=11*. As a storage folder for all the Blogs and
Posts the SysFolder *BLOGS* is configured. If an entry is changed, the cache of the SysFolder
*BLOGS* is emptied and also the TSConfig configuration
:ref:`TCEMAIN.clearCacheCmd <t3tsref:pagetcemain-clearcachecmd>` for the SysFolder is evaluated.
This contains a comma-separated list of Page IDs, for which the cache should be emptied. In this
case, when updating a record in the SysFolder *BLOGS* (e.g., Blogs, Posts, Comments), the cache of
the page *Blog*, with uid=11, is cleared automatically, so the changes are immediately visible.

Even if the user enters incorrect data in a form (and this form will be
displayed again), the cache of the current page is deleted to force a new
representation of the form.

The automatic cache clearing is enabled by default, you can use the TypoScript configuration
:ref:`persistence.enableAutomaticCacheClearing <t3tsref:extbase_persistence-enableAutomaticCacheClearing>` to disable
it.
