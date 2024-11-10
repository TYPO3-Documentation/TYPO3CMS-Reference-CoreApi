..  include:: /Includes.rst.txt
..  index:: Extbase; Frontend plugin
..  _extbase_registration_of_frontend_plugins:

================================
Registration of frontend plugins
================================

When you want to use Extbase controllers in the frontend you need to define a
so called :ref:`frontend plugin <t3coreapi:frontend_plugin>`.
Extbase allows to define multiple frontend plugins
for different use cases within one extension.

A frontend plugin can be defined as
:ref:`content element <extbase_frontend_plugin_content_element>` or as pure
:ref:`TypoScript frontend plugin <extbase_frontend_plugin_typoscript>`.

Content element plugins can be added by editors to pages in the :guilabel:`Page`
module while TypoScript frontend plugin can only be added via TypoScript or
Fluid in a predefined position of the page. All content element plugins can
also be used as TypoScript plugin.

..  _extbase_frontend_plugin_content_element:

Frontend plugin as content element
==================================

..  figure:: /Images/ManualScreenshots/Extbase/NewPlugin.png
    :class: with-shadow

    The plugins in the :guilabel:`New Content Element` wizard

Use the following steps to add the plugin as content element:

..  rst-class:: bignums

#.  :php:`configurePlugin()`: Make the plugin available in the frontend

    ..  literalinclude:: _FrontendPlugin/_ext_localconf.php
        :language: php
        :caption: EXT:blog_example/ext_localconf.php
        :linenos:

    Use the following parameters:

    #.  Extension key :php:`'blog_example'` or name :php:`BlogExample`.
    #.  A unique identifier for your plugin in UpperCamelCase: :php:`'PostSingle'`
    #.  An array of allowed combinations of controllers and actions stored in an array
    #.  (Optional) an array of controller name and  action names which should not be cached
    #.  Using any value but `ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT` is
        deprecated in TYPO3 v13.4.

    ..  deprecated:: 13.4
        Setting the fifth parameter to any value but `ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT`
        is deprecated. See :ref:`plugins-list_type-migration`.

    :php:`TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin()` generates
    the necessary TypoScript to display the plugin in the frontend.

    In the above example the actions :php:`show` in the :php:`PostController` and
    :php:`create` in the :php:`CommentController` are allowed. The later action
    should not be cached. This action can show different output depending on
    whether a comment was just added, there was an error in the input etc.
    Therefore the output of the action :php:`create` of the :php:`CommentController`
    should not be cached.

    The action :php:`delete` of the :php:`CommentController` is not listed. This
    action is therefore not allowed in this plugin.

    The TypoScript of the plugin will be available at
    :typoscript:`tt_content.blogexample_postsingle`. Additionally
    the lists of allowed and non-cacheable actions have been added to the
    according global variables.

#.  :php:`registerPlugin()`: Add the plugin as option to the field "Type" of
    the content element (column :sql:`CType` of table :sql:`tt_content`).

    This makes the plugin available in the field
    :guilabel:`Type` of the content elements and automatically registers it for
    the :ref:`New Content Element Wizard <t3coreapi:content-element-wizard>`.

    ..  versionchanged:: 13.0
        In TYPO3 13 this is now automatically registered by the TCA from the step above.
        See :ref:`changelog:feature-102834-1705256634`

    ..  literalinclude::  _FrontendPlugin/_tt_content.php
        :language: php
        :caption: EXT:blog_example/Configuration/TCA/Overrides/tt_content.php
        :linenos:

    Use the following parameters:

    #.  Extension key :php:`'blog_example'` or name :php:`BlogExample`.
    #.  A unique identifier for your plugin in UpperCamelCase: :php:`'PostSingle'`,
        must be the same as used in :php:`configurePlugin()` or the plugin will
        not render.
    #.  Plugin title in the backend: Can be a string or a localized string starting
        with :php:`LLL:`.
    #.  (Optional) the :ref:`icon identifier <icon>` or file path prepended with "EXT:"


..  _extbase_frontend_plugin_typoscript:

Frontend plugin as pure TypoScript
==================================

..  rst-class:: bignums

#.  :php:`configurePlugin()`: Make the plugin available in the frontend

    Configure the plugin just like described in
    :ref:`extbase_frontend_plugin_content_element`. This will create the
    basic TypoScript and the lists of allowed controller-action combinations.

    In this example we define a plugin displaying a list of posts as RSS feed:

    ..  literalinclude::  _FrontendPlugin/_ext_localconf_rss.php
        :language: php
        :caption: EXT:blog_example/ext_localconf.php
        :linenos:

#.  Display the plugin via TypoScript

    The TypoScript :ref:`EXTBASEPLUGIN <t3tsref:cobj-extbaseplugin>` object saved at
    :typoscript:`tt_content.blogexample_postlistrss` can now be used
    to display the frontend plugin. In this example we create a special page type
    for the RSS feed and display the plugin via TypoScript there:

    ..  literalinclude::  _FrontendPlugin/_setup.typoscript
        :language: typoscript
        :caption: EXT:blog_example/Configuration/TypoScript/RssFeed/setup.typoscript
        :linenos:
