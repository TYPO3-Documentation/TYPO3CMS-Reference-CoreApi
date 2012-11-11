.. include:: ../../../Includes.txt


.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.


.. _viewport:

Backend Viewport
^^^^^^^^^^^^^^^^

The TYPO3 backend is structured with an ExtJS viewport. This makes
it easy to display various panels in different parts of the user
interface and to resize those parts.

The viewport is defined in the files found in :file:`typo3/js/extjs/viewport*`.
It consists of a configuration file and the viewport component code itself.
The viewport component is an extension of the :code:`Ext.Viewport` component,
meaning you can use all methods and functionalities from that component.


.. _viewport-structure:

Viewport Structure
""""""""""""""""""

The viewport is structured in the following way:

+--------------------------------------------------------+
| Top Menu                                               |
+--------------------------------------------------------+
| +----------------------------------------------------+ |
| | +-------------+-------------------+--------------+ | |
| | | Module Menu | Navigation Widget | Content Area | | |
| | +-------------+-------------------+--------------+ | |
| +----------------------------------------------------+ |
| | Debug Panel                                        | |
| +----------------------------------------------------+ |
+--------------------------------------------------------+


.. _viewport-navigation:

Navigation Components
"""""""""""""""""""""

It is possible to add custom components like a navigation tree,
information box or whatever else to the navigation container of the viewport.
This can be achieved for any backend module with a simple
call to the registration API inside the :file:`ext_tables.php` of an extension.

The registration method) takes two required parameters:

# Module name
# Component id and event name (see below for the details)

::

   t3lib_extMgm::addNavigationComponent('tools_Examples', 'typo3-navigation');



Additionally for an Extbase module, usage of a navigation component must
be declared in the options list (notice the highlighted line below):

.. code-block:: php
   :linenos:
   :emphasize-lines: 14,14

   Tx_Extbase_Utility_Extension::registerModule(
   	$_EXTKEY,
   	'tools', // Make module a submodule of 'Admin Tools'
   	'examples', // Submodule key
   	'', // Position
   	array(
   			// An array holding the controller-action-combinations that are accessible
   		'Default' => 'flash'
   	),
   	array(
   		'access' => 'user,group',
   		'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Images/moduleIcon.png',
   		'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml',
   		'navigationComponentId' => 'typo3-navigation'
   	)
   );


The directory structure is predefined. This means that there is no additional
information to pass in the registration call. On the other hand the necessary files
must fit the defined paths (the structure below is that of the "examples" extension
and starts with the extension's folder):

::

   - examples
   |- components
      |- navigation
         |- css
         |- javascript


The "components" directory contains all navigation components of your module.
Any files inside the "css" and "javascript" directories are automatically loaded
during backend initialization. The components themselves are created lazily.

The component's very own folder must be named without the "typo3-" prefix
(i.e. "navigation" in the example above).

One of the JavaScript files **must contain** the following code to create the component
if requested. Example (taken from :file:`EXT:examples/components/navigation/javascript/Navigation.js`):

.. code-block:: javascript

   Ext.ns('TYPO3.Navigation');

   TYPO3.Navigation.Navigator = Ext.extend(Ext.Panel, {
   	id: 'typo3-navigation',
   	html: 'Hello World!'
   });

   TYPO3.ModuleMenu.App.registerNavigationComponent('typo3-navigation', function() {
   	return new TYPO3.Navigation.Navigator();
   });


The created component's id is the component name with the given prefix.


.. _viewport-global-navigation:

Global Navigation Components
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If you have written a navigation component that should be used
by a whole group of modules sharing the same prefix like "web" or "tools",
just register the component like this:

::

   t3lib_extMgm::addNavigationComponent('web', 'typo3-pagetree');


Anything else is like above. It is still possible to use more specialized navigation components
for the submodules of such a group.


.. _viewport-loading:

Loading Order
~~~~~~~~~~~~~

It may be necessary to set the loading order of CSS and JavaScript files.
This can be achieved by creating a file called loadingOrder.txt in the
designated directory. This file will contain the names of all other files
in the needed order.

It is not necessary to define all files, umentioned ones will be loaded
following natural order.


.. _viewport-extending:

Extending the Viewport
""""""""""""""""""""""

You can extend the TYPO3 viewport yourself if you need some special configuration options.
The next example demonstrates this by adding a collapse/expand functionality to the module menu.

.. warning::
   The example below works in that it achieves its aim,
   but breaks the rest of the TYPO3 backend. If someone knows
   how to make it work properly, your help is very welcome.


First a class must be declared to use the "render-preProcess" hook of the
:code:`t3lib_pageRenderer` class (in the :file:`ext_localconf.php` file):

::

   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][] =
     'EXT:' . $_EXTKEY . '/Classes/Utilities/Viewport.php:Tx_Examples_Utilities_Viewport->renderPreProcess';


Then here is the class itself (as usual taken from the "examples" extension):

::

   public function renderPreProcess($parameters, $pageRenderer) {
   	$pageRenderer->addExtOnReadyCode('
   		Ext.apply(TYPO3.Viewport.configuration.items[1], {
   			split: true,
   			collapsible: true,
   			collapseMode: "mini",
   			hideCollapseTool: true,
   			animCollapse: false
   		});',
   		true
   	);
   }


.. _viewport-debug:

Debug Console
"""""""""""""

The debug console is located inside the debug panel position at the south of the viewport.
It's based upon an extended ExtJS tabPanel component. A new tab can be added to the debug console
by calling :code:`t3lib_utility_Debug::debug()`:

::

   t3lib_utility_Debug::debug('New debug console message', 'Title', 'My new tab');


It seems possible to also manipulate the debug console with JavaScript, but working
examples are missing for now (examples from the TYPO3 wiki don't work (anymore?)).
