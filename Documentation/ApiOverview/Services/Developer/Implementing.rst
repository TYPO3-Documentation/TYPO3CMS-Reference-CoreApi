..  include:: /Includes.rst.txt
..  index:: Services API; Implementation
..  _services-developer-implementing:

======================
Implementing a service
======================

There are no tools to get you started coding a new service.
However there is not much that needs to be done.

A service should be packaged into an extension. The chapter
:ref:`Files and locations <extension-files-locations>` explains the minimal
requirements for an extension. The class file for your service should be
located in the :file:`Classes/Service` directory.

Finally the service registration is placed in the extension's
:file:`ext_localconf.php` file.


..  index:: Services API; Registration
..  _services-developer-implementing-registration:

Service registration
====================

Registering a service is done inside the :file:`ext_localconf.php`
file. Let's look at what is inside.

..  literalinclude:: _Implementing/_ext_localconf.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

A service is registered with TYPO3 CMS by calling
:code:`\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService()`.
This method takes the following parameters:

$extKey
    (string) The key of the extension containing the service.

$serviceType
    (string) Service type of the service. Choose something explicit.

$serviceKey
    (string) Unique key for the service. Choose something explicit.

$info
    (array) Additional information about the service:

    title
        (string) The title of the service.

    description
        (string) The description. If it makes sense it should contain information about

        -   the quality of the service (if it's better or not than normal)

        -   the OS dependency (either WIN or UNIX)

        -   the dependency on external programs (perl, pdftotext, etc.)

    subtype
        (string / comma-separated list) The subtype is not predefined.
        Its usage is defined by the API of the service type.

        **Example:**

        ..  code-block:: php

            'subtype' => 'jpg,tif'

    available
        (boolean) Defines if the service is available or not. This means that the
        service will be ignored if available is set to false.

        It makes no sense to set this to false, but it can be used to make a
        quick check if the service works on the system it is installed on:

        **Examples:**

        ..  code-block:: php

            // Is the curl extension available?
            'available' => function_exists('curl_exec'),

        Only quick checks are appropriate here. More extensive checks should
        be performed when the service is requested and the service class is
        initialized.

        Defaults to :code:`true`.

    priority
        (integer) The priority of the service. A service of higher priority will be
        selected first. Can be :ref:`reconfigured <services-configuration-registration-changes>`.

        Use a value from 0 to 100. Higher values are reserved for
        reconfiguration in local configuration. The default value is
        50 which means that the service is well implemented and gives normal
        (good) results.

        Imagine that you have two solutions, a pure PHP one and another that
        depends on an external program. The PHP solution should have a
        priority of 50 and the other solution a lower one. PHP-only solutions
        should have a higher priority since they are more convenient in terms
        of server setup. But if the external solution gives better results you
        should set both to 50 and set the quality value to a higher value.

    quality
        (integer/float) Among services with the same priority, the service with the highest
        quality but the same priority will be preferred.

        The use of the quality range is defined by the service type. Integer
        or floats can be used. The default range is 0-100 and the default
        value for a normal (good) quality service is 50.

        The value of the quality should represent the capacities of the
        services. Consider a service type that implements the detection of a
        language used in a text. Let's say that one service can detect 67
        languages and another one only 25. These values could be used directly
        as quality values.

    os
        (string) Defines which operating system is needed to run this service.

        **Examples:**

        ..  code-block:: php

            // runs only on UNIX
            'os' => 'UNIX',

            // runs only on Windows
            'os' => 'WIN',

            // no special dependency
            'os' => '',

    exec
        (string / comma-separated list) List of external programs which are needed to run the service.
        Absolute paths are allowed but not recommended, because the programs
        are searched for automatically by :code:`\TYPO3\CMS\Core\Utility\CommandUtility`.
        Leave empty if no external programs are needed.

        **Examples:**

        ..  code-block:: php

            'exec' => 'perl',

            'exec' => 'pdftotext',

    className
        (string) Name of the PHP class implementing the service.

        **Example:**

        ..  code-block:: php

            'className' => \Foo\Babelfish\Service\Translator::class


..  index:: Services API; AbstractService
..  _services-developer-implementing-php:

PHP class
=========

The PHP class corresponding to the registered service
should provide the methods mentioned in :ref:`Service Implementation
<services-developer-service-api-implementation>`.

It should then implement the methods that you defined
for your service's public API, plus whatever method is
relevant from the base TYPO3 CMS service API, which is
described in details in :ref:`the next chapter <services-developer-service-api>`.
