.. include:: ../../../Includes.txt

.. _ajax-backend:

Developing with AJAX in the TYPO3 Backend
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This section describes how to correctly make AJAX calls
in the TYPO3 CMS BE.

.. note::

   This section was fully updated for TYPO3 CMS 6.2. For
   older versions, please refer to the related version of
   this manual.


.. _ajax-backend-id:

How to choose the right ajaxID
""""""""""""""""""""""""""""""

An AJAX call is represented by a system-wide identifier
which is used to register the handler that will receive the call.
The ajaxID consists of two parts, the class name and the action name,
delimited by "::" (:code:`<class>::<action>`).

Although it looks like a static function call, it is really just a key.
Developers must stick to a common naming scheme as
described above, to avoid using identical names in
different extensions.

Some good examples for an ajaxID:

- SC\_alt\_db\_navframe::expandCollapse

- BackendLogin::refreshLogin

- tx\_myext\_module1::executeSomething

Some bad examples for an ajaxID (the first part is too generic
or the identifier contains a single part):

- search::findRecordByTitle

- core::reloadReferences

- inline::processAjaxRequest

- updateRecordList


.. _ajax-backend-server:

Server-Side
"""""""""""

Since TYPO3 CMS 6.2, the registration is done via an API,
which provides CSRF protection on the AJAX call and an automatic
registration of the AJAX call URL (in :file:`typo3conf/opendocs/ext_tables.php`):

.. code-block:: php

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler (
		'OpendocsController::renderMenu',
		'TYPO3\\CMS\\Opendocs\\Controller\\OpendocsController->renderAjax'
	);

This is how the "opendocs" system extension registers the AJAX call to render
the open documents menu in the top toolbar. The first argument is the ajaxID (as
described above) and the second argument is a pointer to a class and method.
This code must be located in an extension's :file:`ext_tables.php` file.

The target method receives an array of parameters (depending on the call
context) and a backreference to the general AJAX handler
:php:`(\TYPO3\CMS\Core\Http\AjaxRequestHandler`).
The API of this object is used to set the content to output or to write an
error message if something went wrong.

In the above example, here's how the handling method looks like
(in :file:`typo3conf/opendocs/Classes/Controller/OpendocsController.php`):


.. code-block:: php

	/**
	 * Renders the menu so that it can be returned as response to an AJAX call
	 *
	 * @param array $params Array of parameters from the AJAX interface, currently unused
	 * @param \TYPO3\CMS\Core\Http\AjaxRequestHandler $ajaxObj Object of type AjaxRequestHandler
	 * @return void
	 */
	public function renderAjax($params = array(), \TYPO3\CMS\Core\Http\AjaxRequestHandler &$ajaxObj = NULL) {
		$menuContent = $this->renderMenu();

		// addContent('key', 'content to add')
		// 'key' = the new content key where the content should be added in the content array
		$ajaxObj->addContent('opendocsMenu', $menuContent);

		// the new content, "$menuContent" can now be referenced like this:
		// $ajaxObj->getContent('opendocsMenu');
	}


.. _ajax-backend-client:

Client-part
"""""""""""

The API mentioned above registers a corresponding AJAX URL
in the global :code:`TYPO3.settings.ajaxUrls` JavaScript
array.

Whatever library you use, this URL can easily be accessed by
using the registration key.

.. code-block:: javascript

	var ajaxUrl = TYPO3.settings.ajaxUrls['<registration key>'];

Here is the client-side part corresponding to the above example
(an extract of :file:`typo3/sysext/backend/Resources/Public/JavaScript/shortcutmenu.js`):

.. code-block:: javascript

	var del = new Ajax.Request(TYPO3.settings.ajaxUrls['ShortcutMenu::delete'], {
		parameters : '&shortcutId=' + shortcutId,
		onComplete : this.reRenderMenu.bind(this)
	});
