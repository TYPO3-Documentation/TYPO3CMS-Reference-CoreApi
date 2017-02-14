.. include:: ../../../Includes.txt

.. _FormEngine-Rendering:

Rendering
=========

This is the second step of the processing chain: The rendering part gets the data array prepared
by :php:`FormDataCompiler` and creates a result array containing HTML, CSS and JavaScript. This
is then post-processed by a controller to feed it to the :php:`PageRenderer` or to create an ajax
response.

The rendering is a tree: The controller intitializes this by setting one :php:`container` as :php:`renderType`
entry point within the data array, then hands over the full data array to the :php:`NodeFactory` which looks
up a class responsible for this :php:`renderType`, and calls render() on it. A container class creates only
a fraction of the full result, and delegates details to another container. The second one does another detail
and calls a third one. This continues to happen until a single field should be rendered, at which point an
element class is called taking care of one element.

.. figure:: ../../../Images/FormEngineRenderTree.svg
   :alt: Render tree example

Each container creates some "outer" part of the result, calls some sub-container or element, merges the
sub-result with its own content and returns the merged array up again. The data array is given to each sub class
along the way, and containers can add further render relevant data to it before giving it "down". The data array
can *not* be given "up" in a changed way again. Inheritance of a data array is always top-bottom. Only HTML, CSS
or JavaScript created by a sub-class is returned by the sub-class "up" again in a "result" array of a specified
format.

.. code-block:: php

    class SomeContainer extends AbstractContainer
    {
        public function render()
        {
            $result = $this->initializeResultArray();
            $data = $this->data;
            $data['renderType'] = 'subContainer';
            $childArray = $this->nodeFactory->create($data)->render();
            $resultArray = $this->mergeChildReturnIntoExistingResult($result, $childArray, false);
            $result['html'] = '<h1>A headline</h1>' . $childArray['html'];
            return $result;
        }
    }

Above example lets :php:`NodeFactory` find and compile some data from "subContainer", and merges the child result
with its own. The helper methods :php:`initializeResultArray()` and :php:`mergeChildReturnIntoExistingResult()`
help with combining CSS and JavaScript.

An upper container does not directly create an instance of a sub node (element or container) and never calls it
directly. Instead, a node that wants to call a sub node only refers to it by a name, sets this name into the data
array as :php:`$data['renderType']` and then gives the data array to the :php:`NodeFactory` which determines
an appropriate class name, instantiates and initializes the class, gives it the data array, and class :php:`render()`
on it.


Class inheritance
-----------------

.. figure:: ../../../Images/FormEngineRenderClasses.svg
   :alt: Main render class inheritance

All classes must implement :php:`NodeInterface` to be routed through the :php:`NodeFactory`. The :php:`AbstractNode`
implements some basic helpers for nodes, the two classes :php:`AbstractContainer` and :php:`AbstractFormElement`
implement helpers for containers and elements respectively.

The call concept is simple: A first container is called, which either calls a container below or a single element. A
single element never calls a container again.


NodeFactory
-----------

The :php:`NodeFactory` plays an important abstraction role within the render chain: Creation of child nodes is
always routed through it, and the NodeFactory takes care of finding and validating the according class that
should be called for a specific :php:`renderType`. This is supported by an API that allows registering *new*
renderTypes and overriding *existing* renderTypes with own implementations. This is true for *all* classes,
including containers, elements, fieldInformation, fieldWizards and fieldControls. This means the child routing
can be fully adapted and extended if needed. It is possible to transparently "kick-out" a core container and to
substitute it with an own implementation.

As example, the TemplaVoila implementation needs to use additional render capabilities of the flex form rendering
and adds for instance an own multi-language rendering of flex fields. It does that by overriding the default
flex container with own implementations:

.. code-block:: php

    // Default registration of "flex" in NodeFactory:
    // 'flex' => \TYPO3\CMS\Backend\Form\Container\FlexFormEntryContainer::class,

    // Register language aware flex form handling in FormEngine
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1443361297] = [
        'nodeName' => 'flex',
        'priority' => 40,
        'class' => \TYPO3\CMS\Compatibility6\Form\Container\FlexFormEntryContainer::class,
    ];

This re-routes the :php:`renderType` "flex" to an own class. If multiple registrations for a single renderType exist,
the one with highest priority wins.

.. note::
   The :php:`NodeFactory` uses :php:`$data['renderType']`. This has been introduces with core version 7 in TCA, and
   a couple of TCA fields actively use this renderType. However, it is important to understand the renderType is *only*
   used within the FormEngine and :php:`type` is still a must-have setting for columns fields in TCA. Additionally,
   :php:`type` can *not* be overridden in :php:`columnsOverrides`. Basically, :php:`type` specifies how the DataHandler
   should put data into the database, while :php:`renderType` specifies how a single field is rendered. This additionally
   means there can exist multiple different renderTypes for a single type, and it means it is possible to invent a new
   renderType to render a single field differently, but still let the DataHandler persist it the usual way.


Adding a new renderType in :file:`ext_localconf.php`

.. code-block:: php

    // Add new field type to NodeFactory
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1487112284] = [
        'nodeName' => 'selectTagCloud',
        'priority' => '70',
        'class' => \MyVendor\CoolTagCloud\Form\Element\SelectTagCloudElement::class,
    ];

And use it in TCA for a specific field, keeping the full functionality of "select" but just routing the rendering
of that field to the new element:

