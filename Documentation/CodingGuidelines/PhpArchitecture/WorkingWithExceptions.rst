..  include:: /Includes.rst.txt
..  index::
    single: Coding guidelines; Exceptions
    pair: PHP; Exceptions

..  _cgl-working-with-exceptions:

=======================
Working with exceptions
=======================


Introduction
============

Working with exceptions in a sane way is a frequently asked topic. This
section aims to give some good advice on how to deal with exceptions in
TYPO3 world and especially which types of exceptions should be thrown
under which circumstances.

First of, exceptions are a good thing - there is nothing bad with
throwing them. It is often better to throw an exception than to return
a “mixed” return value from a method to signal that something went
wrong. TYPO3 has a tradition of methods that return either an expected
result set - for instance an array - or alternatively a boolean false
on error. This is often confusing for callers and developers tend to
forget to implement proper error handling for such “false was returned”
cases. This easily leads to hard to track problems. It is often a much
better choice to throw an exception if something went wrong: This gives
the chance to throw a meaningful message directly to the developer or to
a log file for later analysis. Additionally, an exception usually comes
along with a backtrace.


Exception types
===============

Exceptions are a good thing, but how to decide on what to throw exactly?
The basic idea is: If it is possible that an exception needs to be
caught by a higher level code segment, then a specific exception type
- mostly unique for this case - should be thrown. If the exception
should never be caught, then a top-level PHP built-in exception should
be thrown. For PHP built-in exceptions, the actual class is not crucial,
if in doubt, a :php:`\RuntimeException` fits - it is much more important
to throw a meaningful exception message in those cases.

Typical cases for exceptions that are designed to be caught
-----------------------------------------------------------

*   Race conditions than can be created by editors in a normal workflow:

    *   Editor 1 calls list module and a record is shown.

    *   Editor 2 deletes this record.

    *   Editor 1 clicks the link to open this deleted record.

    *   The code throws a catchable, specific named exception that is turned
        into a localized error message shown to the user "The record 12
        from table tt_content you tried to open has been deleted …".

*   Temporary issues: Updating the extension list in the Extension Manager
    fails because of a network issue - The code throws a catchable, named
    exception that is turned into a localized error message shown to the
    user "Can not connect to update servers, please check internet
    connection …".


..  index:: RuntimeException

Typical cases for exceptions that should not be caught
------------------------------------------------------

*   Wrong configuration: A :ref:`FlexForm <FlexForms>` contains a
    :code:`type=inline` field. At the time of this writing, this case was not
    implemented, so the code checks for this case and throws a top-level PHP
    built-in exception (:php:`\RuntimeException` in this case) to point
    developers to an invalid configuration scenario.

*   Programming error / wrong API usage: Code that can not do its job
    because a developer did not take care and used an API in a wrong way.
    This is a common reason to throw an exception and can be found at lots
    of places in the Core. A top-level exception like
    :php:`\RuntimeException` should be thrown.


Typical exception arguments
===========================

The standard exception signature:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Exceptions/MyException.php

    public function __construct(
        string $message = "",
        int $code = 0,
        \Throwable $previous = null,
    ) {
        // ... the logic
    }

TYPO3 typically uses a meaningful exception message and a unique code.
Uniqueness of :php:`$code` is created by using a Unix timestamp of :php:`now`
(the time when the exception is created): This can be easily created,
for instance using the trivial shell command :code:`date +%s`. The resulting
number of this command should be directly used as the exception code and never
changed again.

Throwing a meaningful message is important especially if top-level exceptions
are thrown. A developer receiving this exception should get all useful
data that can help to debug and mitigate the issue.

Example:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Exceptions/MyException.php

    use MyVendor\SomeExtension\File\FileNotAccessibleException;
    use MyVendor\SomeExtension\File\FileNotFoundException;

    // ...

    if ($pid === 0) {
        throw new \RuntimeException('The page "' . $pid . '" cannot be accessed.', 1548145665);
    }

    $absoluteFilePath = GeneralUtility::getFileAbsFileName($filePath);

    if (is_file($absoluteFilePath)) {
        $file = fopen($absoluteFilePath, 'rb');
    } else {
        // prefer speaking exception names, add custom exceptions if necessary
        throw new FileNotFoundException('File "' . $absoluteFilePath . '" does not exist.', 1548145672);
    }

    if ($file == null) {
        throw new FileNotAccessibleException('File "' . $absoluteFilePath . '" cannot be read.', 1548145672);
    }



Exception inheritance
=====================

