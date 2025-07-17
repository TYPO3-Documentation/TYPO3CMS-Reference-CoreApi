:navigation-title: Extending

..  include:: /Includes.rst.txt
..  index:: Routing; Extending
..  _routing-extending-routing:

=================
Extending Routing
=================

The TYPO3 Routing is extendable by design, so you can write both custom aspects
as well as custom enhancers.

*   You should write a custom enhancer if you need to manipulate how the full
    route looks like and gets resolved.
*   You should write a custom aspect if you want to manipulate how a single
    route parameter ("variable") gets mapped and resolved.

..  _routing-custom-aspects:
..  index:: Routing; Custom aspects

Writing custom aspects
======================

Custom aspects can either be modifiers or mappers. A modifier provides static
modifications to a route path based on a given context (for example "language").
A mapper provides a mapping table (either a static table or one with dynamic
values from the database).

All aspects derive from the interface :php:`\TYPO3\CMS\Core\Routing\Aspect\AspectInterface`.

To write a custom **modifier**, your aspect has to
extend :php:`\TYPO3\CMS\Core\Routing\Aspect\ModifiableAspectInterface` and implement the :php:`modify` method
(see `\TYPO3\CMS\Core\Routing\Aspect\LocaleModifier` as example).

To write a custom **mapper**, your aspect should either implement
:php:`\TYPO3\CMS\Core\Routing\Aspect\StaticMappableAspectInterface`
or :php:`\TYPO3\CMS\Core\Routing\Aspect\PersistedMappableAspectInterface`,
depending on whether you have a static or dynamic mapping table.
The latter interface is used for mappers that need more expensive -
for example database related - queries as execution is deferred to improve performance.

All mappers need to implement the methods :php:`generate` and :php:`resolve`.
The first one is used on URL generation, the second one on URL resolution.

After implementing the matching interface, your aspect needs to be
registered in :file:`ext_localconf.php`:

..  literalinclude:: _codesnippets/_ext_localconf.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

It can now be used in the routing configuration as `type`. The example above
could be used as `type: MyCustomMapperNameAsUsedInYamlConfig`.

If your aspect is language aware, it should additionally implement
`SiteLanguageAwareInterface` with the methods
`setSiteLanguage(Entity\SiteLanguage $siteLanguage)`
and `getSiteLanguage()`. `setSiteLanguage` will automatically be called with
the current site language object.

..  _routing-custom-enhancers:
..  index:: Routing; Custom enhancers

Writing custom enhancers
========================

Enhancers can be either decorators or routing enhancers providing variants for a page.

*   To write a custom **decorator** your enhancer should implement the
    :php:`\TYPO3\CMS\Core\Routing\Enhancer\DecoratingEnhancerInterface`.
*   To write a custom **route enhancer** your enhancer should implement both
    :php:`\TYPO3\CMS\Core\Routing\Enhancer\RoutingEnhancerInterface` and
    :php:`\TYPO3\CMS\Core\Routing\Enhancer\ResultingInterface`

The interfaces contain methods you need to implement as well as a description of what the methods are supposed to do. Please take a look there.

To register the enhancer, add the following to your `ext_localconf.php`:

..  literalinclude:: _codesnippets/_ext_localconf_custom_enhancer.php
    :language: php
    :caption: EXT:my_extension/ext_localconf.php

Now you can use your new enhancer in the routing configuration as `type`. The
example above could be used as `type: MyCustomEnhancerAsUsedInYaml`.

..  _routing-slug-manipulation:
..  index:: Routing; Manipulating slugs

Manipulating generated slugs
=============================

The "slug" TCA type includes a possibility to hook into the generation of a slug
via custom TCA generation options.

Hooks can be registered via

..  code-block:: php

    $GLOBALS['TCA'][$tableName]['columns'][$fieldName]['config']['generatorOptions']['postModifiers'][]
        = My\Class::class . '->method';

in :file:`EXT:myextension/Configuration/TCA/Overrides/table.php`, where
`$tableName` can be a table like `pages` and `$fieldName` matches the slug
field name, for example `slug`.

..  code-block:: php

    $GLOBALS['TCA']['pages']['columns']['slug']['config']['generatorOptions']['postModifiers'][]
        = My\Class::class . '->modifySlug';

The method then receives a parameter array with the following values:

..  code-block:: php

    [
        'slug' ...  the slug to be used
        'workspaceId' ...  the workspace ID, "0" if in live workspace
        'configuration' ...  the configuration of the TCA field
        'record' ...  the full record to be used
        'pid' ...  the resolved parent page ID
        'prefix' ...  the prefix that was added
        'tableName' ...  the table of the slug field
        'fieldName' ...  the field name of the slug field
   ];

All hooks need to return the modified slug value.

Any extension can modify a specific slug, for instance only for a specific
part of the page tree.

It is also possible for extensions to implement custom functionality like
"Do not include in slug generation" as known from RealURL.
