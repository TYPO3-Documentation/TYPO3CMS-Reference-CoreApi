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

    #. Extension key :php:`'blog_example'` or name :php:`BlogExample`.
    #. A unique identifier for your plugin in UpperCamelCase: :php:`'PostSingle'`
    #. An array of allowed combinations of controllers and actions stored in an array
    #. (Optional) an array of controller name and  action names which should not be cached

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
    :typoscript:`tt_content.list.20.blogexample_postsingle`. Additionally
    the lists of allowed and non-cacheable actions have been added to the
    according global variables.

#.  :php:`registerPlugin()`: Add to :sql:`list_type` :sql:`tt_content`.

    Make the plugin available in the field
    :guilabel:`Plugin > Selected Plugin`, :sql:`list_type` of the table
    :sql:`tt_content`.

    ..  figure:: /Images/ManualScreenshots/Extbase/ListType.png
        :class: with-shadow

    The new plugin in the content record at :guilabel:`Plugin > Selected Plugin`

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

#.  (Optional) Add to the :guilabel:`New Content Element` wizard

    Add the following :ref:`page TSconfig <t3tsref:setting-page-tsconfig>`
    to add the new plugin to the wizard:

    ..  literalinclude::  _FrontendPlugin/_page.tsconfig
        :language: typoscript
        :caption: EXT:blog_example/Configuration/page.tsconfig
        :linenos:

    *   Line 6: The plugin signature: The extension name in lowercase without
        underscores, followed by one underscore, followed by the plugin identifier
        in lowercase without underscores.
    *   Line 7: Should be the same icon like used in :php:`registerPlugin()` for consistency
    *   Line 8: Should be the same title like used in :php:`registerPlugin()` for consistency
    *   Line 9: Additional description:  Can be a string or a localized string starting
        with :php:`LLL:`.
    *   Line 12: The plugin signature as :typoscript:`list_type`
    *   Line 16: Add the plugin signature as to the list of allowed content elements

    In TYPO3 v11 you still need to include the page TSconfig file, in TYPO3 v12
    it is automatically globally included.

    See :ref:`t3tsref:pagesettingdefaultpagetsconfig`.

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

    The TypoScript :ref:`USER <t3tsref:cobj-user>` object saved at
    :typoscript:`tt_content.list.20.blogexample_postlistrss` can now be used
    to display the frontend plugin. In this example we create a special page type
    for the RSS feed and display the plugin via TypoScript there:

    ..  literalinclude::  _FrontendPlugin/_setup.typoscript
        :language: typoscript
        :caption: EXT:blog_example/Configuration/TypoScript/RssFeed/setup.typoscript
        :linenos:
