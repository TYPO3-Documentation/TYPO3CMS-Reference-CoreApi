..  include:: /Includes.rst.txt
..  index::
    TCA; Verification
    Module; Configuration
..  _verifying:

=================
Verifying the TCA
=================
At some point it may be necessary to check the overall structure of
:php:`$GLOBALS['TCA']` in your TYPO3 installation.
The :guilabel:`System > Configuration` module gives you an overview of the
complete :php:`$GLOBALS['TCA']`, with all modifications taken into account.

..  note::
     The :guilabel:`Configuration` module is part of the lowlevel system extension. In Composer mode you can install it with:

    ..  code-block:: shell

        composer req typo3/cms-lowlevel

..  figure:: /Images/AutomaticScreenshots/ExtendingTca/VerifyingTca.png
    :zoom: lightbox

    Searching the TCA for the field `tx_themecamino_logo`, which the Camino
    theme adds to the table `pages`

If you can't find your new field it probably means that you have
made a mistake somewhere.

The :guilabel:`System > Configuration` module overview is generally useful when you are extending TCA to find out where to insert
fields and which types and palettes are used for a particular table.
