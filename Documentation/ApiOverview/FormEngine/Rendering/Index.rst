.. include:: /Includes.rst.txt
.. index:: FormEngine; Rendering
.. _FormEngine-Rendering:

=========
Rendering
=========

This is the second step of the processing chain: The rendering part gets the data array prepared
by :php:`FormDataCompiler` and creates a result array containing HTML, CSS and JavaScript. This
is then post-processed by a controller to feed it to the :php:`PageRenderer` or to create an Ajax
response.

The rendering is a tree: The controller initializes this by setting one :php:`container` as :php:`renderType`
entry point within the data array, then hands over the full data array to the :php:`NodeFactory` which looks
up a class responsible for this :php:`renderType`, and calls render() on it. A container class creates only
a fraction of the full result, and delegates details to another container. The second one does another detail
and calls a third one. This continues to happen until a single field should be rendered, at which point an
element class is called taking care of one element.

.. figure:: /Images/Plantuml/FormEngine/FormEngineRenderTree.svg
   :alt: Render tree example

Each container creates some "outer" part of the result, calls some sub-container or element, merges the
sub-result with its own content and returns the merged array up again. The data array is given to each sub class
along the way, and containers can add further render relevant data to it before giving it "down". The data array
can *not* be given "up" in a changed way again. Inheritance of a data array is always top-bottom. Only HTML, CSS
or JavaScript created by a sub-class is returned by the sub-class "up" again in a "result" array of a specified
format.

..  literalinclude:: _SomeContainer.php
    :language: php
    :caption: EXT:my_extension/Classes/Containers/SomeContainer.php

Above example lets :php:`NodeFactory` find and compile some data from "subContainer", and merges the child result
with its own. The helper methods :php:`initializeResultArray()` and :php:`mergeChildReturnIntoExistingResult()`
help with combining CSS and JavaScript.

An upper container does not directly create an instance of a sub node (element or container) and never calls it
directly. Instead, a node that wants to call a sub node only refers to it by a name, sets this name into the data
array as :php:`$data['renderType']` and then gives the data array to the :php:`NodeFactory` which determines
an appropriate class name, instantiates and initializes the class, gives it the data array, and calls :php:`render()`
on it.

.. _FormEngine-Rendering-ClassInheritance:

Class Inheritance
=================

..  figure:: /Images/Plantuml/FormEngine/FormEngineRenderClasses.svg
    :alt: Main render class inheritance

All classes must implement :php:`NodeInterface` to be routed through the :php:`NodeFactory`. The :php:`AbstractNode`
implements some basic helpers for nodes, the two classes :php:`AbstractContainer` and :php:`AbstractFormElement`
implement helpers for containers and elements respectively.

The call concept is simple: A first container is called, which either calls a container below or a single element. A
single element never calls a container again.


.. _FormEngine-Rendering-NodeFactory:

NodeFactory
===========

The :php:`NodeFactory` plays an important abstraction role within the render chain: Creation of child nodes is
always routed through it, and the NodeFactory takes care of finding and validating the according class that
should be called for a specific :php:`renderType`. This is supported by an API that allows registering *new*
renderTypes and overriding *existing* renderTypes with own implementations. This is true for *all* classes,
including containers, elements, fieldInformation, fieldWizards and fieldControls. This means the child routing
can be fully adapted and extended if needed. It is possible to transparently "kick-out" a Core container and to
substitute it with an own implementation.

For example, the TemplaVoila implementation needs to add additional render capabilities of the FlexForm rendering
to add for instance an own multi-language rendering of flex fields. It does that by overriding the default
flex container with own implementation:

..  literalinclude:: _ext_localconf_flex.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

This re-routes the :php:`renderType` "flex" to an own class. If multiple registrations for a single renderType exist,
the one with highest priority wins.

..  note::
    The :php:`NodeFactory` uses :php:`$data['renderType']`.
    A couple of TCA fields actively use this renderType. However, it is important to understand the renderType is *only*
    used within the FormEngine and :php:`type` is still a must-have setting for columns fields in TCA. Additionally,
    :php:`type` can *not* be overridden in :php:`columnsOverrides`. Basically, :php:`type` specifies how the DataHandler
    should put data into the database, while :php:`renderType` specifies how a single field is rendered. This additionally
    means there can exist multiple different renderTypes for a single type, and it means it is possible to invent a new
    renderType to render a single field differently, but still let the DataHandler persist it the usual way.


