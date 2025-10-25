..  include:: /Includes.rst.txt
..  index:: Button components
..  _button-components:

=================
Button components
=================

The button components are used in the
:ref:`DocHeader <backend-modules-template-without-extbase-docheader>` of a
:ref:`backend module <backend-modules>`.

Example on how to use a button component:

..  literalinclude:: _ButtonComponents/_DropDownButton.php
    :caption: EXT:my_extension/Classes/Controller/MyBackendController.php

..  seealso::
    *   :ref:`ModifyButtonBarEvent`

..  contents:: Table of contents
    :local:

..  todo: Add components: FullyRenderedButton, InputButton, LinkButton, SplitButton

.. _generic-button-component:

Generic button component
========================

The component :php:`\TYPO3\CMS\Backend\Template\Components\Buttons\GenericButton`
allows to render any markup in the module menu bar.

Example:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/MyBackendController.php

    $buttonBar = $this->moduleTemplate->getDocHeaderComponent()->getButtonBar();
    $genericButton = GeneralUtility::makeInstance(GenericButton::class)
        ->setTag('a')
        ->setHref('#')
        ->setLabel('My label')
        ->setTitle('My title')
        ->setIcon($this->iconFactory->getIcon('actions-heart'))
        ->setAttributes(['data-value' => '123']);
    $buttonBar->addButton($genericButton, ButtonBar::BUTTON_POSITION_RIGHT, 2);


.. _dropdown-button-components:

Dropdown button components
==========================

The :ref:`backend module <backend-modules>` menu button bar can display
dropdowns. This enables interface interactions, such as switching the current
view from list to tiles, or group actions like clipboard and thumbnail
visibility. This helps unclutter the views and allow the user to see more
information at a glance.

Each dropdown consists of various elements ranging from headings to item links
that can display the current status. The button automatically changes the
icon representation to the icon of the the first active radio icon in the
dropdown list.

..  figure:: /Images/ManualScreenshots/Backend/FileModuleDropDownButton.png
    :alt: DropDown button component in the :guilabel:`Media > Filelist` module
    :class: with-border with-shadow

    DropDown button component in the :guilabel:`Media > Filelist` module


..  _dropdown-button-components-button:

DropDownButton
--------------

This button type is a container for dropdown items. It will render a dropdown
containing all items attached to it. There are different kinds available, each
item needs to implement the
:php:`\TYPO3\CMS\Backend\Template\Components\Buttons\DropDown\DropDownItemInterface`.
When this type contains elements of type :ref:`dropdown-button-components-radio`
it will use the icon of the first active item of this type.

Example:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/MyBackendController.php

    $dropDownButton = $buttonBar->makeDropDownButton()
        ->setLabel('Dropdown')
        ->setTitle('Save')
        ->setIcon($this->iconFactory->getIcon('actions-heart'))
        ->addItem(
            GeneralUtility::makeInstance(DropDownItem::class)
                ->setLabel('Item')
                ->setHref('#')
        );


..  _dropdown-button-components-divider:

DropDownDivider
---------------

This dropdown item type renders the divider element.

Example:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/MyBackendController.php

    use TYPO3\CMS\Backend\Template\Components\Buttons\DropDown\DropDownDivider;

    $item = GeneralUtility::makeInstance(DropDownDivider::class);
    $dropDownButton->addItem($item);


..  _dropdown-button-components-header:

DropDownHeader
--------------

This dropdown item type renders a non-interactive text element to group items
and gives more meaning to a set of options.

Example:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/MyBackendController.php

    use TYPO3\CMS\Backend\Template\Components\Buttons\DropDown\DropDownHeader:

    $item = GeneralUtility::makeInstance(DropDownHeader::class)
        ->setLabel('My label');
    $dropDownButton->addItem($item);


..  _dropdown-button-components-item:

DropDownItem
------------

This dropdown item type renders a simple element. Use this element if you need
a link button.

Example:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/MyBackendController.php

    use TYPO3\CMS\Backend\Template\Components\Buttons\DropDown\DropDownHeader:

    $item = GeneralUtility::makeInstance(DropDownItem::class)
        ->setTag('a')
        ->setHref('#')
        ->setLabel('My label')
        ->setTitle('My title')
        ->setIcon($this->iconFactory->getIcon('actions-heart'))
        ->setAttributes(['data-value' => '123']);
    $dropDownButton->addItem($item);


..  _dropdown-button-components-radio:

DropDownRadio
-------------

This dropdown item type renders an element with an active state. Use this
element to display a radio-like selection of a state. When set to active, it
will show a dot in front of the icon and text to indicate that this is the
current selection.

At least two of these items need to exist within a dropdown button, so a user
has a choice of a state to select.

Example:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/MyBackendController.php

    $item = GeneralUtility::makeInstance(DropDownRadio::class)
        ->setHref('#')
        ->setActive(true)
        ->setLabel('My label')
        ->setTitle('My title')
        ->setIcon($this->iconFactory->getIcon('actions-viewmode-list'))
        ->setAttributes(['data-type' => 'list']);
    $dropDownButton->addItem($item);

    $item = GeneralUtility::makeInstance(DropDownRadio::class)
        ->setHref('#')
        ->setActive(false)
        ->setLabel('Tiles')
        ->setTitle('Tiles')
        ->setIcon($this->iconFactory->getIcon('actions-viewmode-tiles'))
        ->setAttributes(['data-type' => 'tiles']);
    $dropDownButton->addItem($item);


..  _dropdown-button-components-toggle:

DropDownToggle
--------------

This dropdown item type renders an element with an active state. When set to
active, it will show a checkmark in front of the icon and text to indicate the
current state.

Example:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/MyBackendController.php

    $item = GeneralUtility::makeInstance(DropDownToggle::class)
        ->setHref('#')
        ->setActive(true)
        ->setLabel('My label')
        ->setTitle('My title')
        ->setIcon($this->iconFactory->getIcon('actions-heart'))
        ->setAttributes(['data-value' => '123']);
    $dropDownButton->addItem($item);
