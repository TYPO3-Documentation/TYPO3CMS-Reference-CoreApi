..  include:: /Includes.rst.txt
..  index::
    ViewHelpers; Custom
    Fluid; Custom ViewHelpers
..  _fluid-custom-viewhelper:

==============================
Developing a custom ViewHelper
==============================

..  deprecated:: Fluid v2.15 (TYPO3 v13.3 / TYPO3 12.4)
    The traits
    :php:`\TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic` and
    :php:`\TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRender`
    are deprecated. See section :ref:`migration <fluid-custom-viewhelper-migration>`.

This chapter demonstrates how to write a custom Fluid ViewHelper in TYPO3.

A "Gravatar" ViewHelper is created, which uses an email address as parameter
and shows the picture from gravatar.com if it exists.

The official documentation of Fluid for writing custom ViewHelpers can be found
within the Fluid documentation: :ref:`fluid:creating-viewhelpers`.

..  contents:: Contents of this page
    :local:
    :depth: 1

..  _fluid-custom-viewhelper-fluid:

Fluid
=====

The custom ViewHelper is not part of the default distribution. Therefore a
namespace import is necessary to use this ViewHelper. In the following example,
the namespace :php:`\MyVendor\MyExtension\ViewHelpers` is imported with the
prefix `m`. Now, all tags starting with `m:` are interpreted as
ViewHelper from within this namespace.
For further information about namespace import, see
:ref:`fluid-syntax-viewhelpers-import-namespaces`.

The ViewHelper should be given the name "gravatar" and take an email
address and an optional alt-text  as a parameters.
The ViewHelper is called in the template as follows:

..  literalinclude:: _CustomViewHelper/_SomeTemplate.html
    :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

..  _fluid-custom-viewhelper-implementation:

AbstractViewHelper implementation
=================================

Every ViewHelper is a PHP class. For the Gravatar ViewHelper, the fully
qualified name of the class is
:php:`\MyVendor\MyExtension\ViewHelpers\GravatarViewHelper`.

..  literalinclude:: _CustomViewHelper/_GravatarViewHelper.php
    :caption: Example 1: EXT:my_extension/Classes/ViewHelpers/GravatarViewHelper.php
    :linenos:

..  _fluid-custom-viewhelper-AbstractViewHelper:

:php:`AbstractViewHelper`
-------------------------

*line 9* `extends AbstractViewHelper`

Every ViewHelper must inherit from the class
:php:`\TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper`.

A ViewHelper can also inherit from subclasses of
:php-short:`\TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper`, for example
from :php:`\TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper`.
Several subclasses are offering additional functionality. The
:php-short:`\TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper`
will be explained :ref:`later on in this chapter
<creating-xml-tags-using-tagbasedviewhelper>` in detail.

..  _fluid-viewhelper-custom-escaping-of-output:

Disable escaping the output
---------------------------

*line 11* `protected $escapeOutput = false;`

By default, all output is escaped by :php:`htmlspecialchars()` to prevent cross
site scripting.

Setting the property :php:`$escapeOutput` to false is necessary to prevent
escaping of ViewHelper output.

By setting the property :php:`$escapeChildren` to false, escaping of the tag
content (its child nodes) can be disabled. If this is not set explicitly,
the value will be determined automatically: If :php:`$escapeOutput`: is true,
:php:`$escapeChildren` will be disabled to prevent double escaping. If
:php:`$escapeOutput`: is false, :php:`$escapeChildren` will be enabled unless
disabled explicitly.

Passing in children is explained in :ref:`prepare-viewhelper-for-inline-syntax`.

..  _fluid-viewhelper-custom-initializeArguments:

:php:`initializeArguments()`
----------------------------

*line 13* `public function initializeArguments(): void`

The :php:`Gravatar` ViewHelper must hand over the email address which
identifies the Gravatar. An alt text for the image is passed as optional parameter.

ViewHelpers have to register (line 16, `$this->registerArgument()`) parameters.
The registration happens inside method `initializeArguments()`.

In the example above, the ViewHelper receives the argument `emailAddress` (line 17) of
type `string` (line 18) which is mandatory (line 19). The optional argument `alt`
is defined in lines 22-26.

These arguments can be accessed
through the array :php:`$this->arguments`, in method :php:`render()`.

