.. include:: ../../Includes.txt


.. _cgl-hooknaming:

Hook Naming
^^^^^^^^^^^

When introducing new hooks in TYPO3 the naming of the registration arrays shall follow this schema:

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['<topic>']['<hook name>'] = [] // array of callables or Foo:class->function


Note that `topic` shall be an abstract thing like 'link' or 'url' and should not reflect the class or file the hook
is currently implemented in. This should prevent irritation when hooks are moved around in the code.
