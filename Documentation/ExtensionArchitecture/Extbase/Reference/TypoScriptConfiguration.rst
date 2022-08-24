.. include:: /Includes.rst.txt

.. index:: Extbase; TypoScript configuration
.. _extbase_typoscript_configuration:

========================
TypoScript configuration
========================

Each Extbase extension has some settings which can be modified using TypoScript.
Many of these settings affect aspects of the internal configuration of Extbase
and Fluid. There is also a block :typoscript:`settings` in which you can
set extension specific settings that can be accessed in the controllers and
templates of your extension.

All TypoScript settings are made in the following TypoScript blocks:

.. code-block:: typoscript
   :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

   plugin.tx_[lowercasedextensionname]

The TypoScript configuration of the extension is always located below this
TypoScript path. The "lowercase extension name" is the extension key with no
underscore (_), as for example in ``blogexample``. The configuration is divided into
the following sections:


.. _extbase_typoscript_configuration-features:
.. _extbase_features-skipDefaultArguments:
.. _extbase_features-ignoreAllEnableFieldsInBe:
.. _extbase_features-requireCHashArgumentForActionArguments:
.. _extbase_features-consistentTranslationHandling:

Features
--------

Activate features for Extbase or a specific plugin.

`features.skipDefaultArguments`
    Skip default arguments in URLs. If a link to the default controller or action is created, the
    parameters are omitted.
    Default is `false`.

`features.ignoreAllEnableFieldsInBe`
    Ignore the enable fields in backend.
    Default is `false`.

.. _extbase_typoscript_configuration-persistence:
.. _extbase_persistence-enableAutomaticCacheClearing:

Persistence
-----------

Settings, relevant to the persistence layer of Extbase.

`persistence.enableAutomaticCacheClearing`
    Enables the automatic cache clearing when changing data sets (see also the
    section :ref:`extbase_caching_of_actions_and_records`).
    Default is `true`.

`persistence.storagePid`
    List of Page-IDs, from which all records are read (see the section
    ":ref:`Procedure to fetch objects <procedure_to_fetch_objects>`" in Chapter 6).


.. _extbase_typoscript_configuration-settings:

Settings
--------

Here reside are all the domain-specific extension settings. These settings are
available in the controllers as the array variable `$this->settings` and in any Fluid
template with `{settings}`.

.. todo: domain-specific? Not really. Settings holds all the settings, both extension-wide and plugin-specific.

.. tip::

    The settings allow you to pass arbitrary information to a template, even for 3rd-party extensions.
    Just make sure you prefix them with a unique vendor to prevent collisions with further updates
    of the extensions.

.. _extbase_typoscript_configuration-view:

View
----

View and template settings.

`view.layoutRootPaths`
    This can be used to specify the root paths for all Fluid layouts in this
    extension. If nothing is specified, the path
    :file:`extensionName/Resources/Private/Layouts` is used. All layouts that are necessary
    for this extension should reside in this folder.

`view.partialRootPaths`
    This can be used to specify the root paths for all Fluid partials in this
    extension. If nothing is specified, the path
    :file:`extensionName/Resources/Private/Partials` is used. All partials that are
    necessary for this extension should reside in this folder.

`view.pluginNamespace`
    This can be used to specify an alternative namespace for the plugin.
    Use this to shorten the Extbase default plugin namespace or to access
    arguments from other extensions by setting this option to their namespace.
    .. todo: This is not understandable without an example. This option might be deprecated and dropped.

`view.templateRootPaths`
    This can be used to specify the root paths for all Fluid templates in this
    extension. If nothing is specified, the path
    :file:`extensionName/Resources/Private/Templates` is used. All layouts that are necessary
    for this extension should reside in this folder.

All root paths are defined as an array which enables you to define multiple root paths that
will be used by Extbase to find the desired template files.

An example best describes the feature.
Imagine you installed the extension `news`, which provides several plugins for
rendering news in the frontend.

The default template directory of that extension is the following:
:file:`EXT:my_extension/Resources/Private/Templates/`.

Let's assume you want to change the plugin's output because you need to use
different CSS classes, for example. You can simply create your own extension and
add the following TypoScript setup:

.. code-block:: typoscript
   :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

   plugin.tx_news {
       view {
           templateRootPaths.10 = EXT:my_extension/Resources/Private/Templates/
       }
   }

As all TypoScript will be merged, the following configuration will be compiled:

.. code-block:: typoscript
   :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

    plugin.tx_news {
        view {
            templateRootPaths {
                0 = EXT:news/Resources/Private/Templates/
                10 = EXT:my_extension/Resources/Private/Templates/
            }
            ...
        }
    }

Imagine there is a news plugin that lists news entries. In that case, the `listAction` method
of the `NewsController` will be called. By convention, Extbase will look for an html file
called `List.html` in a folder `News` in all of the configured template root paths.

If there is just one root path configured, that is the one being chosen right away. Once there
are more paths defined, Extbase will check them in reverse order, i.e., from the highest key
to lowest. Following our example, Extbase will check the given path with key `10` first, and if
no template file is found, it will proceed with `0`.

.. tip::

   If there is no root path defined at all, a fallback path will be created during runtime.
   The fallback path consists of the extension key and a fixed directory path.

.. todo: We should mention that there is no typoscript created during runtime. Fluid is
   Checking the given configuration and falls back to specific paths which should
   be mentioned here. `EXT:extension/Resources/Private/{Templates/Partials/Layouts}`

More information on root paths can be found in the TypoScript reference:
:ref:`t3tsref:cobj-fluidtemplate-properties-templaterootpaths`


.. _extbase_typoscript_configuration-mvc:

MVC
---

These are useful MVC settings about error handling:

`mvc.callDefaultActionIfActionCantBeResolved`
    Will cause the controller to show its default action
    , e.g., if the called action is not allowed by the controller.

`mvc.throwPageNotFoundExceptionIfActionCantBeResolved`
    Same as `mvc.callDefaultActionIfActionCantBeResolved`
    but this will raise a "page not found" error.

.. todo: It's important to mention that this settings takes precedence. If enabled, setting
   mvc.callDefaultActionIfActionCantBeResolved is without any effect.

.. _extbase_typoscript_configuration-local_lang:

_LOCAL_LANG
-----------

Under this key, you can modify localized strings for this extension.
If you specify, for example, `plugin.tx_blogexample._LOCAL_LANG.default.read_more =
More>>` then the standard translation for the key `read_more` is overwritten by the
string *More>>*.


.. _extbase_format:

Format
------

The output of Extbase plugins can be provided in different formats, e.g., HTML, CSV,
JSON, …. The required format can be requested via the request parameter. The default
format, if nothing is requested, can be set via TypoScript. This can be combined
with conditions.

.. todo: That's no desired behavior any more. It's been a myth from the beginning
   that by simply changing a format param, the action con automagically
   deliver the content in different types. This MUST be a clear decision
   of the user. This format param needs to be deprecated and removed.
   Users need to manually route different output formats to specific
   controller actions.

`format`
   Defines the default format for the plugin.