A typical exception hierarchy for specific exceptions in the Core
looks like :php:`\MyVendor\MyExtension\Exception extends \TYPO3\CMS\Core\Exception`,
where :php:`\TYPO3\CMS\Core\Exception` is the base of all exceptions in TYPO3.

Building on that you can have
:php:`MyVendor\MyExtension\Exception\AFunctionality\ASpecificException extends MyVendor\MyExtension\Exception`
for more specific exceptions. All of your exceptions
should extend your extension-specific base exception.

So, as rule:
As soon as multiple different specific exceptions are thrown within
some extension, there should be a generic base exception within the extension
that is not thrown itself, and the specific exceptions that are thrown
then extend from this class.

Typically, only the specific exceptions are
caught however. In general, the inheritance hierarchy should not be
extended much deeper and should be kept relatively flat.


Extending exceptions
====================

It can become handy to extend exceptions in order to transport further
data to the code that catches the exception. This can be useful if an
exception is caught and transformed into a localized flash message or
a notification. Typically, those additional pieces of information
should be added as additional constructor arguments:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Exceptions/MyException.php

    public function __construct(
        string $message = "",
        int $code = 0,
        \Throwable $previous = null,
        string $additionalArgument = '',
        int $anotherArgument = 0,
    ) {
        // ... the logic
    }

There should be getters for those additional data parts within the
exception class. Enriching an exception with additional data should not
happen with setter methods: Exceptions have a characteristics similar
to “value objects” that should not be changed. Having setters would
spoil this idea: Once thrown, exceptions should be immutable, thus the
only way to add data is by handing it over as constructor arguments.


Good examples
=============

*   :php:`\TYPO3\CMS\Backend\Form\FormDataProvider\AbstractDatabaseRecordProvider`,
    :php:`\TYPO3\CMS\Backend\Form\FormDataProvider\DatabaseEditRow`,
    :php:`\TYPO3\CMS\Backend\Form\Exception\DatabaseRecordException`,
    :php:`\TYPO3\CMS\Backend\Form\FormDataProvider\TcaInline`

    *   Scenario: :php:`DatabaseEditRow` may throw a :php:`DatabaseRecordException`
        if the record to open has been deleted meanwhile. This can happen
        in inline scenarios, so the TcaInline data provider catches this
        exception.

    *   Good: Next to a meaningful exception message, the exception is
        enriched with the table name and the uid it was handling in
        :php:`__construct()` to hand over further useful information to the
        catching code.

    *   Good: The catching code catches this specific exception, uses the
        getters of the exception to get the additional data and creates a
        localized error message from it that is enriched with further data
        that only the catching code knows.

    *   Good: The exception hierarchy is relatively flat - it extends from
        a more generic :php:`\Backend\Form\Exception` which itself extends
        from :php:`\Backend\Exception` which extends :php:`\Exception`.
        The :php:`\Backend\Form\Exception` could have been left out, but
        since the backend extension is so huge, the author decided to have
        this additional class layer in between.

    *   Good: The method that throws has :php:`@throws` annotations to hint
        IDEs like PhpStorm that an exception may be received using that
        method.

    *   Bad: The exception could have had a more dedicated name like
        :php:`DatabaseRecordVanishedException` or similar.

*   :php:`\TYPO3\CMS\Backend\Form\FormDataProvider\AbstractDatabaseRecordProvider`

    *   Good: method :php:`getRecordFromDatabase()` throws exceptions at
        four different places with only one of them being catchable
        (:php:`DatabaseRecordException`) and the other three being
        top-level PHP built-in exceptions that indicate a developer / code
        usage error.

    *   Bad: The generic exception messages could be more verbose and
        explain in more detail on what went wrong.


Bad examples
============

*   :php:`\TYPO3\CMS\Core\Resource\FileRepository` method :php:`findFileReferenceByUid()`

    *   Bad: The top-level PHP built-in is caught.

        This is not a good idea
        and indicates something is wrong in the code that may throw this
        exception. A specific exception should be caught here only.

    *   Bad: Catching :php:`\RuntimeException`.

        This may hide more serious
        failures from an underlying library that should better have been
        bubbling up. The same holds for :php:`\Exception`.

    *   Bad: Catching this exception is used to change the return value of
        the method to false.

        This would make it a method that returns multiple different types.


Further readings
================

See `How to Design Exception Hierarchies <https://learn.microsoft.com/de-de/archive/blogs/kcwalina/how-to-design-exception-hierarchies>`__.