..  tip::

    Sometimes arguments can take various types. In this case, the type `mixed`
    should be used.

`render()`
----------

*line 29* `public function render(): string`

The method :php:`render()` is called once the ViewHelper is rendered. Its return
value can be directly output in Fluid or passed to another ViewHelper.

In *line 30 an 31* we retrieve the arguments from the `$arguments` class
property. `alt` is an optional argument and therefore nullable. Fluid ensures,
the declared type is passed for non-null values. These arguments can contain
user input.

..  attention::
    Prevent :ref:`XSS (Cross-Site Scripting) attacks <prevent-cross-site-scripting>`.

    The returned string is displayed raw, without being passed through
    :php:`htmlspecialchars()` as we have
    :ref:`disabled escaping <fluid-viewhelper-custom-escaping-of-output>`.

When escapting is diabled, the `render()` method is responsible to prevent
:ref:`XSS attacks <prevent-cross-site-scripting>`.

Therefore all arguments **must** be sanitized before they are returned.

Passing the email address through
`md5() <https://www.php.net/manual/en/function.md5.php>`__ ensures that
we only have a hexadecimal number, it can contain no harmful chars.

The alt text is passed through `htmlspecialchars()`, therefore potentially
harmful chars are escaped.

..  hint::
    The `render()` method usually returns a string that should be displayed
    directly in the Fluid template. But it is also possible to return another
    type and use it as argument for another ViewHelper which expects that type.

..  _creating-xml-tags-using-tagbasedviewhelper:
..  _creating-html-tags-using-tagbasedviewhelper:

Creating HTML/XML tags with the :php:`AbstractTagBasedViewHelper`
=================================================================

..  versionchanged:: Fluid Standalone 2.12 / TYPO3 13.2
    All TagBasedViewHelpers (such as :html:`<f:image />` or :html:`<f:form.*>`) can now receive
    arbitrary tag attributes which will be appended to the resulting HTML tag. In the past,
    this was only possible for a small list of tag attributes, like class, id or lang.

    See also :ref:`AbstractTagBasedViewHelper-registerTagAttribute-migration`.

For ViewHelpers which create HTML/XML tags, Fluid provides an enhanced base
class: :php:`\TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper`.  This
base class provides an instance of
:php:`\TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder` that can be used to create
HTML-tags. It takes care of the syntactically correct creation and, for example,
escapes single and double quotes in attribute values.

*line 11* `protected $tagName = 'img'` configures the name of the HTML/XML tag
to be output.

All ViewHelpers extending :php-short:`\TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper`
can receive arbitrary tag attributes which will be appended to the resulting
HTML tag and escaped automatically. For example we do not have to declare or
escape the `alt` argument as we did in
:ref:`Example 1 <fluid-custom-viewhelper-implementation>`.

Because the Gravatar ViewHelper creates an :html:`<img>` tag the use of the
:php-short:`\TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder`, stored in class property
`$this->tag` is advised:

..  literalinclude:: _CustomViewHelper/_GravatarTagBasedViewHelper.php
    :language: php
    :caption: EXT:my_extension/Classes/ViewHelpers/GravatarViewHelper.php (Example 2, tag-based)
    :linenos:

*line 32* `$this->tag->render()` creates the :html:`<img>` tag with all
explicitly added arguments  (*line 28-31* `$this->tag->addAttribute()`) and all
arbitrary tag attributes passed to the ViewHelper when it is used.

..  _AbstractTagBasedViewHelper:

`AbstractTagBasedViewHelper`
----------------------------

*line 6* `class GravatarViewHelper extends AbstractTagBasedViewHelper`

The ViewHelper does not inherit directly from
:php-short:`\TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper` but
from :php-short:`\TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper`,
which provides and initializes the
:php-short:`\TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder` and passes on and
escapes arbitrary tag attributes.


..  _AbstractTagBasedViewHelper-tagname:

:php:`$tagName`
---------------

*line 9* `protected $tagName = 'img';`

There is a class property :php:`$tagName` which stores the name of the tag to be
created (:html:`<img>`).

..  _AbstractTagBasedViewHelper-addAttribute:

:php:`$this->tag->addAttribute()`
---------------------------------

*line 28 - 31* `$this->tag->addAttribute(...)`

