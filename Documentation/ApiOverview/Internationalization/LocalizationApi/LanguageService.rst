.. include:: /Includes.rst.txt
.. _LanguageService-api:

===============
LanguageService
===============

This class is used to translate strings in plain PHP. For examples
see :ref:`extension-localization-php`. A :php:`LanguageService` **should not**
be created directly, therefore its constructor is internal. Create a
:php:`LanguageService` with the :ref:`LanguageServiceFactory-api`.

In the backend context a :php:`LanguageService` is stored in the global
variable :php:`$GLOBALS['LANG']`.

..  attention::
    During development you are usually logged into the backend. So the global
    variable :php:`$GLOBALS['LANG']` might be available in the frontend. Once
    logged out it is usually not available. **Never** depend on
    :php:`$GLOBALS['LANG']` in the frontend unless you know what you are doing.

..  include:: _phpdocs/LanguageService.rst.txt
