.. include:: ../../../Includes.txt

.. _FormEngine-DataCompiling:

Data compiling
==============

This is the first step of FormEngine. The data compiling creates an array containing all data
the rendering needs to come up with a.result.

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

   * A processed version of :php:`$TCA['givenTable']` containing only those columns fields current user has access to.

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
   It may happen in future versions of FormEngine with core version 9, the responsibility for the main structure and integrity
   of the data array is moved away from :php:`FormDataCompiler` into the single :php:`FormDataGroup`. This may even obsolete
   the :php:`FormDataCompiler` altogether.


Data groups and providers
-------------------------

So we have this empty data array pre-set with data by a controller and then initialized by :php:`FormDataCompiler`,
which it hands over to a specific :php:`FormDataGroup`. What are these data providers now? Data providers are single
classes that add or change data within the data array. They are called in a chain after each other. A :php:`FormDataGroup` has
the responsibility to find out which specific single data providers should be used and calls them in a specific order.

.. figure:: ../../../Images/FormEngineDataCompiling.svg
   :alt: Data compiling by multiple providers

Why we need this?

   * Which data providers are relevant depends on the specific scope: For instance, if editing a full database based record,
     one provider fetches the according row from the database and initializes :php:`$data['databaseRow']`. But if flex form
     data is calculated, the flex form values fetched from table fields directly. So, while the :php:`DatabaseEditRow` data
     provider is needed in the first case, it's not needed or even counter productive in the second case.
     The FormDataGroup's are used to manage providers for specific scopes.

   * FormDataGroups know which providers should be used in a specific scope. They usually fetch a list of providers from
     some global configuration array. Extensions can add own providers in this configuration array for further data munging.

   * Single data providers have dependencies to each other and must be executed in a specific order. For Instance, the
     PageTsConfig of a record can only be determined if the rootline of a record has been determined, which can only happen
     after the pid of a given record has been consolidated, which relies on the record being fetched from database.
     This makes data providers a *linked list* and it is task of a :php:`FormDataGroup` to manage the correct order.

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
  from a global config. Used in the core at a couple of places where a small number of data providers should be called
  right away without being extensible.

.. note::
   It is a good idea set a breakpoint at the form data result returned by the DataCompiler and to have a look at
   the data array to get an idea on what is in this array after compiling.


Let's have a closer look at the data providers. The main :php:`TcaDatabaseRecord` group consists mostly of three parts:

Main record data and dependencies
  * Fetch record from DB or initialize a new row depending on :php:`$data['command']` being "new" or "edit", set row as :php:`$data['databaseRow']`
  * Add userTs and pageTsConnfig to data array
  * Add table TCA as :php:`$data['processedTca']`
  * Determine record type value
  * Fetch record translations and other details and add to data array

Single field processing
  * Process values and items of simple types like :php:`type=input`, :php:`type=radio`, :php:`type=check` and so on. Validate
    their :php:`databaseRow` values and validate and sanitize their :php:`processedTca` settings.
  * Process more complex types that may have relations to other tables like :php:`type=group` and :php:`type=select`, set
    possible selectable items in :php:`$data['processedTca']` of the according fields, sanitize their TCA settings.
  * Process :php:`type=inline` and :php:`type=flex` fields and prepare their child fields by using new instances of
    :php:`FormDataCompiler` and adding their result to :php:`$data['processedTca']`

Post process after single field values are prepared
  * Execute display conditions and remove fields from :php:`$data['processedTca']` that shouldn't be shown.
  * Determine main record title and set as :php:`$data['recordTitle']`


Extending data groups with own providers
----------------------------------------

The base set of DataProviders for all DataGroups is defined within :file:`typo3/sysext/core/Configuration/DefaultConfiguration.php`
in section :php:`['SYS']['formEngine']['formDataGroup']`, and ends up in variable :php:`$GLOBALS['TYPO3_CONF_VARS']` after core
bootstrap. The provider list can be read top-down, so the :php:`DependencyOrderingService` typically does not resort this
list to a different order.

Adding an own provider to this list means adding an array key to that array having a specification *where* the new data provider
should be added in the list. This is done by the arrays :php:`depends` and :php:`before`.

As an example, extension "news" uses an own data provider to do additional flex form data structure preparation. The core internal
flex preparation is already split into two providers: :php:`TcaFlexPrepare` determines the data structure and parses
it, :php:`TcaFlexProcess` uses the prepared data structure, processes values and applies defaults if needed. The data provider
from extension news hooks in between these two to add some own preparation stuff. The registration happens with this
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
  has a dependency to a removed provider, the :php:`DependencyOrderingService` which takes care of the sorting throws
  an exception. There is currently no good solution in the core on how to mitigate this issue.
