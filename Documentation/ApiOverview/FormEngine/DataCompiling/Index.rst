.. include:: /Includes.rst.txt
.. index:: FormEngine; Data compiling
.. _FormEngine-DataCompiling:

==============
Data compiling
==============

This is the first step of FormEngine. The data compiling creates an array containing all data
the rendering needs to come up with a result.

A basic call looks like this:

.. code-block:: php

   $formDataGroup = GeneralUtility::makeInstance(TcaDatabaseRecord::class);
   $formDataCompiler = GeneralUtility::makeInstance(FormDataCompiler::class, $formDataGroup);
   $formDataCompilerInput = [
      'tableName' => $table,
      'vanillaUid' => (int)$theUid,
      'command' => $command,
   ];
   $formData = $formDataCompiler->compile($formDataCompilerInput);

The above code is a simplified version of the relevant part of the :php:`EditDocumentController`. This controller
knows by its :code:`GET` or :code:`POST` parameters which record ("vanillaUid") of which specific table ("tableName")
should be edited (command="edit") or created (command="new"), and sets this as init data to the DataCompiler. The
controller also knows that it should render a full database record and not only parts of it, so it uses the
:php:`TcaDatabaseRecord` data provider group to trigger all data providers relevant for this case. By calling :php:`->compile()`
on this data group, all providers configured for this group are called after each other, and :php:`formData` ends up
with a huge array of data record details.


So, what happens here in detail?

* Variable :php:`$formDataCompilerInput` maps input values to keys specified by :php:`FormDataCompiler` as "init" data.

* FormDataCompiler returns a unified array of data. This array is enriched by single data providers.

* A data provider group is a list of single data providers for a specific scope and enriches the array with information.

* Each data provider is called by the DataGroup to add or change data in the array.


The variable :php:`$formData` roughly consists of this data after calling :php:`$formDataCompiler->compile()`:

* A validated and initialized list of current database row field variables.

* A processed version of :php:`$TCA['givenTable']` containing only those column fields a current user has access to.

* A processed list of items for single fields like select and group types.

* A list of relevant localizations.

* Information of expanded :code:`inline` record details if needed.

* Resolved flex form data structures and data.

* A lot more


Basic goal of this step is to create an array in a specified format with all data needed by the render-part of FormEngine.
A controller initializes this with init data, and then lets single data providers fetch additional data and write it
to the main array. The deal is here that the data within that array is *not* structured in an arbitrary way, and each single
data provider only adds data the render part of FormEngine understands and needs later. This is why the main array keys are restricted:
The main array is initialized by :php:`FormDataCompiler`, and each :php:`DataProvider` can only add data to sub-parts of that array.

.. note::
   The main data array is prepared by :php:`FormDataCompiler`, each key is well documented in this class. To find out
   which data is expected to reside in this array, those comments are worth a look.

.. note::
   It may happen in future versions of FormEngine (core version 9+) that the responsibility for the main structure and integrity
   of the data array will be moved away from :php:`FormDataCompiler` into the single :php:`FormDataGroup` class. This may even make
   the :php:`FormDataCompiler` obsolete in total.


Data Groups and Providers
=========================

So we have this empty data array, pre-set with data by a controller and then initialized by :php:`FormDataCompiler`,
which in turn hands over the data array to a specific :php:`FormDataGroup`. What are these data providers now? Data providers are
single classes that add or change data within the data array. They are called in a chain after each other. A :php:`FormDataGroup`
has the responsibility to find out, which specific single data providers should be used, and calls them in a specific order.

.. figure:: ../../../Images/FormEngineDataCompiling.svg
   :alt: Data compiling by multiple providers

Why do we need this?

* Which data providers are relevant depends on the specific scope: For instance, if editing a full database based record,
  one provider fetches the according row from the database and initializes :php:`$data['databaseRow']` . But if flex form
  data is calculated, the flex form values are fetched from table fields directly. So, while the :php:`DatabaseEditRow` data
  provider is needed in the first case, it's not needed or even counter productive in the second case.
  The :php:`FormDataGroup`'s are used to manage providers for specific scopes.

* FormDataGroups know which providers should be used in a specific scope. They usually fetch a list of providers from
  some global configuration array. Extensions can add own providers to this configuration array for further data munging.

* Single data providers have dependencies to each other and must be executed in a specific order. For Instance, the
  PageTsConfig of a record can only be determined, if the rootline of a record has been determined, which can only happen
  after the pid of a given record has been consolidated, which relies on the record being fetched from the database.
  This makes data providers a *linked list* and it is the task of a :php:`FormDataGroup` to manage the correct order.

Main data groups:

TcaDatabaseRecord
  List of providers used if rendering a database based record.

FlexFormSegment
  List of data providers used to prepare flex form data and flex form section container data.

TcaInputPlaceholderRecord
  List of data providers used to prepare placeholder values for :php:`type=input` and :php:`type=text` fields.

InlineParentRecord
  List of data providers used to prepare data needed if an inline record is opened from within an ajax call.

OnTheFly
  A special data group that can be initialized with a list of to-execute data providers directly. In contrast to the
  others, it does not resort the data provider list by its dependencies and does not fetch the list of data providers
  from a global config. Used in the core at a couple of places, where a small number of data providers should be called
  right away without being extensible.

