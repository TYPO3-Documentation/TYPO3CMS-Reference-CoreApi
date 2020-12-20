.. include:: /Includes.rst.txt

.. highlight:: php
.. index:: ! Locking
.. _locking-api:

===========
Locking API
===========

TYPO3 uses the locking API in the core. You can do the same in your extension
for operations which require locking. This is the case if you use a resource,
where concurrent access can be a problem. For example if you are getting a
cache entry, while another process sets the same entry. This may
result in incomplete or corrupt data, if locking is not used.

.. important::

   The :ref:`TYPO3 Caching Framework <caching>` does not use locking internally.
   If you use the Caching Framework to cache entries in your extension, you may
   want to use the locking API as well.


.. index:: Locking; Strategy

Locking strategies
==================

A locking strategy must implement the :php:`LockingStrategyInterface`. Several locking strategies
are shipped with the core. If a locking strategy uses a mechanism
or function, that is not available on your system, TYPO3 will automatically detect this and
not use this mechanism and respective locking strategy (e.g. if function :php:`sem_get()` is not
available, :php:`SemaphoreLockStrategy` will not be used).

* **FileLockStrategy**: uses the PHP function `flock() <http://php.net/manual/en/function.flock.php>`__
  and creates a file in `typo3temp/var/lock`
  The directory can be overwritten by configuration::

     // The directory specified here must exist und must be a subdirectory of `Environment::getProjectPath()`
     $GLOBALS['TYPO3_CONF_VARS']['SYS']['locking']['strategies'][\TYPO3\CMS\Core\Locking\FileLockStrategy::class]['lockFileDir'] = 'mylockdir';

* **SemaphoreLockStrategy**: uses the PHP function `sem_get()
  <http://php.net/manual/en/function.sem-get.php>`__
* **SimpleLockStrategy** is a simple method of file locking. It also uses the folder
  `typo3temp/var/lock`.

Extensions can add a locking strategy by providing a class which
implements the LockingStrategyInterface.

If a function requires a lock, the locking API is asked for the best fitting mechanism matching
the requested capabilities. This is done by a combination of:

capabilities
   The capability of the locking strategy and the requested capability must
   match (e.g. if you need a non-blocking lock, only the locking strategies that support
   acquiring a lock without blocking are available for this lock).
priority
   Each locking strategy assigns itself a priority. If more than one strategy is available
   for a specific capability (e.g. exclusive lock), the one with the highest priority is chosen.
locking strategy supported on system
   Some locking strategies do basic checks, e.g. semaphore locking is only available
   on Linux systems.

.. index::
   Locking; Capabilities
   Locking; LOCK_CAPABILITY_NOBLOCK
   Locking; LOCK_CAPABILITY_EXCLUSIVE
   Locking; LOCK_CAPABILITY_SHARED

Capabilities
------------

These are the current capabilities, that can be used (see `LockingStrategyInterface
<https://github.com/TYPO3/TYPO3.CMS/blob/master/typo3/sysext/core/Classes/Locking/LockingStrategyInterface.php>`__):

In general, the concept of locking, using shared or exclusive + blocking or non-blocking
locks is not TYPO3-specific. You can find more resources under :ref:`locking-api-more-info`.


LOCK_CAPABILITY_EXCLUSIVE
   A lock can only be acquired exclusively once and is then locked (in use). If another
   process or thread tries to acquire the same lock, it will:

   * If locking strategy **without** `LOCK_CAPABILITY_NOBLOCK` is used either:

     * block or
     * throw :php:`LockAcquireException`, if the lock could not be acquired - even with blocking

   * If locking strategy **with** `LOCK_CAPABILITY_NOBLOCK` is used, this should not block and do either:

     * return false or
     * throw :php:`LockAcquireWouldBlockException`, if trying to acquire lock would block
     * throw :php:`LockAcquireException`, if the lock could not be acquired

LOCK_CAPABILITY_SHARED
   A lock can be acquired by multiple processes, if it has this capability and the lock is
   acquired with `LOCK_CAPABILITY_SHARED`. The lock cannot be acquired shared, if it has
   already been acquired exclusively, until the exclusive lock is released.


LOCK_CAPABILITY_NOBLOCK
   If a locking strategy includes this as capability, it should be capable of acquiring
   a lock without blocking. The function :php:`acquire()` can pass the non-blocking requirement
   by adding `LOCK_CAPABILITY_NOBLOCK` to the first argument $mode.

You can use bitwise `OR` to combine them::

   $capabilities = LockingStrategyInterface::LOCK_CAPABILITY_EXCLUSIVE
       | LockingStrategyInterface::LOCK_CAPABILITY_SHARED
       | LockingStrategyInterface::LOCK_CAPABILITY_NOBLOCK


.. index::
   Locking; Priorities
   Locking; FileLockStrategy
   Locking; SimpleLockStrategy
   Locking; SemaphoreLockStrategy

Priorities
----------

Every locking strategy must have a priority. This is returned by the function
:php:`LockingStrategyInterface::getPriority()` which must be implemented in each
locking strategy.

Currently, these are the priorities of the locking strategies supplied by the core:

* FileLockStrategy: 75
* SimpleLockStrategy: 50
* SemaphoreLockStrategy: 25

To change the locking strategy priority, the priority can be overwritten by configuration,
for example in additional configuration::

   $GLOBALS['TYPO3_CONF_VARS']['SYS']['locking']['strategies'][\TYPO3\CMS\Core\Locking\FileLockStrategy::class]['priority'] = 10;

