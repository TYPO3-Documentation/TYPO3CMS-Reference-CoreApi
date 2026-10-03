..  include:: /Includes.rst.txt
..  index:: Exceptions; DebugExceptionHandler
..  _error-handling-debug-exception-handler:

=======================
Debug exception handler
=======================

Functions of :php:`\TYPO3\CMS\Core\Error\DebugExceptionHandler`:

-  Shows detailed exception messages and full trace of an exception.

-  Logs exception messages via the :ref:`TYPO3 logging framework <logging>`.

-  Logs exception messages to the `sys_log` table. Logged errors are displayed
   in the belog extension (:guilabel:`Administration > Log`). This will work only if there is
   an existing DB connection.

..  _error-handling-debug-exception-handler-copy:

Copying a stack trace for a bug report
======================================

..  versionadded:: 14.2
    :changelog: feature-106153-1770150965

A trace can leave the browser as text, so a report needs neither a
screenshot nor a saved HTML file. The header of the page carries two
buttons, and every file in the trace carries a third:

..  figure:: /Images/ManualScreenshots/ErrorHandling/exception-header-copy-path.png
    :alt: Exception page with the buttons Toggle details and Copy plaintext
        stack trace in its header, and a Copy path button beside the first
        file of the trace
    :zoom: lightbox

    The buttons the debug exception handler adds

:guilabel:`Toggle details`
    Hides the file contents of every entry and brings them back, which
    turns the trace into a short overview.

:guilabel:`Copy plaintext stack trace`
    Copies the whole trace as text, without the file contents.

:guilabel:`Copy path`
    Copies that one file and its line number as `path/to/File.php:42`, with
    the project path cut off the front, so the result can be pasted into an
    editor that resolves paths from the project root.

A callout at the end of the trace says the same in the page itself, and asks
you to look through the text for anything sensitive before passing it on.

Copying to the clipboard needs a secure context. Over plain HTTP a browser
such as Firefox refuses it, the button then reports that it could not copy,
and :guilabel:`Copy plaintext stack trace` writes the text into a box on the
page instead, already selected to be copied by hand.