Adding a new renderType in :file:`ext_localconf.php`

..  literalinclude:: _ext_localconf.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

And use it in TCA for a specific field, keeping the full database functionality in DataHandler together with the
data preparation of FormDataCompiler, but just routing the rendering of that field to the new element:

..  literalinclude:: _tx_cooltagcloud.php
    :language: php
    :caption: EXT:cool_tag_cloud/Configuration/TCA/overrides/tx_cooltagcloud.php

The above examples are a static list of nodes that can be changed by settings in :file:`ext_localconf.php`. If that
is not enough, the :php:`NodeFactory` can be extended with a resolver that is called dynamically for specific renderTypes.
This resolver gets the full current data array at runtime and can either return :php:`NULL` saying "not my job", or return
the name of a class that should handle this node.

An example of this are the Core internal rich text editors. Both "ckeditor" and "rtehtmlarea" register a resolver class
that are called for node name "text", and if the TCA config enables the editor, and if the user has enabled rich text
editing in his user settings, then the resolvers return their own :php:`RichTextElement` class names to render a given text
field:

..  literalinclude:: _ext_localconf_rte.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

The trick here is that CKEditor registers his resolver with a higher priority (50) than "rtehtmlarea" (40), so the
"ckeditor" resolver is called first and wins if both extensions are loaded and if both return a valid class name.


.. _FormEngine-Rendering-ResultArray:

Result Array
============

Each node, no matter if it is a container, an element, or a :ref:`node expansion <FormEngine-Rendering-NodeExpansion>`,
must return an array with specific data keys it wants to add. It is the job of the parent node that calls the sub node to
merge child node results into its own result. This typically happens by merging :php:`$childResult['html']`
into an appropriate position of own HTML, and then calling :php:`$this->mergeChildReturnIntoExistingResult()` to add
other array child demands like :php:`stylesheetFiles` into its own result.

Container and element nodes should use the helper method :php:`$this->initializeResultArray()` to
have a result array initialized that is understood by a parent node.

Only if extending existing element via :ref:`node expansion <FormEngine-Rendering-NodeExpansion>`, the result array
of a child can be slightly different. For instance, a :php:`FieldControl` "wizards" must have a :php:`iconIdentifier`
result key key. Using :php:`$this->initializeResultArray()` is not appropriate in these cases but depends on the specific
expansion type. See below for more details on node expansion.

The result array for container and element nodes looks like this.
:php:`$resultArray = $this->initializeResultArray()` takes care of basic keys:

..  code-block:: php

    [
        'html' => '',
        'additionalInlineLanguageLabelFiles' => [],
        'stylesheetFiles' => [],
        'javaScriptModules' => $javaScriptModules,
        /** @deprecated requireJsModules will be removed in TYPO3 v13.0 */
        'requireJsModules' => [],
        'inlineData' => [],
        'html' => '',
    ]

CSS and language labels (which can be used in JS) are added with their file
names in format :php:`EXT:my_extension/path/to/file`.

..  note::
    Nodes must never add assets like JavaScript or CSS using the
    :php:`PageRenderer`. This fails as soon as this container / element /
    wizard is called via Ajax, for instance within inline. Instead,
    those resources must be registered via the result array only,
    using :php:`stylesheetFiles` and :php:`javaScriptModules`.

Adding JavaScript modules
-------------------------

JavaScript is added as ES6 modules using the
function :php:`JavaScriptModuleInstruction::create()`.

You can for example use it in a container:

..  literalinclude:: _SomeContainerJavaScript.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/SomeContainer.php

Or a controller:

..  literalinclude:: _SomeController.php
    :language: php
    :caption: EXT:my_extension/Classes/Backend/Controller/SomeController.php

.. _FormEngine-Rendering-NodeExpansion:

Node Expansion
==============

