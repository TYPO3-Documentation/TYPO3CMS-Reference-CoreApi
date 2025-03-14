..  include:: /Includes.rst.txt
..  index::
    Extbase; Errors
    Extbase; errorAction
..  _extbase_error_action:

============
Error action
============

Extbase offers an out of the box handling for errors. Errors might occur during
the mapping of incoming action arguments. For example, an argument can not
be mapped or validation did not pass.

..  _extbase_error_action-howto:

How it works
============

#.  Extbase will try to map all arguments within :php:`ActionController`. During
    this process arguments will also be validated.

#.  If an error occurred, the class will call the :php:`$this->errorMethodName`
    instead of determined :php:`$this->actionMethodName`.

#.  The default is to call :php:`errorAction()` which will:

    #.  Clear cache in case :typoscript:`persistence.enableAutomaticCacheClearing` is
        activated and current scope is frontend.

    #.  Add an error :ref:`Flash Message <flash-messages>`
        by calling :php:`addErrorFlashMessage()`.
        It will in turn call :php:`getErrorFlashMessage()` to retrieve the
        message to show.

    #.  Return the user to the referring request URL. If no referrer exists, a plain text
        message will be displayed, fetched from
        :php:`getFlattenedValidationErrorMessage()`.
