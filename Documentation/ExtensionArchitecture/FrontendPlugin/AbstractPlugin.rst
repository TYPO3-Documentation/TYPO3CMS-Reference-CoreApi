.. include:: /Includes.rst.txt
.. index::
   pair: Extbase; AbstractPlugin

.. _abstractplugin:

==============
AbstractPlugin
==============

This class is used as base class for frontend plugins.

Most legacy frontend plugins are extension classes of this one.

This class contains functions which assists these plugins in creating lists,
searching, displaying menus, page-browsing (next/previous/1/2/3) and handling
links.

Functions are all prefixed :php:`pi_` which is reserved for this class. Those
functions can be overridden in the extension classes. Therefore plugins based
on the :php:`AbstractPlugin` are also called "pi-based plugins".

The :php:`AbstractPlugin` still contains hard-coded HTMl in many functions.
These can not be used for non-HTML output like JSON or XML feeds.

.. versionchanged:: 6.0
   The AbstractPlugin class used to be named :php:`tslib_pibase` before 
   TYPO3 6.0. Therefore the old names "pi_base" or "pi-based plugin" are 
   still used by some people for historic reasons. "pi" is short for
   plug-in.

TypoScript
==========

There is no predefined entry method, the method to be used as entry-point is
defined via TypoScript:

.. code-block:: typoscript
   :caption: EXT:sr_feuser_register/Configuration/TypoScript/PluginSetup/setup.typoscript

   plugin.tx_srfeuserregister_pi1 = USER_INT
   plugin.tx_srfeuserregister_pi1 {
      userFunc = SJBR\SrFeuserRegister\Controller\RegisterPluginController->main
      // set some options

      _DEFAULT_PI_VARS {
         // set some default values
      }
   }

You can use the TypoScript content objects :ref:`USER <t3tsref:cobj-user>` for
cached plugins or :ref:`USER_INT <t3tsref:cobj-user-int>` when caching should
be disabled.

The following keys are reserved when creating pi-based plugins:

:typoscript:`_DEFAULT_PI_VARS`
   Used to define default values that override values not set in the main
   TypoScript plugin definition.

:typoscript:`_LOCAL_LANG.<key>`
   Used to override translated strings.

AbstractPlugin implementation
=============================

An implementing class could look like this:

.. code-block:: php
   :caption: EXT:sr_feuser_register/Classes/Controller/RegisterPluginController.php

   <?php
   namespace SJBR\SrFeuserRegister\Controller;

   use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
   use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
   use TYPO3\CMS\Frontend\Plugin\AbstractPlugin;
   // ...

   class RegisterPluginController extends AbstractPlugin
   {
      /**
       * Content object
       *
       * @var ContentObjectRenderer
       */
      public $cObj;

      /**
       * Extension key
       *
       * @var string
       */
      public $extKey = 'sr_feuser_register';

      // ...

      /**
       * Plugin entry script
       *
       * @param string $content: rendered content (not used)
       * @param array $conf: the plugin TS configuration
       * @return string the rendered content
       */
      public function main($content, $conf)
      {
         $extensionName = GeneralUtility::underscoredToUpperCamelCase($this->extKey);
         $this->pi_setPiVarDefaults();
         $this->conf =& $conf;

         // do something

         return CssUtility::wrapInBaseClass($this->prefixId, $content);
      }
   }

See extension `sr_feuser_register <https://codeberg.org/sjbr/sr-feuser-register>`__
for a complete example.

TCA configuration
=================

.. code-block:: php
   :caption: EXT:sr_feuser_register/Configuration/TCA/Overrides/tt_content.php

   use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
   defined('TYPO3_MODE') or die();

   $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['sr_feuser_register_pi1'] = 'layout,select_key';
   $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['sr_feuser_register_pi1'] = 'pi_flexform';
   ExtensionManagementUtility::addPiFlexFormValue('sr_feuser_register_pi1', 'FILE:EXT:sr_feuser_register/Configuration/FlexForms/flexform_ds_pi1.xml');
   ExtensionManagementUtility::addPlugin(array('LLL:EXT:sr_feuser_register/Resources/Private/Language/locallang_db.xlf:tt_content.list_type', 'sr_feuser_register_pi1'), 'list_type', 'sr_feuser_register');
