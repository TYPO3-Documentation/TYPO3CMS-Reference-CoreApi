:navigation-title: Site settings

..  include:: /Includes.rst.txt
..  index:: Site handling; Settings
..  _sitehandling-settings:

=============
Site settings
=============

Site settings receive a type, a default value and documentation through
:ref:`site settings definitions <site-settings-definition>`.

They are intended for application-level values that vary between sites but are
still part of a documented extension contract. A setting is therefore more than
a YAML key: the providing set defines what the key means, which type it accepts
and which value is safe when an integrator does not configure it.

The extension that introduces a setting **MUST** also own and provide that
definition. Other sets and sites may override the value, but they do not take
ownership of the contract.

..  important::
    Define every setting in an active site set before reading or overriding it.
    An entry in :file:`settings.yaml` does not create a definition. Only a
    defined setting is guaranteed to be available under its documented
    identifier, validated and converted to its declared type, supplied with a
    default value and shown in the site settings editor.

    TYPO3 retains anonymous values from legacy setting trees without a definition for backward
    compatibility. They are not a public configuration contract and should not
    be used by new code.

..  contents:: On this page
    :local:

..  _sitehandling-settings-use:

Using site settings
===================

Access defined site settings through:

*   the :ref:`\\TYPO3\\CMS\\Core\\Site\\Entity\\Site <sitehandling-site-object>`
    object in frontend and backend context using PHP
*   the :ref:`siteSettings <t3tsref:data-type-siteSettings>` key of the
    :ref:`data <t3tsref:data-type-gettext>` function in
    :ref:`TypoScript <t3tsref:start>`
*   constants in :ref:`TypoScript <t3tsref:start>` or :ref:`page TSconfig <t3tsref:pagetsconfig>`
*   the :ref:`PAGEVIEW <t3tsref:cobj-pageview>` Fluid variable
    :fluid:`{settings.mySettingKey}` as part of the resolved TypoScript settings
*   variables such as
    :fluid:`{site.configuration.settings.mySettingKey}` in Fluid templates when
    using the :typoscript:`SiteProcessor` data processor; see
    :ref:`Using site configuration in TypoScript and Fluid templates <sitehandling-inTypoScript>`.

Use them for values that vary by site, such as storage page IDs or
feature-specific presentation options.

..  _sitehandling-settings-storage:

Storing site setting values
===========================

The site settings editor stores site-specific values in
:file:`config/sites/<my_site>/settings.yaml`. TYPO3 creates the file when it is
needed.

..  important::
    Always use a flat YAML map for new :file:`settings.yaml` files. Each key
    must be the complete setting identifier. Do not use the legacy nested-tree
    representation for new configuration.

For example:

..  code-block:: yaml
    :caption: config/sites/my-site/settings.yaml

    myExtension.categoryPid: 42
    myExtension.detailPagePid: 7

TYPO3 still reads the nested-tree representation for backward compatibility.
A map can represent `foo.bar` and `foo.bar.baz` at the same time, while a YAML
tree cannot use `foo.bar` as both a value and a parent node. The site settings
editor also writes defined settings as a map.

Older site configurations may contain an inline `settings` key in
:file:`config.yaml`. Inline settings and :file:`settings.yaml` are alternative
sources, not two layers: as soon as :file:`settings.yaml` exists, TYPO3 uses it
instead of the inline values.

..  note::
    You *can* use `imports` in `settings.yaml`. However, as soon as you save
    changes in the site settings editor, TYPO3 rewrites the file and all
    `imports` will be removed.

Store shared values in a set's
:file:`Configuration/Sets/<my_set>/settings.yaml`. The editor does not modify
this file. Site-specific values in
:file:`config/sites/<my_site>/settings.yaml` take precedence.

..  _sitehandling-settings-layer:

Choosing the right layer
========================

Where a value belongs depends on who should own it:

Definition default
    Use the `default` in :file:`settings.definitions.yaml` for the reusable,
    safe value supplied by the extension. Every defined setting needs this
    value.

Set override
    Use :file:`Configuration/Sets/<my_set>/settings.yaml` for a preset shared by
    every site that enables the set. A site package commonly uses this layer to
    adapt extension defaults to a project.

Site override
    Use :file:`config/sites/<my_site>/settings.yaml`, usually through the site
    settings editor, when the value belongs to one site.

These layers change the value, not the definition. The definition must come
from an active set in all three cases.

..  _sitehandling-settings-resolution:

How a setting value is resolved
===============================