The "node expansion" classes :php:`FieldControl`, :php:`FieldInformation` and :php:`FieldWizard` are called by containers
and elements and allow "enriching" containers and elements. Which enrichments are called can be configured via TCA.

FieldInformation
    Additional information. In elements, their output is shown between the field label and the element itself. They can
    not add functionality, but only simple and restricted HTML strings. No buttons, no images. An example usage could be
    an extension that auto-translates a field content and outputs an information like "Hey, this field was auto-filled
    for you by an automatic translation wizard. Maybe you want to check the content".

FieldWizard
    Wizards shown below the element. "enrich" an element with additional functionality. The localization wizard and
    the file upload wizard of :php:`type=group` fields are examples of that.

FieldControl
    "Buttons", usually shown next to the element. For :php:`type=group` the "list" button and the "element browser" button
    are examples. A field control *must* return an icon identifier.

Currently, all elements usually implement all three of these, except in cases where it does not make sense. This API allows
adding functionality to single nodes, without overriding the whole node. Containers and elements can come with default
expansions (and usually do). TCA configuration can be used to add own stuff. On container side the implementation is still
basic, only :php:`OuterWrapContainer` and :php:`InlineControlContainer` currently implement FieldInformation and FieldWizard.

See the :ref:`TCA reference ctrl section <t3tca:ctrl-reference-container>` for more information on how to configure these
for containers in TCA.

The `InputTextElement` (standard input element) demonstrates how different wizards are loaded and integrated:

..  literalinclude:: _InputTextElement.php
    :language: php
    :caption: EXT:backend/Classes/Form/Element/InputTextElement.php

This element defines three wizards to be called by default. The :php:`renderType` concept is re-used, the
values :php:`localizationStateSelector` are registered within the :php:`NodeFactory` and resolve to class names. They
can be overridden and extended like all other nodes. The :php:`$defaultFieldWizards` are merged with TCA settings
by the helper method :php:`renderFieldWizards()`, which uses the :php:`DependencyOrderingService` again.

It is possible to:

*   Override existing expansion nodes with own ones from extensions, even using the resolver mechanics is possible.
*   It is possible to disable single wizards via TCA
*   It is possible to add own expansion nodes at any position relative to the other nodes by specifying "before" and
    "after" in TCA.


Add fieldControl Example
========================

To illustrate the principals discussed in this chapter see the following
example which registers a fieldControl (button) next to a field in the pages
table to trigger a data import via Ajax.

Add a new renderType in :file:`ext_localconf.php`:

..  literalinclude:: _ext_localconf_fieldcontrol.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

Register the control in :file:`Configuration/TCA/Overrides/pages.php`:


..  literalinclude:: _pages.php
    :language: php
    :caption: EXT:my_extension/Configuration/TCA/Overrides/pages.php

..  note::
    The `fieldControl identifier` must be unique.

Add the PHP class for rendering the control in
:file:`Classes/FormEngine/FieldControl/ImportDataControl.php`:

..  literalinclude:: _ImportDataControl.php
    :language: php
    :caption: EXT:my_extension/Classes/FormEngine/FieldControl/ImportDataControl.php

..  todo: switch from RequireJS to ES6

..  attention::
    This example is still in RequireJS. RequireJS has been deprecated with
    TYPO3 v12. Help us transferring the example into ES6.
    See :ref:`h2document:contribute`.

Add the JavaScript for defining the behavior of the control in
:file:`Resources/Public/JavaScript/ImportData.js`:

..  literalinclude:: _ImportData.js
    :language: js
    :caption: EXT:my_extension/Resources/Public/JavaScript/ImportData.js

Add an Ajax route for the request in
:file:`Configuration/Backend/AjaxRoutes.php`:

..  literalinclude:: _AjaxRoutes.php
    :language: php
    :caption: EXT:my_extension/Configuration/Backend/AjaxRoutes.php

Add the Ajax controller class in
:file:`Classes/Controller/Ajax/ImportDataController.php`:

..  literalinclude:: _ImportDataController.php
    :language: php
    :caption: EXT:my_extension/Classes/Controller/Ajax/ImportDataController.php