.. code-block:: php

    $GLOBALS['TCA']['myTable']['columns']['myField'] = [
        'label' => 'Cool Tag cloud',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectTagCloud',
            'foreign_table' => 'availableTags',
        ],
    ];


The above examples are a static list of nodes that can be changed by settings in :file:`ext_localconf.php`. If that
is not enough, the :php:`NodeFactory` can be extended with a resolver that is called dynamically for specific renderTypes.
This resolver gets the full current data array at runtime and can either return nothing saying "not my job", or return
the name of a class that should handle this node.

An example of this are the core internal rich text editors. Both "ckeditor" and "rtehtmlarea" register a resolver class
that are called for node name "text", and if the TCA config enables the editor, and if the user has enabled rich text
editing in his user settings, then the resolvers return their own :php:`RichTextElement` class names to render a given text
field:

.. code-block:: php

    // Register FormEngine node type resolver hook to render RTE in FormEngine if enabled
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeResolver'][1480314091] = [
        'nodeName' => 'text',
        'priority' => 50,
        'class' => \TYPO3\CMS\RteCKEditor\Form\Resolver\RichTextNodeResolver::class,
    ];

The trick is here that "ckeditor" registers his resolver with ah higher priority (50) than "rtehtmlarea" (40), so the
"ckeditor" resolver is called first and wins if both extensions are loaded and if both return a valid class name.


Result array
------------

The array returned by every node looks like:

.. code-block:: php

    [
        'html' => '',
        'additionalInlineLanguageLabelFiles' => [],
        'stylesheetFiles' => [],
        'requireJsModules' => [],
    ]

CSS and language labels (which can be used in JS) are added with their file names in format :php:`EXT:extName/path/to/file`.
JavaScript is added only via requireJs modules, the registration allows an init method to be called if the
module is loaded.

.. note::
   The result array actually contains a couple of more fields, but those will vanish with further FormEngine refactoring
   steps. If using them, be prepared to adapt extensions later.


Node expansion
--------------

The "node expansion" classes :php:`FieldControl`, :php:`FieldInformation` and :php:`FieldWizard` are called by containers
and elements and allow "enriching" containers and elements. Which enrichments are called can be configured via TCA.

This API is the substitution of the old "TCA wizards array" and has been introduced with core version 8.

FieldInformation
  Additional information. In elements, their output is shown between the field label and the element itself. They can
  not add functionality, but only simple and restricted HTML strings. No buttons, no images.

FieldWizard
  Wizards shown below the element. "enrich" an element with additional functionality. The localization wizard and
  the file upload wizard of :php:`type=group` fields are examples of that.

FieldControl
  "Buttons", usually shown next to the element. For :php:`type=group` the "list" button and the "element browser" button
  are an example. A field control *must* return an icon identifier.

Currently, all elements usually implement all three of these, except in cases where it does not make sense. This API allows
adding functionality to single nodes, without overriding the whole node. Containers and elements can come with default
expansions (and usually do), and TCA can be used to add own stuff. On container side, the :php:`OuterWrapContainer` and the
:php:`InlineControlContainer` currently implement the FieldInformation and the FieldWizard.

Example. The :php:`InputTextElement` (standard input element) defines a couple of default wizards and embeds them in its
main result HTML:

.. code-block:: php

    class InputTextElement extends AbstractFormElement
    {
        protected $defaultFieldWizard = [
            'localizationStateSelector' => [
                'renderType' => 'localizationStateSelector',
            ],
            'otherLanguageContent' => [
                'renderType' => 'otherLanguageContent',
                'after' => [
                    'localizationStateSelector'
                ],
            ],
            'defaultLanguageDifferences' => [
                'renderType' => 'defaultLanguageDifferences',
                'after' => [
                    'otherLanguageContent',
                ],
            ],
        ];

        public function render()
            $resultArray = $this->initializeResultArray();

            $fieldWizardResult = $this->renderFieldWizard();
            $fieldWizardHtml = $legacyFieldWizardHtml . $fieldWizardResult['html'];
            $resultArray = $this->mergeChildReturnIntoExistingResult($resultArray, $fieldWizardResult, false);

            $mainFieldHtml = [];
            $mainFieldHtml[] = '<div class="form-control-wrap">';
            $mainFieldHtml[] =  '<div class="form-wizards-wrap">';
            $mainFieldHtml[] =      '<div class="form-wizards-element">';
            // Main HTML of element done here ...
            $mainFieldHtml[] =      '</div>';
            $mainFieldHtml[] =      '<div class="form-wizards-items-bottom">';
            $mainFieldHtml[] =          $fieldWizardHtml;
            $mainFieldHtml[] =      '</div>';
            $mainFieldHtml[] =  '</div>';
            $mainFieldHtml[] = '</div>';

            $resultArray['html'] = implode(LF, $mainFieldHtml);
            return $resultArray;
        }
    }

This element defines three wizards to be called by default. The :php:`renderType` concept is re-used, the
values :php:`localizationStateSelector` are registered within the :php:`NodeFactory` and resolve to class names. They
can be overridden and extended like all other nodes. The :php:`$defaultFieldWizards` are merged with TCA settings
by the helper method :php:`renderFieldWizards()`, which uses the :php:`DependencyOrderingService` again.

It is possible to:

  * Override existing expansion nodes with own ones from extensions, even using the resolver mechanics is possible.
  * It is possible to disable single wizards via TCA
  * It is possible to add own expansion nodes at any position relative to the other nodes by specifying "before" and
    "after" in TCA.