TYPO3 starts with the definition's default. It then applies values from active
sets in resolved dependency order, so a set can adapt a setting from an earlier
dependency. Finally, the site-specific value takes precedence:

..  code-block:: text

    definition default
      -> active set overrides
        -> config/sites/<my_site>/settings.yaml

After composing the effective value, TYPO3 validates and converts it according
to the definition. Without a definition, TYPO3 cannot guarantee the identifier,
type or fallback value, which is why undefined values must not be used as a new
configuration API.


..  _sitehandling-settings-add:

Defining and overriding site settings
=====================================

First define the setting in a set that is active for the site:

..  literalinclude:: _Settings/_site-settings.definitions.yaml
    :caption: EXT:my_extension/Configuration/Sets/MySet/settings.definitions.yaml

Then override the defined setting in the site's :file:`settings.yaml`:

..  literalinclude:: _site-settings.yaml
    :caption: config/sites/<my_site>/settings.yaml | typo3conf/sites/<my_site>/settings.yaml

..  note::
    The second setting in this example fills a constant of
    :doc:`EXT:felogin <ext_felogin:Index>` via site settings
    (:typoscript:`styles.content.loginform.pid`). Its definition is provided by
    the active `typo3/felogin` site set.

The first setting is owned by the example extension. The second demonstrates
that a site may also override a setting defined by another active set; it does
not need to repeat that definition.


..  _sitehandling-settings-access:

Accessing site settings in PHP and Fluid
========================================

In PHP you can access the :php-short:`\TYPO3\CMS\Core\Site\Entity\SiteSettings`
from the :php-short:`\TYPO3\CMS\Core\Site\Entity\Site` object via
`getSettings()`:

..  code-block:: php

    $categoryPid = $site->getSettings()->get('myExtension.categoryPid');

See `Accessing the current site object <https://docs.typo3.org/permalink/t3coreapi:sitehandling-php-api-access>`_
for ways to retrieve the site object.

..  _sitehandling-settings-access-extbase-fluid:

Site settings in Extbase Fluid plugins
--------------------------------------

Site settings are not injected automatically into Extbase controllers or plugin
settings. Pass them to the plugin through TypoScript or make the site object
available in the controller.

To make the site settings available to all templates in your controller
you can override method `AbstractController::initializeView()` and assign
the site to the view:

..  literalinclude:: _Settings/_ExampleController.php
    :caption: EXT:my_extension/Classes/Controller/ExampleController.php

You can then use the variable `{site.settings}` to access the site settings:

..  literalinclude:: _Settings/_ExampleControllerIndex.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/Example/Index.fluid.html

..  index:: Site handling; TypoScript access to settings
..  _sitehandling-settings-access-typoscript:

Site settings in page TSconfig or TypoScript
============================================

TYPO3 exposes the *effective value* of a site setting, not its definition. It
first composes the default and all applicable overrides as described in
:ref:`How a setting value is resolved <sitehandling-settings-resolution>`. Scalar values are then added to the
TypoScript constants with exactly the same identifier as the setting.

The definition remains the contract behind that value. Its metadata, such as
`label`, `description` and `type`, is not available as TypoScript. Consequently,
TypoScript should only read identifiers whose definitions are provided by an
active set. Anonymous values may still be exposed for backward compatibility,
but they are not a supported configuration API.

..  _sitehandling-settings-access-typoscript-quickstart:

Pass a setting to TypoScript
----------------------------

This example passes a page ID from a site setting to an Extbase plugin. The
extension has already defined `myExtension.categoryPid` and the site has
overridden it to `658` in :ref:`Defining and overriding site settings <sitehandling-settings-add>`.

After TYPO3 has resolved the setting, the identifier is available as the
TypoScript constant :typoscript:`{$myExtension.categoryPid}`. It can be assigned
to any scalar TypoScript property:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/Sets/MySet/setup.typoscript

    plugin.tx_myextension.settings.categoryPid = {$myExtension.categoryPid}

With the site override above, the parsed value of
:typoscript:`plugin.tx_myextension.settings.categoryPid` is `658`. If the site
does not override it, the definition's default value `0` is used. A default in
:file:`constants.typoscript` with the same identifier does not win: every
defined setting already supplies a value and overrides typoscript constants.

The same constant is available in page TSconfig. This makes one defined setting
usable by both frontend rendering and backend form configuration:

