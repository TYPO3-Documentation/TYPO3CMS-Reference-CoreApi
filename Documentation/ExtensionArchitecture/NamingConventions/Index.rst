.. include:: ../../Includes.txt


.. _extension-naming:

Naming conventions
^^^^^^^^^^^^^^^^^^

Based on the extension key of an extension these naming conventions
should be followed:


Abbreviations
   | TER = TYPO3 extension repository
   | *extkey* = extension key
   | *modkey* = backend module key


Public extensions
   1. Public extensions are available from the TER_ or via Packagist_. Private
      extensions are not published to the TER or Packagist.

   2. The *extkey* is made up of lowercase alphanumeric characters and underscores only
      and should start with a letter.

      **Example:** cool\_shop

   3. The *extkey* is valid if the TER accepts it. This makes sure that the
      name follows the rules and is unique.

   4. Database tablenames should be named `tx_` + *extkey* (without underscores) +
      `_specification`.

      **Examples:** tx\_coolshop\_products, tx\_coolshop\_categories,
      tx\_coolshop\_more\_categories, tx\_coolshop\_domain\_model\_tag.

Backend modules
   1. The *modkey* is made up of alphanumeric characters only. It does not
      contain underscores and starts with a letter.

      **Example:** coolshop

Frontend PHP classes
   For frontend PHP classes, follow the same conventions as for database tables
   and fields.

You may also want to refer to the TYPO3 :ref:`cgl` for
more on general naming conventions in TYPO3.

.. tip::
   If you study the naming conventions above closely you will find that
   they are complicated due to varying rules for underscores in key
   names. Sometimes the underscores are stripped off, sometimes not.

   The best practice you can follow is to  *avoid using underscores* in
   your extensions keys at all! That will make the rules simpler. This is
   highly encouraged.

.. _extension-old-extensions:

Note on "old" extensions:
"""""""""""""""""""""""""

Some the "classic" extensions from before the extension structure came
about do not comply with these naming conventions. That is an
exception made for backwards compatibility. The assignment of new keys
from the TYPO3 Extension Repository will make sure that any of these
old names are not accidentally reassigned to new extensions.

Further, some of the classic plugins (tt\_board, tt\_guest etc) use
the "user\_" prefix for their classes as well.

.. _extension-extending:

Extending "extensions classes"
""""""""""""""""""""""""""""""

As a standard procedure you should include the "class extension code"
even in your own extensions. This is placed at the bottom of every
class file:

.. code-block:: php

   if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/myext/pi1/class.tx_myext_pi1.php'])) {
           include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/myext/pi1/class.tx_myext_pi1.php']);
   }


Normally the key used as example here ("ext/myext/pi1/class.tx_myext_pi1.php")
would be the full path to the script relative to :php:`\TYPO3\CMS\Core\Core\Environment::getPublicPath()`. However because modules are required to work from both
:code:`typo3/sysext/` *and* :code:`typo3conf/ext/` it is a policy that any
path before "ext/" is omitted.


.. _TER: https://extensions.typo3.org/
.. _Packagist: https://packagist.org/