The tag builder is available as class property :php:`$this->tag`. It offers
the method :php:`TagBuilder::addAttribute()` to add new tag attributes. In our
example the attribute `src` is added to the tag.

..  _AbstractTagBasedViewHelper-render:

:php:`$this->tag->render()`
---------------------------

*line 32* `return $this->tag->render();`

The GravatarViewHelper creates an img tag builder, which has a method named
:php:`render()`. After configuring the tag builder instance, the rendered tag
markup is returned.

..  _AbstractTagBasedViewHelper-registerTagAttribute:

:php:`$this->registerTagAttribute()`
------------------------------------

..  deprecated:: Fluid standalone 2.12 / TYPO3 v13.2
    The methods php:`$this->registerTagAttribute()` and
    :php:`registerUniversalTagAttributes()` have been deprecated. They can be
    removed on dropping TYPO3 v12.4 support.

..  _AbstractTagBasedViewHelper-registerTagAttribute-migration:

Migration: Remove registerUniversalTagAttributes and registerTagAttribute
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

..  literalinclude:: _CustomViewHelper/_GravatarViewHelper13.diff
    :caption: EXT:my_extension/Classes/ViewHelpers/GravatarViewHelper.php

When removing the call, attributes registered by the call are now available in
:php:`$this->additionalArguments`, and no longer in :php:`$this->arguments`.
This *may* need adaption within single ViewHelpers, *if* they handle such
attributes on their own.

If you need to support both TYPO3 v12.4 and v13, you can leave the calls
in until dropping TYPO3 v12.4 support.

..  literalinclude:: _CustomViewHelper/_GravatarViewHelper_Initialize.diff
    :caption: EXT:my_extension/Classes/ViewHelpers/GravatarViewHelper.php

..  _insert-optional-arguments:

Insert optional arguments with default values
=============================================

An optional size for the image can be provided to the Gravatar ViewHelper. This
size parameter will determine the height and width in pixels of the
image and can range from 1 to 512. When no size is given, an image of 80px is
generated.

The :php:`render()` method can be improved like this:

..  literalinclude:: _CustomViewHelper/_GravatarViewHelper_Render.php
    :caption: EXT:my_extension/Classes/ViewHelpers/GravatarViewHelper.php

With this setting of a default value and setting the fourth argument to `false`,
the `size` attribute becomes optional.

..  _prepare-viewhelper-for-inline-syntax:

Prepare ViewHelper for inline syntax
====================================

..  deprecated:: Fluid v2.15 (TYPO3 v13.3 / TYPO3 12.4)
    In former versions this was done by using the now deprecated trait
    :php-short:`\TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRender`.
    See section :ref:`migration <fluid-custom-viewhelper-migration>`.

So far, the Gravatar ViewHelper has focused on the tag structure of the
ViewHelper. The call to render the ViewHelper was written with tag syntax, which
seemed obvious because it itself returns a tag:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

    <m:gravatar emailAddress="{post.author.emailAddress}" />

Alternatively, this expression can be written using the inline notation:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

    {m:gravatar(emailAddress: post.author.emailAddress)}

One should see the Gravatar ViewHelper as a kind of post-processor for an email
address and would allow the following syntax:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

    {post.author.emailAddress -> m:gravatar()}

This syntax places focus on the variable that is passed to the ViewHelper as it
comes first.

The syntax `{post.author.emailAddress -> m:gravatar()}` is an alternative
syntax for `<m:gravatar>{post.author.emailAddress}</m:gravatar>`. To
support this, the email address comes either from the argument `emailAddress`
or, if it is empty, the content of the tag should be interpreted as email
address.

This is typically used with formatting ViewHelpers. These ViewHelpers all
support both tag mode and inline syntax.

Depending on the implemented method for rendering, the implementation is
different:

To fetch the content of the ViewHelper the method :php:`renderChildren()` is
available in the :php-short:`\TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper`.
This returns the evaluated object between the opening and closing tag.

..  literalinclude:: _CustomViewHelper/_GravatarTagBasedViewHelper_getContentArgumentName.php
    :language: php
    :caption: EXT:my_extension/Classes/ViewHelpers/GravatarViewHelper.php  (Example 3, with content arguments)
    :linenos:

..  _handle-additional-arguments:

Handle additional arguments
===========================