..  code-block:: typoscript

    // store tx_ext_data records on the given storage page by default (e.g. through IRRE)
    TCAdefaults.tx_ext_data.pid = {$myExtension.categoryPid}

    // load category selection for plugin from our dedicated storage page
    TCEFORM.tt_content.pi_flexform.ext_pi1.sDEF.categories.PAGE_TSCONFIG_ID = {$myExtension.categoryPid}

..  _sitehandling-settings-access-typoscript-data:

Read a setting with the TypoScript data function
------------------------------------------------

In frontend TypoScript, a content object can read the setting directly from the
current site instead of using constant substitution:

..  code-block:: typoscript

    lib.categoryPid = TEXT
    lib.categoryPid {
        data = siteSettings:myExtension.categoryPid
    }

Use :typoscript:`{$myExtension.categoryPid}` when a value must be inserted into
the TypoScript configuration while it is parsed, or when it is needed in page
TSconfig. Use :typoscript:`data = siteSettings:myExtension.categoryPid` when a
frontend content object supports :ref:`the data function
<t3tsref:data-type-gettext>` and should read from the current site at runtime.
Both forms use the exact, case-sensitive setting identifier.

When a page is rendered with :ref:`PAGEVIEW <t3tsref:cobj-pageview>`, the
complete resolved TypoScript settings tree is available in Fluid as
:fluid:`{settings}`. Site settings therefore appear under their dotted path,
for example :fluid:`{settings.myExtension.categoryPid}`. This variable contains
all TypoScript settings, however, not only Site Settings. A later value from the
site's :file:`constants.typoscript` or a :sql:`sys_template` record can differ
from the value returned by :php:`$site->getSettings()`.

..  _sitehandling-settings-access-typoscript-pitfalls:

Avoid common pitfalls
---------------------

Installed does not mean active
    Installing the providing extension makes its set available, but the
    definition contributes to a site only when that site activates the set
    directly or through a dependency. If a constant is not substituted, first
    check the site's `dependencies` in :file:`config.yaml`.

Constants are text substitutions
    Site settings are validated and converted according to their definition,
    but a TypoScript constant is inserted as source text. The original PHP type
    does not survive constant substitution. In particular, a Boolean `true`
    becomes `1` and `false` becomes an empty value. Use the value in a context
    that applies the expected TypoScript type conversion.

Lists are not single constants
    A setting of type `stringlist` is an array. TYPO3 exposes its scalar entries
    as flattened constants such as
    :typoscript:`{$myExtension.allowedHosts.0}`; it does not create one usable
    :typoscript:`{$myExtension.allowedHosts}` value for the complete list. Read
    structured settings through the Site Settings API in PHP or Fluid instead
    of depending on numeric constant names.

Multiline values are not safe constant values
    TYPO3 generates one constant assignment per scalar setting. A line break in
    a `text` value therefore becomes a line break in the generated TypoScript
    source. Read multiline content directly through the Site Settings API rather
    than substituting it as a constant.

Identifiers are exact
    :typoscript:`{$myextension.categoryPid}` and
    :typoscript:`{$myExtension.categoryPid}` are different constants. Keep the
    vendor or extension prefix and casing consistent in the definition, all
    overrides and every consumer.

Dotted paths do not define their parents
    A definition for `myExtension.features.preview` does not also define
    `myExtension.features` or `myExtension`. Each identifier that forms part of
    the public configuration API needs its own definition. Conversely, the map
    representation in :file:`settings.yaml` allows separately defined
    `foo.bar` and `foo.bar.baz` to coexist.

..  _sitehandling-settings-access-typoscript-priority:

Know which value wins
---------------------

Within a site TypoScript provider, TYPO3 loads set constants first, then adds
the effective site settings as constants, followed by the site's own
:file:`constants.typoscript`. Constants from :sql:`sys_template` records are
applied afterwards. A later value with the same identifier overrides an earlier
one.

..  note::
    In simplified form, the relevant order is:

    #.  Configuration from
        :ref:`$GLOBALS['TYPO3_CONF_VARS']['FE']['defaultTypoScript_constants']
        <typo3ConfVars_fe_defaultTypoScript_constants>`
    #.  :file:`constants.typoscript` from active sets
    #.  Effective site setting values
    #.  The site's :file:`constants.typoscript`
    #.  Constants from :sql:`sys_template` database records

    When site sets and :sql:`sys_template` records are combined, also observe
    the :guilabel:`Clear` flags described in
    :ref:`Site set TypoScript <site-sets-typoscript>`. They can clear TypoScript that was provided by
    the site and its sets.
