.. include:: ../../Includes.txt


.. _configuration-methods:

==========================
Configuration Methods
==========================

These are the main configuration methods used by TYPO3:

The :php:`$GLOBALS` array consists:

* Global Configuration :php:`$GLOBALS['TYPO3_CONF_VARS']`
  is used for system wide configuration. A subset of this is
  :ref:`Extension Configuration <extension-options>`
  (:php:`$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']`). It is used for
  configuration specific to one extension.
* :ref:`TCA <t3tca:introduction>` :php:`GLOBALS['TCA']` is specific to
  database fields and how they behave and can be edited in the backend.
* :ref:`User settings <user-settings>` :php:`$GLOBALS['TYPO3_USER_SETTINGS']`
  defines configuration for backend users
* ... you can find more in the TYPO3 backend :guilabel:`SYSTEM > Configuration`
  or by viewing the :php:`$GLOBALS` array in a debugger. Read more about this
  on :ref:`globals-variables`.


Furthermore, we have:

* :ref:`TSconfig <tsconfig>` is used to configure and **customize the backend** on a page (page TSconfig)
  and a user or group basis (user TSconfig).
* :ref:`TypoScript configuration method <t3tsref:introduction>` is used to
  configure plugins (FE) and modules (BE), as well as some
  global settings (config). It is also used to define the rendering, but that is
  beyond the scope of this page, which focuses only on configuration. TypoScript
  is mostly used for configuration that affects the Frontend (FE).
* :ref:`Flexform <flexforms>` is used to configure plugins and content elements.


.. toctree::
   :maxdepth: 1

   ../GlobalValues/Constants/Index
   Extension Configuration ➜ <https://docs.typo3.org/m/typo3/reference-coreapi/7.6/en-us/ExtensionArchitecture/ConfigurationOptions/Index.html>
   ../FlexForms/Index
   Form configuration ➜ <https://docs.typo3.org/c/typo3/cms-form/7.6/en-us/I/Concepts/Configuration/Index.html#concepts-configuration>
   ../GlobalValues/GlobalVariables/Index
   rte_ckeditor configuration ➜  <https://docs.typo3.org/c/typo3/cms-rte-ckeditor/7.6/en-us/Configuration/Index.html#configuration>
   TCA ➜ <https://docs.typo3.org/m/typo3/reference-tca/7.6/en-us/Introduction/Index.html>
   ../Tsconfig/Index
   TypoScript Templates ➜ <https://docs.typo3.org/m/typo3/reference-typoscript/7.6/en-us/>
   ../../UserSettingsConfiguration/Index

