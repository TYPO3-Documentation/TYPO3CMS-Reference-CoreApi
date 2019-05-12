.. include:: ../../../Includes.txt


.. _csh-implementation:

================
Implementing CSH
================

.. _csh-implementation-new-table:

For new Tables and Fields
=========================

Create a language file following the
explanations given in this chapter and register it in your
extension's :file:`ext_tables.php` file:

.. code-block:: php

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
		'tx_domain_model_foo',
		'EXT:myext/Resources/Private/Language/locallang_csh_tx_domain_model_foo.xlf'
	);


The rest of the work is automatically handled by the TYPO3 CMS
form engine.


.. _csh-implementation-extend-table:

Adding CSH for Fields Added to Existing Tables
==============================================

Create a language file in your extension
using the name of the table that you are extending. Inside the file,
place labels only for the fields that you have added. Register the file
as usual, but for the table that you are extending:

.. code-block:: php

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
		'pages',
		'EXT:myext/Resources/Private/Language/locallang_csh_pages.xlf'
	);

The example assumes that you are extending the "pages" table.

.. _csh-implementation-modules:

For Modules
===========

Implementing CSH for your backend module requires a bit more work,
because you don't have the form engine doing everything for you.

The start of the process is the same: create your language file
and register it.

The main method that renders a help button is
:code:`\TYPO3\CMS\Backend\Utility\BackendUtility::cshItem()`. This renders
the question mark icon and the necessary markup for the JavaScript
that takes care of the tool tip display. To make the markup
into a button some wrapping must be added around it:

.. code-block:: html

	<span class="btn btn-sm btn-default">(CSH markup)</span>

For adding a help button in the menu bar, the following code can be
used in the controller:

.. code-block:: php

    /**
     * Registers the Icons into the docheader
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function registerDocHeaderButtons()
    {
        /** @var ButtonBar $buttonBar */
        $buttonBar = $this->view->getModuleTemplate()->getDocHeaderComponent()->getButtonBar();

        // CSH
        $cshButton = $buttonBar->makeHelpButton()
            ->setModuleName('xMOD_csh_corebe')
            ->setFieldName('filelist_module');
        $buttonBar->addButton($cshButton);
    }

This code is taken from class :code:`\TYPO3\CMS\Filelist\Controller\FileListController`
and takes care about adding the help button on the right-hand side of the module's
docheader. The argument passed to :code:`setModuleName()` is the key
with which the CSH file was registered, the one passe to :code:`setFieldName`
is whatever field name is used in the file.

To place a help button at some arbitrary location in your module,
you can rely on a Fluid view helper (which - again - needs some
wrapping to create a true button):

.. code-block:: html

	<span class="btn btn-sm btn-default">
		<f:be.buttons.csh table="xMOD_csh_corebe" field="filelist_module" />
	</span>

This example uses the same arguments as above.
