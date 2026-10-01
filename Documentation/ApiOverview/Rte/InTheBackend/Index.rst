:navigation-title: Backend

..  include:: /Includes.rst.txt
..  _rte-backend:
..  _rte-backend-introduction:

======================================
Rich text editors in the TYPO3 backend
======================================

..  toctree::
    :hidden:

    PlugRte

When you configure a table in :php:`$GLOBALS['TCA']` and add a field of the
type `text`, which is edited by a :html:`<textarea>`, you can choose to use a
rich text editor (RTE) instead of the simple form field. An RTE enables
editors to use visual formatting aids to create bold and italic text,
paragraphs, tables and more.

..  figure:: /Images/ManualScreenshots/Rte/RteBackend.png
    :zoom: lightbox

    The rtehtmlarea RTE activated in the TYPO3 backend

For full details about setting up a field to use an RTE, please refer to the
chapter labeled 'special-configuration-options' in older versions of the
TCA Reference.

The short story is that it's enough to set the key `enableRichtext` to true.

..  literalinclude:: _tca-rte.php
    :emphasize-lines: 11
    :caption: packages/my_extension/Configuration/TCA/tx_myextension_table.php

This works for FlexForms too:

..  literalinclude:: _FlexForm.xml
    :emphasize-lines: 5
    :caption: packages/my_extension/Configuration/FlexForms/MyPlugin.php

..  hint::

    If the Rich Text Editor is not displayed, it might be turned off in
    :guilabel:`User Settings > Edit and Advanced functions > Enable Rich Text Editor`.
