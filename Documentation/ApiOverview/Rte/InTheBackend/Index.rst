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

When you configure a table in :php:`$TCA` and add a field of the type `text`
you can configure

.. include:: /Images/AutomaticScreenshots/Rte/RteBackend.rst.txt

For full details about setting up a field to use an RTE, please refer to the
chapter labeled 'special-configuration-options' in older versions of the
TCA Reference.

The short story is that it's enough to set the key :code:`enableRichtext` to true.

..  literalinclude:: _tca-rte.php
    :emphasize-lines: 11
    :caption: packages/my_extension/Configuration/TCA/tx_myextension_table.php

This works for FlexForms too:

..  literalinclude:: _FlexForm.xml
    :emphasize-lines: 5
    :caption: packages/my_extension/Configuration/FlexForms/MyPlugin.php

..  hint::

    If the Rich Text Editor is not displayed, it might be turned off in
    :guilabel:`User Settings > Edit and Advanced functions > Enable Rich Text Editor`
