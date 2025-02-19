:navigation-title: ModuleData

.. include:: /Includes.rst.txt
.. index::
   Backend modules; Module data object
.. _backend-Module-data-object:

==================
Module data object
==================

The :php:`TYPO3\CMS\Backend\Module\ModuleData` object contains the user
specific module settings, for example whether the clipboard is shown,
for the requested module. Those settings
are fetched from the user's session. A PSR-15 middleware automatically
creates the object from the stored user data and attaches it to the PSR-7 Request.

The :php:`TYPO3\CMS\Backend\Module\ModuleData` object is available as
attribute of the PSR-7 Request - in case a TYPO3 backend module is requested -
and contains the stored module data, which might have been overwritten
through the current request (with :php:`GET` / :php:`POST`).

Through the module registration one can define, which properties can
be overwritten via :php:`GET` / :php:`POST` and their default value.

The whole determination is done before the requested route target - usually
a backend controller - is called. This means, the route target can
read the final module data.

The *allowed* properties are defined with their default value in the
:ref:`module registration <backend-modules-configuration>`:

.. code-block:: php
   :caption: EXT:my_extension/Configuration/Backend/Modules.php

   'moduleData' => [
       'allowedProperty' => '',
       'anotherAllowedProperty' => true,
   ],

.. code-block:: php
   :caption: EXT:my_extension/Classes/Controller/MyController.php

   $MOD_SETTINGS = $request->getAttribute('moduleData');

The :php:`ModuleData` object provides the following methods:

+-------------------------+-----------------------+----------------------------------------------------+
| Method                  | Parameters            | Description                                        |
+=========================+=======================+====================================================+
| createFromModule()      | :php:`$module`        | Create a new object for the given module, while    |
|                         | :php:`$data`          | overwriting the default values with :php:`$data`.  |
+-------------------------+-----------------------+----------------------------------------------------+
| getModuleIdentifier()   |                       | Returns the related module identifier              |
+-------------------------+-----------------------+----------------------------------------------------+
| get()                   | :php:`$propertyName`  | Returns the value for :php:`$propertyName`, or the |
|                         | :php:`$default`       | :php:`$default`, if not set.                       |
+-------------------------+-----------------------+----------------------------------------------------+
| set()                   | :php:`$propertyName`  | Updates :php:`$propertyName` with the given        |
|                         | :php:`$value`         | :php:`$value`.                                     |
+-------------------------+-----------------------+----------------------------------------------------+
| has()                   | :php:`$propertyName`  | Whether :php:`$propertyName` exists.               |
+-------------------------+-----------------------+----------------------------------------------------+
| clean()                 | :php:`$propertyName`  | Cleans a single property by the given allowed      |
|                         | :php:`$allowedValues` | list and falls back to either the default value    |
|                         |                       | or the first allowed value.                        |
+-------------------------+-----------------------+----------------------------------------------------+
| cleanUp()               | :php:`$allowedData`   | Cleans up all module data, which are defined in    |
|                         | :php:`$useKeys`       | the given allowed data list. Usually called with   |
|                         |                       | :php:`$MOD_MENU` in a controller with module menu. |
+-------------------------+-----------------------+----------------------------------------------------+
| toArray()               |                       | Returns the module data as :php:`array`.           |
+-------------------------+-----------------------+----------------------------------------------------+

In case a controller needs to store changed module data, this can still be done
using :php:`$backendUser->pushModuleData('my_module', $this->moduleData->toArray());`.

.. note::

   It is possible to store and retrieve arbitrary module data. The
   definition of :php:`moduleData` in the module registration only defines,
   which properties can be overwritten in a request (with :php:`GET` / :php:`POST`).

To restrict the values of module data properties, the given :php:`ModuleData`
object can be cleaned, for example, in a controller:

.. code-block:: php
   :caption: EXT:my_extension/Classes/Controller/MyController.php

   $allowedValues = ['foo', 'bar'];
   $this->moduleData->clean('property', $allowedValues);

If :php:`ModuleData` contains :php:`property`, the value is checked
against the :php:`$allowedValues` list. If the current value is valid,
nothing happens. Otherwise the value is either changed to the default
or if this value is also not allowed, to the first allowed value.
