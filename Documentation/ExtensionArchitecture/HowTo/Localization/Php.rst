.. include:: /Includes.rst.txt
.. index::
   Localization; PHP
.. _extension-localization-php:

====================
Localization in PHP
====================

Sometimes you have to localize a string in PHP code, for
example inside of a controller or a user function.

Which method of localization to use depends on the current context:

..  contents::
    :local:

Localization in plain PHP
=========================

Localization in frontend context
--------------------------------

In plain PHP use the class :ref:`LanguageServiceFactory <LanguageServiceFactory-api>`
to create a :ref:`LanguageService <LanguageService-api>` from the current
site language:

..  literalinclude:: _php/MyUserFunction.php
    :caption: EXT:my_extension/Classes/UserFunction/MyUserFunction.php

:ref:`DependencyInjection` should be available in most contexts where you need
translations. Also the current request is available in entry point such as
custom non-Extbase controllers, user functions, data processors etc.

Localization in backend context
-------------------------------

In the backend context you should use the
:ref:`LanguageServiceFactory <LanguageServiceFactory-api>`
to create the required :ref:`LanguageService <LanguageService-api>`.

..  literalinclude:: _php/MyBackendClass.php
    :caption: EXT:my_extension/Classes/Backend/MyBackendClass.php

..  attention::
    During development you are usually logged into the backend. So the global
    variable :php:`$GLOBALS['LANG']` might be available in the frontend. Once
    logged out it is usually not available. **Never** depend on
    :php:`$GLOBALS['LANG']` in the frontend unless you know what you are doing.

Localization without context
----------------------------

If you should happen to be in a context where none of these are available,
for example a static function, you can still do translations:

..  literalinclude:: _php/MyUtility.php
    :caption: EXT:my_extension/Classes/Utility/MyUtility.php

.. _extension-localization-extbase:

Localization in Extbase
=======================

In :ref:`Extbase <extbase>` context you can use the method
:ref:`\\TYPO3\\CMS\\Extbase\\Utility\\LocalizationUtility::translate($key, $extensionName) <extbase-localization-utility-api>`.

This method requires the localization key as the first and the extension's
name as optional second parameter. For all available parameters
see :ref:`below <extbase-localization-utility-api>`. Then the corresponding
text in the current language will be loaded from this extension's
:file:`locallang.xlf` file.

The method :php:`translate()` takes translation overrides from TypoScript into
account. See :ref:`localization-typoscript-LOCAL_LANG`.

Example
-------

In this example the content of the flash message to be displayed in the backend
gets translated:

..  code-block:: php
    :caption: Class T3docs\Examples\Controller\ModuleController

    use Psr\Http\Message\ResponseInterface;
    use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
    use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

    class ModuleController extends ActionController implements LoggerAwareInterface
    {
        /**
         * Adds a count of entries to the flash message
         */
        public function countAction(string $tablename = 'pages'): ResponseInterface
        {
            $count = $this->tableInformationService->countRecords($tablename);

            $message = LocalizationUtility::translate(
                key: 'record_count_message',
                extensionName: 'examples',
                arguments: [$count, $tablename]
            );

            $this->addFlashMessage(
                messageBody: $message,
                messageTitle: 'Information',
                severity: ContextualFeedbackSeverity::INFO
            );
            return $this->redirect('flash');
        }
    }

The string in the translation file is defined like this:

..  literalinclude:: _php/locallang.xlf
    :language: xml
    :emphasize-lines: 8

The :php:`arguments` will be replaced in the localized strings by
the `PHP function sprintf <https://www.php.net/manual/en/function.sprintf.php>`__.

This behaviour is the same like in a
:ref:`Fluid translate ViewHelper with arguments <extension-localization-fluid>`.



