.. include:: ../../../Includes.txt


.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.


.. _ajax-backend:

Developing with AJAX in the TYPO3 Backend
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This is a small guide for you to use this feature in your AJAX
scripts.


.. _ajax-backend-id:

How to choose the right ajaxID
""""""""""""""""""""""""""""""

The ajaxID consists of two parts, the class name and the action name,
delimited by "::" ("<class>::<action>").

Please note that the ajaxID is just a system-wide identifier to
register your AJAX handler. Even if it looks like a static function
call, it won't be executed and has no technical dependencies. But it
is required for all developers to use a common naming scheme as
described above, since it might prevent from using identical names in
different extensions.

Some good examples for an ajaxID:

- SC\_alt\_db\_navframe::expandCollapse

- t3lib\_TCEforms\_inline::processAjaxRequest

- tx\_myext\_module1::executeSomething

Some bad examples for an ajaxID:

- search::findRecordByTitle

- core::reloadReferences

- inline::processAjaxRequest

- updateRecordList


.. _ajax-backend-server:

Server-Side
"""""""""""

1) Register your unique ajaxID, at best prepended with your extension
ID, in the TYPO3 backend by adding the following line to your
:file:`ext_localconf.php` (this way you can also overwrite existing AJAX
calls):

::

   $TYPO3_CONF_VARS['BE']['AJAX']['tx_myext::ajaxID'] = 'filename:object->method';

A working example would be:

::

   $TYPO3_CONF_VARS['BE']['AJAX']['SC_alt_db_navframe::expandCollapse'] = 'typo3/alt_db_navframe.php:SC_alt_db_navframe->ajaxExpandCollapse';

2) Create a target method to do the logic on the server-side:
similarly to the existing hooking mechanism, as with every
"callUserFunction", the target method (here: ajaxExpandCollapse) will
have two function parameters. The first one is an array of params (not
used right now), the second is the TYPO3 AJAX Object (see
:file:`typo3/classes/class.typo3ajax.php` for all available methods). You
should use this to set the content you want to output or to write the
error message if something went wrong.

::

   public function ajaxExpandCollapse($params, &$ajaxObj) {
       $this->init();
       // do the logic...
       if (empty($this->tree)) {
           $ajaxObj->setError('An error occurred');
       } else  {
           // the content is an array that can be set through $key / $value pairs as parameter
           $ajaxObj->addContent('tree', 'The tree works...');
       }
   }

So, the server-side part is now complete. Let's move over to the
client-side.


.. _ajax-backend-client:

Client-part
"""""""""""

3) In order for you to use client-side AJAX Javascript you have to add
these two lines of PHP code to your PHP script (available in
:file:`template.php`, your template document):

::

   $this->doc->loadJavascriptLib('contrib/prototype/prototype.js');
   $this->doc->loadJavascriptLib('js/common.js');

4) With prototype on the client side, it's quite simple to add a new
AJAX request in Javascript:

::

   new Ajax.Request('ajax.php', {
       method: 'get',
       parameters: 'ajaxID=SC_alt_db_navframe::expandCollapse',
       onComplete: function(xhr, json) {
           // display results, should be "The tree works"
       }.bind(this),
       onT3Error: function(xhr, json) {
           // display error message, will be "An error occurred" if an error occurred
       }.bind(this)
   });

You can see, that it's almost the same, except that we introduce a new
callback function "onT3Error", which is optional. It is called if the
method "setError" on the server-side was called. Otherwise
"onComplete" will be called. If you do not define "onT3Error", then
the error message will be shown in the TYPO3 notification area in the
backend. Our AJAX responders also work with the "onSuccess" callback,
but the onT3Error is only executed with "onComplete".

This should be all. Please note that our TYPO3 BE AJAX mechanism works
best with the prototype JS library. If you want to create similar
approaches for other JS frameworks, have a look at
:file:`typo3/js/common.js`.

