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
In the frontend a :php:`LanguageService` can be accessed via the contentObject:

..  include:: _LanguageService.rst.txt

Example: Use
========

..  literalinclude:: _ExampleController.php
    :caption: EXT:my_extension/Classes/Controller/ExampleController.php (not Extbase)
