..  include:: /Includes.rst.txt

..  index::
    Request attribute; ModuleData
..  _typo3-request-attribute-module-data:

==========
ModuleData
==========

The :php:`moduleData` backend request attribute is available when a backend
module is requested. It holds the object :php:`\TYPO3\CMS\Backend\Module\ModuleData`
which contains the stored module data that might have been overwritten through
the current request (with `GET`/`POST`).

Through the module registration one can define, which properties can be
overwritten via `GET`/`POST` and their default value.

The whole determination is done before the requested route target - usually a
backend controller - is called. This means, the route target can just read the
final module data.

..  note::
    It is still possible to store and retrieve arbitrary module data. The
    definition of `moduleData` in the module registration only defines, which
    properties can be overwritten in a request (with GET/POST).

To restrict the values of module data properties, the given :php:`ModuleData`
object can be cleaned, for example, in a controller:

..  code-block:: php

    $allowedValues = ['foo', 'bar'];
    $this->moduleData->clean('property', $allowedValues);

If :php:`ModuleData` contains :php:`property`, the value is checked against the
:php:`$allowedValues` list. If the current value is valid, nothing happens.
Otherwise the value is either changed to the default or if this value is also
not allowed, to the first allowed value.


API
===

..  include:: /CodeSnippets/Manual/Entity/ModuleData.rst.txt
