.. include:: /Includes.rst.txt


.. _examples-clipboard:
.. _examples-clipboard-put:

=========
Clipboard
=========

.. note::
   The class :php:`\TYPO3\CMS\Backend\Clipboard\Clipboard` is marked
   :php:`@internal`. It is a specific Backend implementation and is not
   considered part of the Public TYPO3 API. It might change without notice.

You can easily access the internal clipboard in TYPO3 from your
backend modules:

.. include:: /CodeSnippets/Examples/Clipboard/DebugClipboard.rst.txt


In this simple piece of code we instantiate a clipboard object and make it
load its content. We then simply dump this content into the BE module's debug
window, with the following result:

.. include:: /Images/AutomaticScreenshots/Examples/Clipboard/ClipboardDump.rst.txt

This tells us what objects are registered on the default tab ("normal")
(a content element with id 216 in "copy" mode) and the numeric tabs (which can
each contain more than one element). It also tells us that the current
tab is number 2. We can compare with the BE view of the clipboard:

.. include:: /Images/AutomaticScreenshots/Examples/Clipboard/ClipboardContent.rst.txt

which indeed contains two files.

Clipboard content should not be accessed directly, but using the
:code:`elFromTable()` method of the clipboard object:

.. include:: /CodeSnippets/Examples/Clipboard/GetCurrentClipboard.rst.txt

Here we first try to get all files and then all page records on the
current pad (which is pad 2). Then we change to the "Normal" pad, call
the :code:`elFromTable()` method again.

In the "examples" extension, this data is passed to a BE module view
for display, which is really just information:


.. include:: /Images/AutomaticScreenshots/Examples/Clipboard/ClipboardItems.rst.txt
