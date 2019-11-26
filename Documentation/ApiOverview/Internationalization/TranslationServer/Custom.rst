.. include:: ../../../Includes.txt


.. _xliff-translating:

==========================
Custom Translation Servers
==========================

With the usage of XLIFF and the freely available `Pootle <http://pootle.translatehouse.org/>`__
translation server, companies and individuals may easily set up a custom translation server
for their extensions.

There is a signal that can be caught to change the translation server URL to use. The first
step is to register one's code for handling the signal. Such code would be placed in an
extension's :file:`ext_localconf.php` file:

.. code-block:: php

   $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
   $signalSlotDispatcher->connect(
      version_compare(TYPO3_version, '7.0', '<')
         ? 'TYPO3\\CMS\\Lang\\Service\\UpdateTranslationService'
         : 'TYPO3\\CMS\\Lang\\Service\\TranslationService',
      'postProcessMirrorUrl',
      'Company\\Extension\Slots\\CustomMirror',
      'postProcessMirrorUrl'
   );

The class (slot) which receives the signal (:file:`EXT:myext/Classes/Slots/CustomMirror.php`)
could look something like:

.. code-block:: php

   <?php
   namespace Company\Extensions\Slots;
   class CustomMirror {
      static protected $extKey = 'myext';

      public function postProcessMirrorUrl($extensionKey, &$mirrorUrl) {
         if ($extensionKey === self::$extKey) {
            $mirrorUrl = 'http://mycompany.tld/typo3-packages/';
         }
      }
   }

Note that the mirror URL is passed as a reference, so that it can be
modified. In the above example, the URL is changed only for a given
extension, but of course it could be changed on a more general basis.

On the custom translation server side, the structure needs to be:

.. code-block:: text

   https://mycompany.tld/typo3-packages/
   `-- <first-letter-of-extension-key>
      `-- <second-letter-of-extension-key>
         `-- <extension-key>-l10n
            |-- <extension-key>-l10n-de.zip
            |-- <extension-key>-l10n-fr.zip
            |-- <extension-key>-l10n-it.zip
            `-- <extension-key>-l10n.xml

hence in our example:

.. code-block:: text

   https://mycompany.tld/typo3-packages/
   `-- m
      `-- y
         `-- myext-l10n
            |-- myext-l10n-de.zip
            |-- myext-l10n-fr.zip
            |-- myext-l10n-it.zip
            `-- myext-l10n.xml

And the :file:`myext-l10n.xml` file contains something like:

.. code-block:: xml

   <?xml version="1.0" standalone="yes" ?>
   <TERlanguagePackIndex>
      <meta>
         <timestamp>1374841386</timestamp>
         <date>2013-07-26 14:23:06</date>
      </meta>
      <languagePackIndex>
         <languagepack language="de">
            <md5>1cc7046c3b624ba1fb1ef565343b84a1</md5>
         </languagepack>
         <languagepack language="fr">
            <md5>f00f73ae5c43cb68392e6c508b65de7a</md5>
         </languagepack>
         <languagepack language="it">
            <md5>cd59530ce1ee0a38e6309544be6bcb3d</md5>
         </languagepack>
      </languagePackIndex>
   </TERlanguagePackIndex>
