.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt






.. _using-tcemain:

Using TCEmain in scripts
^^^^^^^^^^^^^^^^^^^^^^^^

It's really easy to use the class :code:`\TYPO3\CMS\Core\DataHandling\DataHandler` in your own
scripts. All you need to do is include the class, build a $data/$cmd
array you want to pass to the class and call a few methods.

.. important::
   Mind that these scripts have to be run in the
   **backend scope**! There must be a global :code:`$BE_USER` object.

In your script you simply insert this line to include the class:

What follows are a few code listings with comments which will provide you with
enough knowledge to get started. It is assumed that you have populated
the $data and $cmd arrays correctly prior to these chunks of code. The
syntax for these two arrays is explained in the :ref:`previous chapter <tce-database>`.


.. _tcemain-examples:

TCEmain examples
""""""""""""""""

.. _tcemain-submit-data:

Submitting data
~~~~~~~~~~~~~~~

This is the most basic example of how to submit data into the
database. It is four lines. Line 1 instantiates the class, line 2
defines that values will be provided without escaped characters
(recommended!), line 3 registers the $data array inside the class and
initializes the class internally! Finally line 4 will execute the data
submission.

.. code-block:: php
   :linenos:

   $tce = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
   $tce->stripslashes_values = 0;
   $tce->start($data, array());
   $tce->process_datamap();


.. _tcemain-execute-commands:

Executing commands
~~~~~~~~~~~~~~~~~~

The most basic way of executing commands. Line 1 creates the object,
line 2 defines that values will be provided without escaped characters
(recommended), line 3 registers the $cmd array inside the class and
initializes the class internally! Finally line 4 will execute the
commands.

.. code-block:: php
   :linenos:

   $tce = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
   $tce->stripslashes_values = 0;
   $tce->start(array(), $cmd);
   $tce->process_cmdmap();


.. _tcemain-clear-cache:

Clearing cache
~~~~~~~~~~~~~~

In this example the cache clearing API is used. No data is submitted, no
commands executed. Still you will have to initialize the class by
calling the start() method (which will initialize internal variables).

.. note::
   Clearing a given cache is possible only for users that are
   "admin" or have :ref:`specific permissions <t3tsconfig:useroptions>` to do so.

.. code-block:: php
   :linenos:

   $tce = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
   $tce->start(array(), array());
   $tce->clear_cacheCmd('all');

Since TYPO3 CMS 6.2, caches are organized in groups. Clearing "all"
caches will actually clear caches from the "all" group and not really
**all** caches. Check the :ref:`caching framework architecture section <caching-architecture-core>`
for more details about available caches and groups.


.. _tcemain-complex-submission:

Complex data submission
~~~~~~~~~~~~~~~~~~~~~~~

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
follow code this is submitted to the database. Notice how line 3
reverses the order of the array. This is done because otherwise "page
1" is created first, then "page 2" in the *same* PID meaning that
"page 2" will end up above "page 1" in the order. Reversing the array
will create "page 2" first and then "page 1" so the "expected order"
is preserved.

To insert a record after a given record, set the other record's negative
`uid` as `pid` in the new record you're setting as data.

Apart from this line 6 will send a "signal" that the page tree should
be updated at the earliest occasion possible. Finally, the cache for
all pages is cleared in line 7.

.. code-block:: php
   :linenos:

   $tce = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
   $tce->stripslashes_values = 0;
   $tce->reverseOrder = 1;
   $tce->start($data, array());
   $tce->process_datamap();
   \TYPO3\CMS\Backend\Utility\BackendUtility::setUpdateSignal('updatePageTree');
   $tce->clear_cacheCmd('pages');


.. _tcemain-data-command-user:

Both data and commands executed with alternative user object
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

In this case it is shown how you can use the same object instance to
submit both data and execute commands if you like. The order will
depend on the order of line 4 and 5.

In line 3 the :code:`start()` method is called, but this time with the third
possible argument which is an alternative :code:`$BE_USER` object. This allows
you to force another backend user account to create stuff in the
database. This may be useful in certain special cases. Normally you
should not set this argument since you want TCE to use the global
:code:`$BE\_USER`.

.. code-block:: php
   :linenos:

   $tce = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\DataHandling\\DataHandler');
   $tce->stripslashes_values = 0;
   $tce->start($data, $cmd, $alternative_BE_USER);
   $tce->process_datamap();
   $tce->process_cmdmap();

