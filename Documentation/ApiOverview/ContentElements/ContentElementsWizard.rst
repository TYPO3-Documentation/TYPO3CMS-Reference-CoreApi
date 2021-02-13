.. include:: /Includes.rst.txt
.. index:: pair: Add; Content elements
.. _content-element-wizard:

==================================================
Add content elements to the Content Element Wizard
==================================================

The content elements wizard is opened when a new content element is
created.

The content element wizard can be fully configured using TSConfig.

Our extension key is `example` and the name of the content element or
plugin is `registration`.

.. rst-class:: bignums-xxl

#. Create page TSconfig

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

   You may want to replace title and description, using language files for translation, for example:

   .. code-block:: typoscript

      title = LLL:EXT:example/Resources/Private/Language/locallang.xml:registration_title
      description = LLL:EXT:example/Resources/Private/Language/locallang.xml:registration_description

#. Include TSconfig

   :file:`ext_localconf.php`:

   .. code-block:: typoscript

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:example/Configuration/TsConfig/Page/Mod/Wizards/NewContentElement.tsconfig">'
        );

   This always includes the above page TSconfig. It is better practice to make this configurable by
   :ref:`registering the file as static page TSconfig <t3tsconfig:pagesettingstaticpagetsconfigfiles>`:


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

   .. figure:: Images/ContentElementWizard.png
      :class: with-shadow

      Content Element Wizard with the new "Event Registration" plugin

.. seealso::

   * :ref:`t3tsconfig:pagenewcontentelementwizard` in TSconfig Reference
   * :ref:`Register your icon <icon-registration>` in TYPO3 Explained
   * :ref:`adding-your-own-content-elements`


Add your plugin or CE to different tab
======================================

The above example adds your plugin to the tab "Plugin" in the content element wizard.
You can add it to one of the other existing tabs or create a new one.

.. tip::

   Look in the :guilabel:`Info` module > :guilabel:`page TSconfig` for existing
   configuration of ``mod.wizards.newContentElement.wizardItems``.


If you add it to any of the other tabs (other than plugins), you must add
the name to ``show`` as well:

.. code-block:: typoscript

   mod.wizards.newContentElement.wizardItems.common {
       elements {
           example_registration {
               iconIdentifier = example-registration
               title = Example title
               description = Example description
               tt_content_defValues {
                   CType = list
                   list_type = example_registration
               }
           }
       }
       show := addToList(example_registration)
   }

* When you look at existing page TSconfig in the :guilabel:`Info` module, you may
  notice that ``show`` has been set to include all for the "plugins" tab:

.. code-block:: typoscript

   show = *


Create a new tab
================

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
