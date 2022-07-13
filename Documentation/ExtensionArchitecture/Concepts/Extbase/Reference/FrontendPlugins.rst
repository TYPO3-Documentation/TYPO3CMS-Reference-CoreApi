.. include:: /Includes.rst.txt
.. index:: Extbase; Frontend plugin
.. _extbase_registration_of_frontend_plugins:

================================
Registration of frontend plugins
================================

In classical TYPO3 extensions, the frontend functionality is divided into
several frontend plugins. Normally each has a separate codebase.
In contrast, there is only one codebase in Extbase (a series of controllers and
actions). Nevertheless, it is possible to group controllers and actions
to make it possible to have multiple frontend plugins.

.. todo: This is real hard to understand for newbies. Why not just say that in TYPO3 there
are plugin content elements which can be placed on pages and that extbase allows
to define multiple plugins in one extension?

.. sidebar:: Why two files?

    You may wonder why you need to edit both, file :file:`ext_localconf.php` and file
    :file:`Configuration/TCA/Overrides/tt_content.php`, to configure a plugin. The reason lies in the architecture of TYPO3:
    file :file:`ext_localconf.php` is evaluated in the frontend and file :file:`Configuration/TCA/Overrides/tt_content.php` in
    the backend. Therefore, in file :file:`Configuration/TCA/Overrides/tt_content.php` we add the entry to the plugin list (for
    the backend). In addition, the list of controller / action combinations is required at runtime
    in the frontend - and therefore this must be defined in the file :file:`ext_localconf.php`.

    For further information, check out :ref:`Extension configuration files
    <t3coreapi:extension-configuration-files>`.

For the definition of a plugin, the files :file:`ext_localconf.php` and :file:`Configuration/TCA/Overrides/tt_content.php`
have to be adjusted.

In :file:`ext_localconf.php` resides the definition of permitted controller action
Combinations. Also here you have to define which actions should not be cached.
In :file:`Configuration/TCA/Overrides/tt_content.php` there is only the configuration of the plugin selector for the
backend. Let's have a look at the following two files:

.. todo: We could mention that registering plugins in the backend is optional and that a plugin content
element is just some internal wrapper code that triggers a TypoScript USER object rendering.

.. code-block:: php
   :caption: EXT:my_extension/ext_localconf.php

    $pluginName = 'ExamplePlugin';
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'my_extension',
        $pluginName,
        $controllerActionCombinations,
        $uncachedActions
    );

The allowed combinations of the controller and actions are determined in
addition to the extension key and the plugin's unique name (lines 3 and 4).
`$controllerActionCombinations` is an associative array. This array's keys
are the allowed controller classes, and the values are a comma-separated list of
allowed actions per controller. The first action of the first controller is the
default action.

Additionally, you need to specify which actions should not be cached. To do this,
the fourth parameter also is a list of controller action Combinations in the
same format as above, containing all the non-cached-actions.

.. todo: Instead of explaining an arbitrary configuration format, why not just provide
an example here? Who wouldn't expect example code here but parse the text?
Maybe refer to the example further down or rip that apart and show the relevant
configuration right here?

:file:`Configuration/TCA/Overrides/tt_content.php`:

.. code-block:: php
   :caption: EXT:my_extension/Configuration/TCA/Overrides/tt_content.php

   \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
       'my_extension',
       'ExamplePlugin',
       'Title used in Backend'
   );

The first two arguments must be completely identical to the definition in
:file:`ext_localconf.php`.

Below there is a complete configuration example for the registration of a
frontend plugin within the files :file:`ext_localconf.php` and :file:`Configuration/TCA/Overrides/tt_content.php`.

*Example B-1: Configuration of an extension in the file ext_localconf.php*

.. code-block:: php
   :caption: EXT:my_extension/ext_localconf.php

   \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
       'my_extension',
       'Blog',
       [
           \Vendor\ExampleExtension\Controller\BlogController::class => 'index,show,new,create,delete,deleteAll,edit,update,populate',
           \Vendor\ExampleExtension\Controller\PostController::class => 'index,show,new,create,delete,edit,update',
           \Vendor\ExampleExtension\Controller\CommentController::class => 'create',
       ],
       [
           \Vendor\ExampleExtension\Controller\BlogController::class => 'delete,deleteAll,edit,update,populate',
           \Vendor\ExampleExtension\Controller\PostController::class => 'show,delete,edit,update',
           \Vendor\ExampleExtension\Controller\CommentController::class => 'create',
       ]
   );

*Example B-2: Configuration of an extension in the file Configuration/TCA/Overrides/tt_content.php*

.. code-block:: php
   :caption: EXT:my_extension/Configuration/TCA/Overrides/tt_content.php

   \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
       'my_extension',
       'Blog',
       'A Blog Example',
       'EXT:blog/Resources/Public/Icons/Extension.svg'
   );

The plugin name is ``Blog``. The name must be the same
in :file:`ext_localconf.php` and
:file:`Configuration/TCA/Overrides/tt_content.php`. The default called method is
:php:`indexAction()` of controller class
:php:`Vendor\ExampleExtension\Controller\BlogController` since it's the first
element defined in the array and the first action in the list.

All actions which change data must not be cacheable. Above, this is for example
the :php:`deleteAction()` action in the
:php:`Vendor\ExampleExtension\Controller\BlogController` controller. In the
backend, you can see "*A Blog Example*" in the list of plugins (see Figure B-1).

.. todo: "All actions which change data" is quite non-explanatory here. What data?
It's important to understand that cacheable plugins are executed once and
that its content is then stored in the page cache, resulting in no code
execution at all. This also affects dynamically changing meta tags and such
via plugins. It's not just about domain data.

.. figure::  /Images/ManualScreenshots/b-ExtbaseReference/figure-b-1.png
    :align: center

    Figure B-1: In the selection field for frontend plugins, the name which was defined in the
    file :file:`Configuration/TCA/Overrides/tt_content.php` will be displayed
