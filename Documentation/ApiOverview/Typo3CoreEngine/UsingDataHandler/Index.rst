.. include:: ../../../Includes.txt

.. _Using-DataHandler:
.. _using-tcemain:

============================
Using DataHandler in Scripts
============================

It's really easy to use the class :php:`\TYPO3\CMS\Core\DataHandling\DataHandler` in your own
scripts. All you need to do is include the class, build a $data/$cmd
array you want to pass to the class and call a few methods.

.. important::
   Mind that these scripts have to be run in the
   **backend scope**! There must be a global :php:`$GLOBALS['BE_USER']` object.

Using the DataHandler in a Symfony Command
==========================================

It is possible to use the DataHandler for scripts started from the command line or by
the scheduler as well. You can do this by creating a :ref:`Symfony Command <cli-mode-command-controllers>`.

These scripts use the `_cli_` backend user. Before using the DataHandler in your :php:`execute()`
function, you should make sure that this user is initialized like this::

   Bootstrap::initializeBackendAuthentication();

Look in the `typo3/cms-lowlevel <https://github.com/TYPO3/TYPO3.CMS/tree/master/typo3/sysext/lowlevel>`__
system extension for more examples.


.. _dataHandler-examples:
.. _tcemain-examples:

DataHandler Examples
====================

What follows are a few code listings with comments which will provide you with
enough knowledge to get started. It is assumed that you have populated
the $data and $cmd arrays correctly prior to these chunks of code. The
syntax for these two arrays is explained in the :ref:`previous chapter <tce-database>`.

.. _tcemain-submit-data:

Submitting Data
---------------

This is the most basic example of how to submit data into the
database.

* Line 1: Instantiate the class.
* Line 2: Register the :php:`$data` array inside the class and initialize the class internally.
* Line 3: Submit data and have all records created/updated.

.. code-block:: php
   :linenos:

   $dataHandler = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\DataHandler::class);
   $dataHandler->start($data, []);
   $dataHandler->process_datamap();


.. _tcemain-execute-commands:

Executing Commands
------------------

The most basic way of executing commands:

* Line 1: Instantiate the class.
* Line 2: Registers the :php:`$cmd` array inside the class and initialize the class internally.
* Line 3: Execute the commands.

.. code-block:: php
   :linenos:

   $dataHandler = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\DataHandler::class);
   $dataHandler->start([], $cmd);
   $dataHandler->process_cmdmap();


.. _tcemain-clear-cache:

Clearing Cache
--------------

In this example the cache clearing API is used. No data is submitted, no
are commands executed. Still you will have to initialize the class by
calling the :php:`start()` method (which will initialize internal state).

.. note::
   Clearing a given cache is possible only for users that are
   "admin" or have :ref:`specific permissions <t3tsconfig:useroptions>` to do so.

.. code-block:: php
   :linenos:

   $dataHandler = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\DataHandler::class);
   $dataHandler->start([], []);
   $dataHandler->clear_cacheCmd('all');

Since TYPO3 CMS 6.2, caches are organized in groups. Clearing "all"
caches will actually clear caches from the "all" group and not really
**all** caches. Check the :ref:`caching framework architecture section <caching-architecture-core>`
for more details about available caches and groups.

.. _tcemain-complex-submission:

Complex Data Submission
-----------------------

Imagine the $data array something like this:

.. code-block:: php
   :linenos:

   $data = array(
       'pages' => array(
           'NEW_1' => array(
               'pid' => 456,
               'title' => 'Title for page 1',
           ),
           'NEW_2' => array(
               'pid' => 456,
               'title' => 'Title for page 2',
           ),
       )
   );

This aims to create two new pages in the page with uid "456". In the
following code this is submitted to the database. Notice the reversing of
the order of the array: This is done because otherwise "page 1" is created
first, then "page 2" in the *same* PID meaning that "page 2" will end up
above "page 1" in the order. Reversing the array will create "page 2" first and
then "page 1" so the "expected order" is preserved.

To insert a record after a given record, set the other record's negative
`uid` as `pid` in the new record you're setting as data.

Apart from this a "signal" will be send that the page tree should
be updated at the earliest occasion possible. Finally, the cache for
all pages is cleared.

.. code-block:: php
   :linenos:

   $dataHandler = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\DataHandler::class);
   $dataHandler->reverseOrder = 1;
   $dataHandler->start($data, []);
   $dataHandler->process_datamap();
   \TYPO3\CMS\Backend\Utility\BackendUtility::setUpdateSignal('updatePageTree');
   $dataHandler->clear_cacheCmd('pages');


.. _tcemain-data-command-user:

Both Data and Commands Executed With Alternative User Object
------------------------------------------------------------

In this case it is shown how you can use the same object instance to
submit both data and execute commands if you like. The order will
depend on the order in the code.

First the :php:`start()` method is called, but this time with the third
possible argument which is an alternative :php:`$GLOBALS['BE_USER']` object.
This allows you to force another backend user account to create stuff in the
database. This may be useful in certain special cases. Normally you
should not set this argument since you want TCE to use the global
:php:`$GLOBALS['BE_USER']`.

.. code-block:: php
   :linenos:

   $dataHandler = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\DataHandler::class);
   $dataHandler->start($data, $cmd, $alternative_BE_USER);
   $dataHandler->process_datamap();
   $dataHandler->process_cmdmap();

.. _tcemain-error-handling:

Error handling
============================

The data handler has a property `errorLog` as an `array`.
In this property, the data handler collects all errors.
You can use these e.g to logging or another error handling.

.. code-block:: php
   :linenos:

   if (!empty($dataHandler->errorLog)) {
       $this->logger->error('Error(s) while creating content element');
       foreach ($dataHandler->errorLog as $log) {
           // handle error e.g. in a log
           $this->logger->error($log);
       }
   }
