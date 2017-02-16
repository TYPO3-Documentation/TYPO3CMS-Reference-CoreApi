.. include:: ../../../Includes.txt





.. _ajax:

=========================
AJAX in the TYPO3 Backend
=========================

In TYPO3 4.2 a new model for writing AJAX code in the TYPO3 Backend
was introduced. Although there were some parts in the TYPO3 Backend
that used AJAX already, they are now unified into a single interface
that handles errors and dispatches the different calls to their final
locations. This way it is ensured that e.g. a BE user is logged in and
all TYPO3 variables are loaded.

The whole architecture builds on top of successful techniques
developers already know. It's a mixture between the eID concept from
the TYPO3 Frontend, the hooking idea we know from other places in
TYPO3, piped through the single entrypoint file :file:`index.php?ajaxID=foobar` that
creates a PHP AJAX object to see if an error occurred or not. If
something went wrong, the X-JSON header is set to false and the
client-side AjaxRequestHandler will know that there is an error.


.. toctree::
   :titlesonly:

   Presentation/Index
   Backend/Index