.. note::
   It is a good idea to set a breakpoint at the form data result returned by the DataCompiler and to have a look at
   the data array to get an idea of what this array contains after compiling.


Let's have a closer look at the data providers. The main :php:`TcaDatabaseRecord` group consists mostly of three parts:

Main record data and dependencies:

* Fetch record from DB or initialize a new row depending on :php:`$data['command']` being "new" or "edit", set row as :php:`$data['databaseRow']`
* Add userTs and pageTsConfig to data array
* Add table TCA as :php:`$data['processedTca']`
* Determine record type value
* Fetch record translations and other details and add to data array

Single field processing:

* Process values and items of simple types like :php:`type=input`, :php:`type=radio`, :php:`type=check` and so on. Validate
  their :php:`databaseRow` values and validate and sanitize their :php:`processedTca` settings.
* Process more complex types that may have relations to other tables like :php:`type=group` and :php:`type=select`, set
  possible selectable items in :php:`$data['processedTca']` of the according fields, sanitize their TCA settings.
* Process :php:`type=inline` and :php:`type=flex` fields and prepare their child fields by using new instances of
  :php:`FormDataCompiler` and adding their results to :php:`$data['processedTca']`.

Post process after single field values are prepared:

* Execute display conditions and remove fields from :php:`$data['processedTca']` that shouldn't be shown.
* Determine main record title and set as :php:`$data['recordTitle']`


Extending Data Groups With Own Providers
========================================

The base set of DataProviders for all DataGroups is defined within :file:`typo3/sysext/core/Configuration/DefaultConfiguration.php`
in section :php:`['SYS']['formEngine']['formDataGroup']`, and ends up in variable :php:`$GLOBALS['TYPO3_CONF_VARS']` after core
bootstrap. The provider list can be read top-down, so the :php:`DependencyOrderingService` typically does not resort this
list to a different order.

Adding an own provider to this list means adding an array key to that array having a specification *where* the new data provider
should be added in the list. This is done by the arrays :php:`depends` and :php:`before`.

As an example, the extension "news" uses an own data provider to do additional flex form data structure preparation. The core internal
flex preparation is already split into two providers: :php:`TcaFlexPrepare` determines the data structure and parses
it, :php:`TcaFlexProcess` uses the prepared data structure, processes values and applies defaults if needed. The data provider
from the extension "news" hooks in between these two to add some own preparation stuff. The registration happens with this
code in :file:`ext_localconf.php`:

.. code-block:: php

    // Modify flexform fields since core 8.5 via formEngine: Inject a data provider
    // between TcaFlexPrepare and TcaFlexProcess
    if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 8005000) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord']
        [\GeorgRinger\News\Backend\FormDataProvider\NewsFlexFormManipulation::class] = [
            'depends' => [
                \TYPO3\CMS\Backend\Form\FormDataProvider\TcaFlexPrepare::class,
            ],
            'before' => [
                \TYPO3\CMS\Backend\Form\FormDataProvider\TcaFlexProcess::class,
            ],
        ];
    }

This is pretty powerful since it allows extensions to hook in additional stuff at any point of the processing chain, and
it does not depend on the load order of extensions.

Limitations:

* It is not easily possible to "kick out" an existing provider if other providers have dependencies to them - which is
  usually the case.

* It is not easily possible to substitute an existing provider with an own one.

.. note::
  It may happen that the core splits or deletes the one or the other DataProvider in the future. If then an extension
  has a dependency to a removed provider, the :php:`DependencyOrderingService`, which takes care of the sorting, throws
  an exception. There is currently no good solution in the core on how to mitigate this issue.

.. note::
  Data providers in general should not know about :php:`renderType`, but only about :php:`type`. Their goal is to prepare
  and sanitize data independent of a specific :php:`renderType`. At the moment, the core data provider just has one
  or two places, where specific :php:`renderType`'s are taken into account to process data, and those show that these areas
  are a technical debt that should be changed.


Adding Data to Data Array
=========================

Most custom data providers change or add existing data within the main data array. A typical use case is an additional
record initialization for specific fields in :php:`$data['databaseRow']` or additional items somewhere within
:php:`$data['processedTca']`. The main data array is documented in :php:`FormDataCompiler->initializeResultArray()`.

Sometimes, own DataProviders need to add additional data that does not fit into existing places. In those cases they
can add stuff to :php:`$data['customData']`. This key is not filled with data by core DataProviders and serves as a place
for extensions to add things. Those data components can be used in own code parts of the rendering later. It is advisable
to prefix own data in :php:`$data['customData']` with some unique key (for instance the extension name) to not collide
with other data that a different extension may add.


Disable Single FormEngine Data Provider
=======================================

Single data providers used in the FormEngine data compilation step can be disabled to allow extension authors to substitute
existing data providers with their solutions.

As an example, if editing a full database record, the default `TcaCheckboxItems` could be removed by setting
:php:`disabled` in the :php:`tcaDatabaseRecord` group in an extension's :file:`ext_localconf.php` file:

.. code-block:: php

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord']
    [\TYPO3\CMS\Backend\Form\FormDataProvider\TcaCheckboxItems::class]['disabled'] = true;

Extension authors can then add an own data provider, which :php:`depends`
on the disabled one and is configured as :php:`before` the
next one. Therefore effectively substituting single providers with their
solution if needed.
