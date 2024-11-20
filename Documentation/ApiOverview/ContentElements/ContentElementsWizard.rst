.. include:: /Includes.rst.txt
.. index:: pair: Add; Content elements
.. _content-element-wizard:

==================================================
Add content elements to the Content Element Wizard
==================================================

The content element wizard opens when a new content element is
created. It can be fully configured using ref:`Page TSconfig <t3tsref:pagetsconfig>`.

Our extension key is `example` and the name of the content element or
plugin is `registration`.

.. rst-class:: bignums-xxl

#. Create page TSconfig

   .. code-block:: typoscript
      :caption: EXT:example/Configuration/TsConfig/Page/Mod/Wizards/NewContentElement.tsconfig

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

   You may want to replace :typoscript:`title` and :typoscript:`description`
   from above, using language files for translation, for example:

   .. code-block:: typoscript

      title = LLL:EXT:example/Resources/Private/Language/locallang.xlf:registration_title
      description = LLL:EXT:example/Resources/Private/Language/locallang.xlf:registration_description

#. Include TSconfig

   .. code-block:: typoscript
      :caption: EXT:example/Configuration/page.tsconfig

      @import 'EXT:example/Configuration/TsConfig/Page/Mod/Wizards/NewContentElement.tsconfig'

   This always includes the above page TSconfig. It is better practice to make this configurable by
   :ref:`registering this file as static page TSconfig <t3tsref:register-static-page-tsconfig>`.

   .. note::
      The usage of :file:`Configuration/page.tsconfig` is only valid in TYPO3
      v12+. If you want to stay compatible with TYPO3 v11 and v12 have a look
      into :ref:`t3tsconfig:setting-page-tsconfig`.

#. :ref:`Register your icon <icon-registration>`

   .. code-block:: php
      :caption: EXT:example/Configuration/Icons.php

      <?php

      return [
         // use same identifier as used in TSconfig for icon
         'example-registration' => [
            'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            'source' => 'EXT:example/Resources/Public/Icons/example-registration.svg',
         ],
      ];

#. After clearing cache, create a new content element

   After clearing the cache via :guilabel:`Admin Tools > Maintenance` or the
   command :bash:`vendor/bin/typo3 cache:flush` you should now see the icon,
   title and description you just added!

   .. figure:: /Images/ManualScreenshots/Backend/ContentElementWizard.png
      :class: with-shadow
      :alt: Content element wizard with the new content element

      Content element wizard with the new content element

.. seealso::

   * :ref:`t3tsconfig:pagenewcontentelementwizard` in TSconfig Reference
   * :ref:`Register your icon <icon-registration>` in TYPO3 Explained
   * :ref:`adding-your-own-content-elements`


Add your plugin or content element to a different tab
=====================================================

The above example adds your plugin to the tab "Plugin" in the content element wizard.
You can add it to one of the other existing tabs or create a new one.

.. tip::

   Look into the module :guilabel:`Info > Page TSconfig` for existing
   configurations of :typoscript:`mod.wizards.newContentElement.wizardItems`.


If you add it to any of the other tabs (other than plugins), you must add
the name to :typoscript:`show` as well:

.. code-block:: typoscript
   :caption: EXT:example/Configuration/TsConfig/Page/Mod/Wizards/NewContentElement.tsconfig

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

When you look at existing page TSconfig in the :guilabel:`Info` module, you may
notice that :typoscript:`show` has been set to include all for the
:guilabel:`Plugins` tab:

.. code-block:: typoscript

   show = *


Create a new tab
================

See the `bootstrap_package <https://github.com/benjaminkott/bootstrap_package>`__
for an example of creating a new tab :guilabel:`Interactive` and adding
elements to it:

.. code-block:: typoscript
   :caption: EXT:bootstrap_package/Configuration/TsConfig/Page/ContentElement/Categories.tsconfig

    mod.wizards.newContentElement.wizardItems {
        interactive.header = LLL:EXT:bootstrap_package/Resources/Private/Language/Backend.xlf:content_group.interactive
    }

.. code-block:: typoscript
   :caption: EXT:bootstrap_package/Configuration/TsConfig/Page/ContentElement/Element/Accordion.tsconfig

    mod.wizards.newContentElement.wizardItems.interactive {
        elements {
            accordion {
                iconIdentifier = content-bootstrappackage-accordion
                title = LLL:EXT:bootstrap_package/Resources/Private/Language/Backend.xlf:content_element.accordion
                description = LLL:EXT:bootstrap_package/Resources/Private/Language/Backend.xlf:content_element.accordion.description
                tt_content_defValues {
                    CType = accordion
                }
            }
        }
        show := addToList(accordion)
    }
