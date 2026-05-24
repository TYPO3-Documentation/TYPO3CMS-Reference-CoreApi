:navigation-title: Property mapping

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Property mapping
..  _extbase-controller-propertymapping:

==============================================
Property mapping: request arguments to objects
==============================================

Property mapping is the process by which Extbase converts raw request
arguments — strings, integers and arrays from the URL or form body — into typed PHP
values and domain objects before they reach an action method.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-controller-propertymapping-how:

How Extbase property mapping works
==================================

When a request arrives, Extbase inspects the type declaration of each action
parameter and runs the matching type converter:

*   A parameter typed :php:`int` or :php:`string` is cast directly.
*   A parameter typed as a domain object (for example :php:`Conference`)
    receives a :abbr:`UID (unique identifier, the primary key of a TYPO3 database record)`
    from the request. Extbase loads the corresponding record from the repository
    and passes the :abbr:`hydrated (an object populated with values loaded from the database)`
    object.
*   A parameter typed as a
    `\DateTime <https://www.php.net/manual/en/class.datetime.php>`_ or
    `\DateTimeImmutable <https://www.php.net/manual/en/class.datetimeimmutable.php>`_
    parses the string value according to a configurable format.

If conversion fails — for example because the UID does not exist in the
database — Extbase calls :php:`errorAction()` instead of the action method.


..  _extbase-controller-propertymapping-trusted:

Mass assignment protection and the trusted-properties token
===========================================================

To prevent
`mass assignment <https://owasp.org/www-project-web-security-testing-guide/latest/4-Web_Application_Security_Testing/07-Input_Validation_Testing/20-Testing_for_Mass_Assignment>`_
attacks, Extbase only writes properties that have been explicitly
allowlisted. When a form is built with :html:`<f:form>`, this allowlisting
happens **automatically and transparently**: the ViewHelper generates a
:php:`__trustedProperties` token — an
:abbr:`HMAC (Hash-based Message Authentication Code)`-signed list of every
field rendered in the form. On submission, Extbase reads the token, verifies
its signature, and permits exactly those properties. Whether to allow
creation or modification of a persistent object is also derived from the
token automatically, based on whether an :php:`__identity` field is present.

For the standard Extbase workflow — Fluid form → controller action — no
additional configuration is needed. If your request does not originate from
a :html:`<f:form>` (URL parameters, hand-built forms, JSON payloads), see
:ref:`extbase-controller-propertymapping-allowproperties`.


..  _extbase-controller-propertymapping-typeconverters:

Configuring Extbase type converters
===================================

Each type converter exposes configuration constants that you can set via
:php:`setTypeConverterOption()`. The most common example is adjusting the
date format for
:php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter;

    public function initializeCreateAction(): void
    {
        $this->arguments['conference']
            ->getPropertyMappingConfiguration()
            ->forProperty('conferenceDate')
            ->setTypeConverterOption(
                DateTimeConverter::class,
                DateTimeConverter::CONFIGURATION_DATE_FORMAT,
                'd.m.Y',
            );
    }

TYPO3 ships type converters for common scalar types, date/time, arrays,
integers, floats, and persistent objects. Extensions can register additional
converters.

..  seealso::

    *   `Built-in type converters reference <https://docs.typo3.org/permalink/extbase-appendix-typeconverters>`_
        — all converters, their source/target types, and configuration constants.

    *   `Writing a custom type converter <https://docs.typo3.org/permalink/extbase-appendix-typeconverters-custom>`_
        — how to implement and register a converter for your own types.


..  _extbase-controller-propertymapping-allowproperties:

Manually allowing properties on Extbase action arguments
========================================================

Manual allowlisting is only needed when the request does **not** carry a
:php:`__trustedProperties` token — for example when receiving URL parameters
directly, processing a custom form that omits the ViewHelper, or consuming a
JSON payload. If you are using :html:`<f:form>`, you do not need this.

Define a method named :php:`initialize` + the capitalized action name. Extbase
calls it automatically before the action:

..  literalinclude:: _snippets/_ConferenceControllerInitialize.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

Key methods on
:php-short:`\TYPO3\CMS\Extbase\Mvc\Controller\MvcPropertyMappingConfiguration`:

:php:`allowProperties('title', 'conferenceDate')`
    Allows an explicit list of properties and denies everything else. Prefer
    this over :php:`allowAllProperties()` when the set of fields is known
    upfront.

:php:`allowAllProperties()`
    Allows every property of the argument. Use with care — it trusts all
    submitted field names for this argument.

:php:`allowAllPropertiesExcept('uid', 'pid')`
    Allows everything except the listed properties.

For nested objects (for example a :php:`Conference` that has a related
:php:`Speaker`), use :php:`forProperty()` to reach into the sub-object:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    $mappingConfig = $this->arguments['conference']->getPropertyMappingConfiguration();
    $mappingConfig->allowProperties('title', 'speaker');
    $mappingConfig->forProperty('speaker')->allowProperties('name');

If you hit the symptom of a domain object arriving with all properties at
their default values even though the form contained data, see
:ref:`extbase-appendix-pitfalls-property-mapping-denied` in the common
pitfalls appendix.


..  _extbase-controller-propertymapping-creation-modification:

Allowing creation and modification of nested Extbase objects
============================================================

When a request (without a :php:`__trustedProperties` token) submits a nested
object that does not yet have a UID (creation) or has a UID and additional
fields (modification), you must explicitly unlock those operations on the
:php-short:`\TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/Controller/ConferenceController.php

    use TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter;

    public function initializeCreateAction(): void
    {
        $speakerConfig = $this->arguments['conference']
            ->getPropertyMappingConfiguration()
            ->forProperty('speaker');

        $speakerConfig->setTypeConverterOption(
            PersistentObjectConverter::class,
            PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED,
            true,
        );

        $speakerConfig->setTypeConverterOption(
            PersistentObjectConverter::class,
            PersistentObjectConverter::CONFIGURATION_MODIFICATION_ALLOWED,
            true,
        );
    }

..  seealso::

    *   `Extbase validation <https://docs.typo3.org/permalink/extbase-validation>`_
        — validation rules on action parameters and model properties via
        :php:`#[Validate]` attributes.

    *   `errorAction: Extbase validation and argument-mapping errors <https://docs.typo3.org/permalink/extbase-controller-action-error>`_
        — what happens when property mapping or validation fails.
