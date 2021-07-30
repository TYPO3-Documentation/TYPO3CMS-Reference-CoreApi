.. include:: /Includes.rst.txt
.. index::
   TCA; Verification
   Module; Configuration
.. _verifying:

=================
Verifying the TCA
=================
You may find it necessary – at some point – to verify the full
structure of the :php:`$GLOBALS['TCA']` in your TYPO3 installation. The **SYSTEM >
Configuration** module makes it possible to have an overview of the
complete :php:`$GLOBALS['TCA']`, with all customizations taken into account.

.. note:: The **Configuration** module is part of the lowlevel system extension. In composer mode
   you can install it with::

      composer req typo3/cms-lowlevel

.. figure:: /Images/ManualScreenshots/ExtensionArchitecture/ExtendingTca/VerifyingTca.png
   :alt: The Configuration module

   Checking the existence of the new field via the Configuration module

If you cannot find your new field, it probably means that you have
made some mistake.

This view is also useful when trying to find out where to insert a new
field, to explore the combination of types and palettes that may be
used for the table that we want to extend.

