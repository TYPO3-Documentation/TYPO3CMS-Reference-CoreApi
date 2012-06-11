

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Using the system registry
-------------------------

The purpose of the registry (introduced in TYPO3 4.3) is to hold key-
value pairs of information. You can actually think of it being an
equivalent to the Windows registry (just not as complicated).

You might use the registry to store information that your script needs
to store across sessions or request.

An example would be a setting that needs to be altered by a PHP
script, which currently is not possible with TypoScript.

Another example: The scheduler system extension stores when it ran the
last time. The reports system extension then checks that value, in
case it determines that the scheduler hasn't run for a while it issues
a warning. While this might not be of great use to anyone with an
actual cron job set up for the scheduler, it is of use for users that
have to run the scheduler tasks by hand due to missing access to a
cron job.

The registry is not meant to store things that are supposed to go into
a session or a cache, use the appropriate API for these instead.


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   TheRegistryTable(sysRegistry)/Index
   TheRegistryApi/Index