..  versionchanged:: Fluid Standalone 2.12 / TYPO3 13.2
    All ViewHelpers implementing
    :php-short:`\TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper`
    can now receive arbitrary tag attributes which will be appended to the
    resulting HTML tag. In the past, this was only possible for
    explicitly registered arguments.

    See also :ref:`AbstractTagBasedViewHelper-registerTagAttribute-migration`.

If a ViewHelper allows further arguments which have not been explicitly
configured, the :php:`handleAdditionalArguments()` method can be implemented.

ViewHelper implementing
:php-short:`\TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper` do
not need to use this as all arguments are passed on automatically.

..  _the-different-render-methods:

The different render methods
============================

ViewHelpers can have one or more of the following methods for
implementing the rendering. The following section will describe the differences
between the implementations.

..  _compile-method:

`compile()`-Method
------------------

This method can be overwritten to define how the ViewHelper should be compiled.
That can make sense if the ViewHelper itself is a wrapper for another native PHP
function or TYPO3 function. In that case, the method can return the call to this
function and remove the need to call the ViewHelper as a wrapper at all.

The :php:`compile()` has to return the compiled PHP code for the ViewHelper.
Also the argument :php:`$initializationPhpCode` can be used to add further PHP
code before the execution.

Example implementation:

..  literalinclude:: _CustomViewHelper/_StrtolowerViewHelper.php
    :caption: EXT:my_extension/Classes/ViewHelpers/StrtolowerViewHelper.php

..  _renderstatic-method:

`renderStatic()` method
-----------------------

..  deprecated:: Fluid v2.15 (TYPO3 v13.3 / TYPO3 12.4)
    The trait
    :php-short:`\TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic`,
    which is responsible for calling `renderStatic()` is deprecated.
    See section :ref:`migration <fluid-custom-viewhelper-migration>`.

..  _render-method:

`render()` method
-----------------

Most of the time, this method is implemented.


..  _fluid-custom-viewhelper-migration:

Migration: Remove deprecated compliling traits
==============================================

..  _fluid-viewhelper-custom-renderStatic:

Migration: Remove deprecated trait `CompileWithRenderStatic`
-------------------------------------------------------------

To remove the deprecated trait
:php:`\TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic` switch
to use the `render()` method instead of the `renderStatic()`.

..  literalinclude:: _CustomViewHelper/MigrateRenderStatic.diff
    :caption: EXT:my_extension/Classes/ViewHelpers/GravatarViewHelper.php (diff removing CompileWithRenderStatic)

*line 13*
    Remove the trait :php-short:`\TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic`.
*lines 23, 24*
    Switch the render method from `renderStatic()` to `render()`.
*lines 25, 26*
    Fetch the arguments from the class property instead method argument.


..  _fluid-custom-viewhelper-CompileWithContentArgumentAndRenderStatic-migration:

Migration: Remove deprecated trait `CompileWithContentArgumentAndRenderStatic`
------------------------------------------------------------------------------

If :php:`\TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRender`
was also used in your ViewHelper implementation, further steps are needed:

..  literalinclude:: _CustomViewHelper/_MigrateCompileWithContentArgumentAndRender.diff
    :caption: EXT:my_extension/Classes/ViewHelpers/GravatarViewHelper.php (diff removing CompileWithContentArgumentAndRender)

*line 13*
    Remove the trait :php-short:`\TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRender`.
*lines 22, 23*
    Switch the render method from `renderStatic()` to `render()`.
*lines 24, 25*
    Use the non-static method :php:`$this->renderChildren()` instead of the
    closure `$renderChildrenClosure()`.

Remove calls to removed `renderStatic()` method of another ViewHelper
---------------------------------------------------------------------

If you called a now removed `renderStatic()` method from within another
ViewHelper's `renderStatic()` method  you can replace the code like this:

..  literalinclude:: _CustomViewHelper/_MigrateRenderStaticInvocation.diff
    :caption: EXT:my_extension/Classes/ViewHelpers/GravatarViewHelper.php (diff replacing renderStatic() calls)

*line 27, 28ff*
    Replace the static call to the `renderStatic()` method of another ViewHelper
    by calling `$this->renderingContext->getViewHelperInvoker()->invoke()` instead.

    See also :php:`TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperInvoker`.
