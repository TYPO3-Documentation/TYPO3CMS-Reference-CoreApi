.. include:: ../../Includes.txt

.. _content-element-wizard:

==========================================
Add Elements to the Content Element Wizard
==========================================

The content elements wizard is opened when a new element is
created.

The content element wizard can be fully configured using TSConfig.

.. seealso::

   :ref:`t3tsconfig:pagenewcontentelementwizard` in the TSconfig Reference
   provides an extensive description of the parameters use by :typoscript:`mod.wizards.newContentElement`

Our extension key is `example` and the name of the plugin is `registration`.

.. rst-class:: bignums-xxl

#. Create TSconfig

   :file:`Configuration/TsConfig/Page/Mod/Wizards/NewContentElement.tsconfig`:

   .. code-block:: typoscript

      mod.wizards {
          newContentElement.wizardItems {
              plugins {
                  elements {
                      example_registration {
                          iconIdentifier = example-registration
                          title = Registration Example
                          description = Create a registration form
                          tt_content_defValues {
                              CType = list
                              list_type = example_registration
                          }
                      }
                  }
              }
          }
      }



   You may want to replace title and description, using language files for translation:

   .. code-block:: typoscript

      title = LLL:EXT:example/Resources/Private/Language/locallang.xml:registration_title
      description = LLL:EXT:exapmle/Resources/Private/Language/locallang.xml:registration_description


#. Include TSconfig in ext_localconf.php

   .. code-block:: typoscript

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:example/Configuration/TsConfig/Page/Mod/Wizards/NewContentElement.tsconfig">'
        );

#. :ref:`Register your icon <icon-registration>` with the icon API

   In :file:`ext_localconf.php`:

   .. code-block:: php

      $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

      // use same identifier as used in TSconfig for icon
      $iconRegistry->registerIcon(
         // use same identifier as used in TSconfig for icon
         'example-registration',
         \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
         // font-awesome identifier ('external-link-square')
         ['name' => 'external-link-square']
      );

#. After clearing cache, create a new content element

   You should now see the icon, title and description you just added!

   .. figure:: ../../Images/ContentElementWizard.png
      :class: with-shadow

      Content Element Wizard with the new "Event Registration" plugin



.. seealso::

   * :ref:`t3tsconfig:pagenewcontentelementwizard` in TSconfig Reference
   * :ref:`Register your icon <icon-registration>` in TYPO3 Explained
   * `Creating Your Own Content Elements <https://docs.typo3.org/c/typo3/cms-fluid-styled-content/master/en-us/AddingYourOwnContentElements/Index.html>`__
     in fluid_styled_content documentation

Add Your Plugin to Different Tab
================================

The above example adds your plugin to the tab "Plugin" in the content element wizard.
You can add it to one of the other existing tabs or create a new one.

See `bootstrap_package <https://github.com/benjaminkott/bootstrap_package>`__
for example of creating a new tab "interactive" and adding
elements to it:

.. code-block:: typoscript

    mod.wizards.newContentElement.wizardItems {
        interactive.header = LLL:EXT:bootstrap_package/Resources/Private/Language/Backend.xlf:content_group.interactive
        interactive.elements {
            accordion {
                iconIdentifier = content-bootstrappackage-accordion
                title = LLL:EXT:bootstrap_package/Resources/Private/Language/Backend.xlf:content_element.accordion
                description = LLL:EXT:bootstrap_package/Resources/Private/Language/Backend.xlf:content_element.accordion.description
                tt_content_defValues {
                    CType = accordion
                }
            }
        }
    }
