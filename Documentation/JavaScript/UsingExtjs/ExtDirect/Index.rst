.. include:: ../../../Includes.txt






.. _extdirect:

Ext.Direct
^^^^^^^^^^

.. _extdirect-intro:

What is Ext.Direct?
"""""""""""""""""""

   "Ext Direct is a platform and language agnostic technology
   to remote server-side methods to the client-side.
   Ext Direct allows for seamless communication between the client-side
   of an Ext JS application and all popular server platforms."

Source: http://www.sencha.com/products/extjs/extdirect

In effect it means that JavaScript functions can be mapped - in the case
of TYPO3 - to PHP methods on the server. AJAX calls are made transparently
and TYPO3 dispatches the request and sends back the response. It's like
calling the PHP function in JavaScript.

Let's look the old fashioned way of creating a server-side request:

.. code-block:: javascript

   new Ajax.Request('ajax.php', {
       method: 'get',
       parameters: 'ajaxID=tx_myext_module1::executeSomething',
       onComplete: function(xhr, json) {
           // Do something with the response
       }.bind(this)
   });

and the same with Ext.Direct:

.. code-block:: javascript

   TYPO3.Backend.MyModule.doSomething('someValue', function(response, options) {
      // Do something with the response
   });

This features exists since TYPO3 4.4.

.. _extdirect-how-to:

How to use Ext.Direct?
""""""""""""""""""""""

First of all, the PHP method and the JavaScript function must be
declared in order to paired together (code taken from the "examples"
extension)::

   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerExtDirectComponent(
      'TYPO3.Examples.ExtDirect',
      \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY, 'Classes/ExtDirect/Server.php:Tx_Examples_ExtDirect_Server'),
      NULL,
      'user,group'
   );


The last two parameters are used to define the access level of your
Ext.Direct code for the BE! The third one can limit access
to special modules and the fourth can be used to define
authorized access only.

The next step is to make sure that the Ext.Direct code is loaded
and registered with the proper namespace. This is achieved by
calling up the page renderer from the BE module or from a specially
designed Fluid View Helper, when making Extbase-based modules.
Example taken from file :file:`EXT:examples/Classes/ViewHelpers/Be/HeaderViewHelper.php`::

      /** @var $pageRenderer \TYPO3\CMS\Core\Page\PageRenderer */
   $pageRenderer = $this->getDocInstance()->getPageRenderer();
      // Add base Ext.Direct code
   $pageRenderer->addExtDirectCode(
      array('TYPO3.Examples')
   );
      // Make localized labels available in JavaScript context
   $pageRenderer->addInlineLanguageLabelFile('EXT:examples/Resources/Private/Language/locallang.xml');


On the server-side, the method is implement as any other PHP method, receiving
the same arguments as the JavaScript function and returning whatever data it is
expected to produce::

   public function countRecords($table) {
         // Return the count of all non-deleted records for the given table
      return array(
         'data' => $GLOBALS['TYPO3_DB']->exec_SELECTcountRows('uid', $table, '1 = 1' . \TYPO3\CMS\Backend\Utility\BackendUtility::deleteClause($table))
      );
   }

Here the method receives a table name and sends back the count of
undeleted records. The corresponding JavaScript looks like::

   TYPO3.Examples.ExtDirect.countRecords(table, function(response) {
         // If the response contains data, display it in a JavaScript flash message
      if (response.data) {
         var message = String.format(TYPO3.lang['record_count_message'], response.data, table);
         TYPO3.Flashmessage.display(TYPO3.Severity.ok, TYPO3.lang['record_count_title'], message, 5);
      }
   });


The data is handled inside a callback function as is usual with
asynchronous calls. In this case we simple display a popup flash message.

.. note::

   This chapter should include an example about using Ext.Direct in the FE too.
   The last time I tried to do this it didn't work. I don't have time
   to dig into that now (François - 10.11.2012)


.. _extdirect-debugging:

Debugging and exception handling
""""""""""""""""""""""""""""""""

The Ext.Direct implementation in the TYPO3 BE makes it possible
both to catch exceptions and perform some debugging output. Exceptions
are simply caught and displayed as error-level flash messages. Debugging
output is redirected to the debug console. Just call the :code:`debug()`
function.


.. _extdirect-api-generator:

The API Generator
"""""""""""""""""

Looking at what happens under the hood, the following call::

   $pageRenderer->addExtDirectCode(
      array('TYPO3.Examples')
   );


not only adds all the base JavaScript code related to Ext.Direct,
but also uses reflection to analyze the declared PHP class and build
an API out of it.

In particular if your server-side method is expected to handle
a form submission, it must be declared with the @formHandler annotation.
Example taken from the Extension Manager's code::

   /**
    * Save extension configuration
    *
    * @formHandler
    * @param array $parameter
    * @return array
    */
   public function saveExtensionConfiguration($parameter) {
    ...
   }

