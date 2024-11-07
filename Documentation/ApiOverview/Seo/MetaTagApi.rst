.. include:: /Includes.rst.txt
.. index:: ! MetaTag
.. _metatagapi:

============
MetaTag API
============

The MetaTag API is available for setting meta tags in a flexible way.

.. note::

    Usually, it is sufficient to set meta tags using the API of the 
    :php:`\TYPO3\CMS\Core\Page\PageRenderer` which uses the MetaTag API
    internally. For all other cases, use the MetaTag API directly.

The API uses :php:`MetaTagManagers` to manage the tags for a "family" of meta tags. The Core e.g. ships an
OpenGraph MetaTagManager that is responsible for all OpenGraph tags.
In addition to the MetaTagManagers included in the Core, you can also register your own
:php:`MetaTagManager` in the :php:`\TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry`.


.. index:: pair: MetaTag; API
.. _metatagapi-usage:

Using the MetaTag API
======================

To use the API, first get the right :php:`MetaTagManager` for your tag from the :php:`MetaTagManagerRegistry`.
You can use that manager to add your meta tag; see the example below for the :html:`og:title` meta tag.

.. code-block:: php

    use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
    use TYPO3\CMS\Core\Utility\GeneralUtility;

    $metaTagManager = GeneralUtility::makeInstance(MetaTagManagerRegistry::class)->getManagerForProperty('og:title');
    $metaTagManager->addProperty('og:title', 'This is the OG title from a controller');

This code will result in a :html:`<meta property="og:title" content="This is the OG title from a controller" />` tag in frontend.

If you need to specify sub-properties, e.g. :html:`og:image:width`, you can use the following code:

.. code-block:: php

    use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
    use TYPO3\CMS\Core\Utility\GeneralUtility;

    $metaTagManager = GeneralUtility::makeInstance(MetaTagManagerRegistry::class)->getManagerForProperty('og:image');
    $metaTagManager->addProperty('og:image', '/path/to/image.jpg', ['width' => 400, 'height' => 400]);

You can also remove a specific property:

.. code-block:: php

    use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
    use TYPO3\CMS\Core\Utility\GeneralUtility;

    $metaTagManager = GeneralUtility::makeInstance(MetaTagManagerRegistry::class)->getManagerForProperty('og:title');
    $metaTagManager->removeProperty('og:title');

Or remove all previously set meta tags of a specific manager:

.. code-block:: php

    use TYPO3\CMS\Core\MetaTag\MetaTagManagerRegistry;
    use TYPO3\CMS\Core\Utility\GeneralUtility;

    $metaTagManager = GeneralUtility::makeInstance(MetaTagManagerRegistry::class)->getManagerForProperty('og:title');
    $metaTagManager->removeAllProperties();


.. index:: MetaTag; Custom MetaTagManager
.. _metatagapi-create-your-own:

Creating Your Own MetaTagManager
================================

If you need to specify the settings and rendering of a specific meta tag (for example when you want to make it possible
to have multiple occurrences of a specific tag), you can create your own :php:`MetaTagManager`.
This :php:`MetaTagManager` must implement :php:`\TYPO3\CMS\Core\MetaTag\MetaTagManagerInterface`.

To use the manager, you must register it in :php:`ext_localconf.php`:

..  literalinclude:: _MetaTagApi/_ext_localconf_register_manager.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

Registering a :php:`MetaTagManager` works with the :php:`DependencyOrderingService`. So you can also specify the
priority of the manager by setting the third (before) and fourth (after) parameter of the method. If you for example
want to implement your own :php:`OpenGraphMetaTagManager`, you can use the following code:


..  literalinclude:: _MetaTagApi/_ext_localconf_register_manager_open_graph.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

This will result in :php:`MyOpenGraphMetaTagManager` having a higher priority and it will first check if your own
manager can handle the tag before it checks the default manager provided by the Core.

.. index:: pair: MetaTag; TypoScript
.. _metatagapi-configuration:

TypoScript and PHP
==================

You can set your meta tags by TypoScript and PHP (for example from plugins). First the meta tags from content (plugins)
will be handled. After that the meta tags defined in TypoScript will be handled.

It is possible to override earlier set meta tags by TypoScript if you explicitly say this should happen. Therefore the
:typoscript:`meta.*.replace` option was introduced. It is a boolean flag with these values:

* :typoscript:`1`: The meta tag set by TypoScript will replace earlier set meta tags
* :typoscript:`0`: (default) If the meta tag is not set before, the meta tag will be created. If it is already set, it will ignore the meta tag set by TypoScript.

.. code-block:: typoscript

    page.meta {
        og:site_name = TYPO3
        og:site_name.attribute = property
        og:site_name.replace = 1
    }

When you set the property replace to :typoscript:`1` at the specific tag, the tag will replace tags that are set from plugins.

By using the new API it is not possible to have duplicate metatags, unless this is explicitly allowed. If you use custom
meta tags and want to have multiple occurrences of the same meta tag, you have to create your own :php:`MetaTagManager`.

..  seealso::

    :ref:`config.meta <t3tsref:setup-page-meta>` in the TypoScript reference
