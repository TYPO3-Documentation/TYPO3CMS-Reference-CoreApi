..  include:: /Includes.rst.txt
..  index:: DataHandler; Usage
..  _Using-DataHandler:
..  _using-tcemain:

================================
Using the DataHandler in scripts
================================

You can use the class :php:`\TYPO3\CMS\Core\DataHandling\DataHandler` in your
own scripts: Inject the :php:`DataHandler` class, build a
:php:`$data`/:php:`$cmd` array you want to pass to the class, and call a few
methods.

..  attention::
    Mind that these scripts have to be run in the
    **backend scope**! There must be a global :php:`$GLOBALS['BE_USER']` object.


..  contents:: Table of Contents
    :depth: 2
    :local:


..  index:: pair: DataHandler; Symfony command
..  _dataHandler-cli-command:

Using the DataHandler in a Symfony command
==========================================

It is possible to use the DataHandler for scripts started from the command line
or by the :doc:`scheduler <ext_scheduler:Index>` as well. You can do this by
creating a :ref:`Symfony Command <cli-mode-command-controllers>`.

These scripts use the `_cli_` backend user. Before using the DataHandler in your
:php:`execute()` method, you should make sure that this user is initialized like
this:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Command/MyCommand.php

    \TYPO3\CMS\Core\Core\Bootstrap::initializeBackendAuthentication();

If you forget to add the backend user authentication, an error similar to this
will occur:

..  code-block:: text

    [1.2.1]: Attempt to modify table "pages" without permission


..  index:: pair: DataHandler; PHP
..  _dataHandler-examples:
..  _tcemain-examples:

DataHandler examples
====================

What follows are a few code listings with comments which will provide you with
enough knowledge to get started. It is assumed that you have populated
the :php:`$data` and :php:`$cmd` arrays correctly prior to these chunks of code.
The syntax for these two arrays is explained in the
:ref:`DataHandler basics <datahandler-basics>` chapter.

..  warning::
    A new :php:`DataHandler` object **should** be created using
    :php:`GeneralUtility::makeInstance(DataHandler::class)` before each use.
    It is a stateful service and has to be considered polluted after use. Do not
    call :php:`DataHandler::start()` or :php:`DataHandler::process_datamap()`
    multiple time on the same instance.

    The :php:`DataHandler` class **must not** be injected into the constructor via
    :ref:`dependency injection <DependencyInjection>`. This can cause unexpected
    side effects.

..  _tcemain-submit-data:

Submitting data
---------------

This is the most basic example of how to submit data into the database.

..  literalinclude:: _SubmitData.php
    :language: php
    :caption: EXT:my_extension/Classes/DataHandling/MyClass.php


..  _tcemain-execute-commands:

Executing commands
------------------

The most basic way of executing commands:

..  literalinclude:: _ExecuteCommands.php
    :language: php
    :caption: EXT:my_extension/Classes/DataHandling/MyClass.php


..  _tcemain-clear-cache:

Clearing cache
--------------

In this example the cache clearing API is used. No data is submitted, no
commands are executed. Still you will have to initialize the class by
calling the :php:`start()` method (which will initialize internal state).

..  note::
    Clearing a given cache is possible only for users that are
    "admin" or have :ref:`specific permissions <t3tsref:useroptions>` to do so.

..  literalinclude:: _ClearCache.php
    :language: php
    :caption: EXT:my_extension/Classes/MyClass.php

Caches are organized in groups. Clearing "all" caches will actually clear caches
from the "all" group and not really **all** caches. Check the
:ref:`caching framework architecture section <caching-architecture-core>`
for more details about available caches and groups.

..  _tcemain-complex-submission:

Complex data submission
-----------------------

Imagine the :php:`$data` array contains something like this:

..  code-block:: php

    $data = [
        'pages' => [
            'NEW_1' => [
                'pid' => 456,
                'title' => 'Title for page 1',
            ],
            'NEW_2' => [
                'pid' => 456,
                'title' => 'Title for page 2',
            ],
        ],
    ];

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

..  literalinclude:: _SubmitComplexData.php
    :language: php
    :caption: EXT:my_extension/Classes/DataHandling/MyClass.php


..  _tcemain-data-command-user:

Both data and commands executed with alternative user object
------------------------------------------------------------

In this case it is shown how you can use the same object instance to
submit both data and execute commands if you like. The order will
depend on the order in the code.

First the :php:`start()` method is called, but this time with the third
possible argument which is an alternative :php:`$GLOBALS['BE_USER']` object.
This allows you to force another backend user account to create stuff in the
database. This may be useful in certain special cases. Normally you
should not set this argument since you want DataHandler to use the global
:php:`$GLOBALS['BE_USER']`.

..  literalinclude:: _UseAlternativeUser.php
    :language: php
    :caption: EXT:my_extension/Classes/DataHandling/MyClass.php


..  index:: pair: DataHandler; Error handling
..  _tcemain-error-handling:

Error handling
==============

The data handler has a property `errorLog` as an `array`.
In this property, the data handler collects all errors.
You can use these, for example, for logging or other error handling.

..  literalinclude:: _ErrorHandling.php
    :language: php
    :caption: EXT:my_extension/Classes/DataHandling/MyClass.php
