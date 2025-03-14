:navigation-title: URI arguments

..  include:: /Includes.rst.txt
..  index:: Extbase; URI arguments; arguments
..  _extbase-arguments:

===================================
URI arguments and reserved keywords
===================================

Extbase uses special URI arguments to pass variables
to Controller arguments and the framework itself.

..  todo: Check for completion of this

Extbase uses a prefixed URI argument scheme that relies
on plugin configuration.

For example, the example extension `EXT:blog_example` would use:

..  code-block:: plaintext

    // Linebreaks just for readability.
    https://example.org/blog/?tx_blogexample_bloglist[action]=show
    &tx_blogexample_bloglist[controller]=Post
    &tx_blogexample_bloglist[post]=4711
    &cHash=...

    // Actually, the [] parameters are often URI encoded, so this is emitted:
    https://example.org/blog/?tx_blogexample_bloglist%5Baction%5D=show
    &tx_blogexample_bloglist%5Bcontroller%5D=Post
    &tx_blogexample_bloglist%5Bpost%5D=4711
    &cHash=...

as the created URI to execute the `showAction` of the Controller `PostController`
within the plugin `BlogList`.

The following arguments are evaluated:

`tx_(extensionName)_(pluginName)[action]`:
     Controller action to execute
`tx_(extensionName)_(pluginName)[controller]`
    Controller containing the action
`tx_(extensionName)_(pluginName)[format]`
    Output format (usually `html`, can also be `json` or custom types)
`cHash`
    the cHash always gets calculated to validate that the URI is allowed to be called. (see :ref:`chash`)

Any other argument will be passed along to the controller action and can be
retrieved via :php:`$this->request->getArgument()`. Usually this is auto-wired
by the automatic parameter mapping of Extbase.

These URI arguments can also be used for the routing configuration, see
:ref:`routing-extbase-plugin-enhancer`.

..  warning::

    The listed keys `action`, `controller` and `format` are reserved keywords.
    Never use these as custom argument names to your controller actions,
    so instead of :fluid:`<f:uri.action action="new" arguments="{format: someVariable}">`
    you should use :fluid:`<f:uri.action action="new" arguments="{customFormat: someVariable}">`.
    Else, using an argument like this would lead to TYPO3 exceptions of unresolvable
    Fluid template files!

When submitting a HTML :html:`<form>`, the same URI arguments will be part of
a HTTP POST request, with some more special ones:

 `tx_(extensionName)_(pluginName)[__referrer]`
     An array with information
     of the referring call (subkeys: `@extension`, `@controller`, `@action`,
    `arguments` (hashed), `@request` (json)
`tx_(extensionName)_(pluginName)[__trustedProperties]`
    List of properties to be submitted to an action (hashed and secured)

These two keys are also regarded as reserved keywords. Generally, you should
avoid custom arguments interfering with either the `@...` or `__...` prefix
notation.
