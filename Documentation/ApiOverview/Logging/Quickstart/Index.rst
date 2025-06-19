:navigation-title: Quickstart

..  include:: /Includes.rst.txt
..  index:: Logging; Quickstart
..  _logging-quickstart:

==========================================
Quickstart: Writing to the logger from PHP
==========================================

..  index::
    Logging; Instantiation
    Logging; LoggerInterface
..  _logging-quicksart-instantiate-logger:

Instantiate a logger for the current class
==========================================

:ref:`Constructor injection <Constructor-injection>` can be used to
automatically instantiate the logger:

..  literalinclude:: _MyClass.php
    :language: php
    :caption: EXT:my_extension/Classes/MyClass.php


..  _logging-quickstart-log:

..  index::
    Logging; Write to Log
    Logging; logger->log
    Logging; logger->error
    Logging; logger->warning

Log
===

Log a simple message (in this example with the log level "warning"):

..  code-block:: php
    :caption: EXT:my_extension/Classes/MyClass.php

    $this->logger->warning('Something went awry, check your configuration!');


Provide additional context information with the log message (in this example
with the log level "error"):

..  code-block:: php
    :caption: EXT:my_extension/Classes/MyClass.php

    $this->logger->error('Passing {value} was unwise.', [
        'value' => $value,
        'other_data' => $foo,
    ]);

Values in the message string that should vary based on the error (such as
specifying an invalid value) should use placeholders, denoted by
`{ }`.  Provide the value for that placeholder in the context array.

:php:`$this->logger->warning()` etc. are only shorthands - you can also call
:php:`$this->logger->log()` directly and pass the severity level:

..  code-block:: php
    :caption: EXT:my_extension/Classes/MyClass.php

    // use Psr\Log\LogLevel;

    $this->logger->log(LogLevel::CRITICAL, 'This is an utter failure!');


..  index::
    Logging; Output
    Logging; FileWriter

Set logging output
==================

TYPO3 has the :ref:`FileWriter <logging-writers-FileWriter>` enabled by default
for warnings (:php:`LogLevel::WARNING`) and higher severity, so all matching log
entries are written to a file.

If the filename is not set, then the file will contain a hash like

..  tabs::

    ..  group-tab:: Composer-based installation

        :file:`var/log/typo3_<hash>.log`, for example
        :file:`var/log/typo3_7ac500bce5.log`.

    ..  group-tab:: Classic mode installation (No Composer)

        :file:`typo3temp/var/log/typo3_<hash>.log`, for example
        :file:`typo3temp/var/log/typo3_7ac500bce5.log`.


A sample output looks like this:

..  code-block:: none

    Fri, 19 Jul 2023 09:45:00 +0100 [WARNING] request="5139a50bee3a1" component="TYPO3.Examples.Controller.DefaultController": Something went awry, check your configuration!
    Fri, 19 Jul 2023 09:45:00 +0100 [ERROR] request="5139a50bee3a1" component="TYPO3.Examples.Controller.DefaultController": Passing someValue was unwise. - {"value":"someValue","other_data":{}}
    Fri, 19 Jul 2023 09:45:00 +0100 [CRITICAL] request="5139a50bee3a1" component="TYPO3.Examples.Controller.DefaultController": This is an utter failure!
