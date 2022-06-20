.. include:: /Includes.rst.txt
.. index::
   TCA; Verification
   Module; Configuration
.. _verifying:

=================
Verifying the TCA
=================
You may find it necessary – at some point – to verify the full
structure of the :php:`$GLOBALS['TCA']` in your TYPO3 installation.
The :guilabel:`System > Configuration` module makes it possible to have an overview of the
complete :php:`$GLOBALS['TCA']`, with all customizations taken into account.

.. note:: The :guilabel:`Configuration` module is part of the lowlevel system extension. In Composer mode
   you can install it with:

   .. code-block:: shell

      composer req typo3/cms-lowlevel

.. include:: /Images/AutomaticScreenshots/ExtendingTca/VerifyingTca.rst.txt

If you cannot find your new field, it probably means that you have
made some mistake.

This view is also useful when trying to find out where to insert a new
field, to explore the combination of types and palettes that may be
used for the table that we want to extend.