Examples
--------

Acquire and use an exclusive, blocking lock::

   $lockFactory = GeneralUtility::makeInstance(LockFactory::class);

   // createLocker will return an instance of class which implements
   // LockingStrategyInterface, according to required capabilities.
   // Here, we are asking for an exclusive, blocking lock. This is the default,
   // so the second parameter could be omitted.
   $locker = $lockFactory->createLocker('someId', LockingStrategyInterface::LOCK_CAPABILITY_EXCLUSIVE);

   // now use the locker to lock something exclusively, this may block (wait) until lock is free, if it
   // has been used already
   if ($locker->acquire(LockingStrategyInterface::LOCK_CAPABILITY_EXCLUSIVE)) {
       // do some work that required exclusive locking here ...

       // after you did your stuff, you must release
       $locker->release();
   }


Acquire and use an exclusive, non-blocking lock::

   $lockFactory = GeneralUtility::makeInstance(LockFactory::class);

   // get lock strategy that supports exclusive, shared and non-blocking
   $locker = $lockFactory->createLocker('id',
       LockingStrategyInterface::LOCK_CAPABILITY_EXCLUSIVE | LockingStrategyInterface::LOCK_CAPABILITY_NOBLOCK);

   // now use the locker to lock something exclusively, this will not block, so handle retry / abort yourself,
   // e.g. by using a loop
   if ($locker->acquire(LockingStrategyInterface::LOCK_CAPABILITY_EXCLUSIVE)) {
       // ... some work to be done that requires locking

       // after you did your stuff, you must release
       $locker->release();
   }


.. index::  pair: Locking; Core

Usage in the Core
=================

The locking API is used in the core for caching, see :php:`TypoScriptFrontendController`.


.. index::  pair: Locking; Extensions

.. _use-locking-api-in-extensions:

Extend locking in Extensions
============================

An extension can extend the locking functionality by adding a new locking
strategy. This can be done by writing a new class which implements the
`LockingStrategyInterface
<https://github.com/TYPO3/TYPO3.CMS/blob/master/typo3/sysext/core/Classes/Locking/LockingStrategyInterface.php>`__.

Each locking strategy has a set of capabilities (getCapabilities()), and a
priority (getPriority()), so give your strategy a priority higher than 75
if it should override the current top choice :php:`FileLockStrategy` by default.

If you want to release your file locking strategy extension, make sure to make the priority configurable,
as is done in the TYPO3 core::

   public static function getPriority()
   {
       return $GLOBALS['TYPO3_CONF_VARS']['SYS']['locking']['strategies'][self::class]['priority']
           ?? self::DEFAULT_PRIORITY;
   }

See `FileLockStrategy
<https://github.com/TYPO3/TYPO3.CMS/blob/master/typo3/sysext/core/Classes/Locking/FileLockStrategy.php>`__
for an example.


.. index:: Locking; Caveats
.. _locking-api-caveats:

Caveats
=======


.. index:: Locking; FileLockStrategy & NFS

FileLockStrategy & NFS
----------------------

There is a problem with PHP `flock()
<http://php.net/manual/en/function.flock.php>`__ on NFS systems.
This problem may or may not affect you, if you use NFS. See this
issue for more information

* `Forge Issue: FileLockStrategy fails on NFS folders <https://forge.typo3.org/issues/72074>`__

or check if PHP flock works on your filesystem.

The FileLockStrategy uses :php:`flock()`. This will create a file in `typo3temp/var/lock`.

Because of its capabilities (`LOCK_CAPABILITY_EXCLUSIVE`, `LOCK_CAPABILITY_SHARED`
and `LOCK_CAPABILITY_NOBLOCK`) and priority (75), FileLockStrategy is used as
first choice for most locking operations in TYPO3.


.. index:: Locking; Multiple servers

Multiple servers & Cache locking
--------------------------------

Since the core uses the locking API for some cache operations (see for
example :php:`TypoScriptFrontendController`), make sure that you correctly
setup your caching and locking if you share your TYPO3 instance on multiple
servers for load balancing or high availability.

Specifically, this may be a problem:

* **Do not** use a local locking mechanism (e.g. semaphores or file locks
  in `typo3temp/var`, *if* `typo3temp/var` is mapped to local storage and
  not shared) in combination with a central cache mechanism (e.g. central Redis
  or DB used for page caching in TYPO3)

.. _locking-api-more-info:

Related Information
===================

Some of these resources are for specific systems. We link to these, if the
general concepts are explained quite well. Not everything will apply to
locking in TYPO3 though.

If you do find better resources, feel free to make changes or add to this list!

* `Stackoverflow: What's the difference between an exclusive lock and a shared lock?
  <https://stackoverflow.com/q/11837428/2444812>`__
* `Wikipedia: Readers-writers problem <https://en.wikipedia.org/wiki/Readers%E2%80%93writers_problem>`__
* `Wikipedia: Readers–writer lock <https://en.wikipedia.org/wiki/Readers%E2%80%93writer_lock>`__
* Exlains shared / exclusive locks `IBM CICS Transaction Server: Exclusive locks and shared locks
  <https://www.ibm.com/support/knowledgecenter/SSGMGV_3.2.0/com.ibm.cics.ts.applicationprogramming.doc/topics/dfhp39o.html>`__
* `Oracle JE: Locks, Blocks and Deadlocks <https://docs.oracle.com/cd/E17277_02/html/TransactionGettingStarted/blocking_deadlocks.html>`__

