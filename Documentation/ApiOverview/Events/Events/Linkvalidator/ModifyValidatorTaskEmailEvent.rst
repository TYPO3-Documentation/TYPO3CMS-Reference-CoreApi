..  include:: /Includes.rst.txt
..  index:: Events; ModifyValidatorTaskEmailEvent
..  _ModifyValidatorTaskEmailEvent:

=============================
ModifyValidatorTaskEmailEvent
=============================

The PSR-14 event
:php:`\TYPO3\CMS\Linkvalidator\Event\ModifyValidatorTaskEmailEvent`
can be used to manipulate the
:ref:`\\TYPO3\\CMS\\Linkvalidator\\Result\\LinkAnalyzerResult <ext_linkvalidator:linkvalidatorapi-LinkAnalyzerResult>`,
which contains all information from the linkvalidator API. Also the
:ref:`FluidEmail <mail-fluid-email>` object can be adjusted there. This allows
to pass additional information to the view by using :php:`$fluidEmail->assign()`
or dynamically adding mail information such as the receivers list. The added
values in the event take precedence over the :typoscript:`modTSconfig`
configuration. The event contains the full :typoscript:`modTSconfig`
to access further information about the actual configuration of the task when
assigning new values to `FluidEmail`.

..  note::
    As it is possible to set the recipient addresses dynamically using
    this event, the `email` field in the task configuration can remain empty but
    will be added, if defined, on top of already defined recipients from the
    event. All other values such as `subject`, `from` or `replyTo` will only be
    set according to :typoscript:`modTSconfig`, if not already defined through
    the event.


Example
=======

Registration of the event listener in the extension's :file:`Services.yaml`:

..  literalinclude:: _ModifyValidatorTaskEmailEvent/_Services.yaml
    :language: yaml
    :caption: EXT:my_extension/Configuration/Services.yaml

Read :ref:`how to configure dependency injection in extensions <dependency-injection-in-extensions>`.

An implementation of the event listener:

..  literalinclude:: _ModifyValidatorTaskEmailEvent/_MyEventListener.php
    :language: php
    :caption: EXT:my_extension/Classes/Linkvalidator/EventListener/MyEventListener.php

The :php:`\TYPO3\CMS\Linkvalidator\Result\LinkAnalyzerResult` contains the
following information by default:

:php:`$oldBrokenLinkCounts`
    Amount of broken links from the last run, separated by type
    (for example: all, internal)

:php:`$newBrokenLinkCounts`
    Amount of broken links from this run, separated by type
    (for example: all, internal)

:php:`$brokenLinks`
    List of broken links with the raw database row

:php:`$differentToLastResult`
    Whether the broken links count changed

The :php:`brokenLinks` property gets further processed internally to provide
additional information for the email. Following additional information is
provided by default:

:php:`full_record`
    The full record, the broken link was found in
    (for example: :sql:`pages` or :sql:`tt_content`)

:php:`record_title`
    Value of the :php:`full_record` title field

:php:`record_type`
    The title of the record type (for example: "Page" or "Page Content")

:php:`language_code`
    The language code of the broken link

:php:`real_pid`
    The real page ID of the record the broken link was found in

:php:`page_record`
    The whole page row of records parent page

More can be added using this PSR-14 event.

Additionally to the already existing content, the email now includes a list of
all broken links fetched according to the task configuration. This list consists
of following columns:

`Record`
    The :php:`record_uid` and :php:`record_title`

`Language`
    The :php:`language_code` and language ID

`Page`
    The :php:`real_pid` and :php:`page_record.title` of the parent page

`Record Type`
    The :php:`record_type`

`Link Target`
    The :php:`target`

`Link Type`
    Type of the broken link (either `internal`, `external` or `file`)


API
===

..  include:: /CodeSnippets/Events/Linkvalidator/ModifyValidatorTaskEmailEvent.rst.txt
