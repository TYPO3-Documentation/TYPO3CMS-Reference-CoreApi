..  include:: /Includes.rst.txt
..  index::
    ViewHelpers; Custom
    Fluid; Custom ViewHelpers
..  _fluid-custom-viewhelper:

==============================
Developing a custom ViewHelper
==============================

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

All ViewHelpers implementing
:php-short:`\TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper`
can receive arbitrary tag attributes which will be appended to the
resulting HTML tag. In the past, this was only possible for
explicitly registered arguments.

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

..  _render-method:

`render()` method
-----------------

Most of the time, this method is implemented.

..  _fluid-custom-viewhelper-access:

How to access classes in the ViewHelper implementation
======================================================

Custom ViewHelper implementations support
`Dependency injection <https://docs.typo3.org/permalink/t3coreapi:dependency-injection>`_.

You can, for example, inject the :php-short:`\TYPO3\CMS\Core\Database\ConnectionPool`
to access the database by using the `database abstraction layer DBAL <https://docs.typo3.org/permalink/t3coreapi:doctrine-dbal>`_.

Some objects depend on the current context and can be fetched from
the rendering context:

..  note::
    This list is not complete, please help us with more examples.

..  _fluid-custom-viewhelper-access-request:

Accessing the current Request in a ViewHelper implementation
------------------------------------------------------------

You can use a `render()` method in the ViewHelper implementation to get the
current :php-short:`\Psr\Http\Message\ServerRequestInterface` object
from the :php-short:`TYPO3\CMS\Fluid\Core\Rendering\RenderingContext`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/ViewHelpers/SomeViewHelper.php

    public function render()
    {
        $request = $this->renderingContext->getRequest();
        return 'Hello World!';
    }

..  _fluid-custom-viewhelper-access-contentObject:

Using stdWrap / fetching the current ContentObject in a ViewHelper implementation
---------------------------------------------------------------------------------

You can `access the ContentObjectRenderer <https://docs.typo3.org/permalink/t3coreapi:tsfe-contentobjectrenderer>`_
from the :php-short:`\Psr\Http\Message\ServerRequestInterface`:

..  code-block:: php
    :caption: EXT:my_extension/Classes/ViewHelpers/SomeViewHelper.php

    use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

    public function render()
    {
        $request = $this->renderingContext->getRequest();
        $cObj = $request->getAttribute('currentContentObject');
        return $cObj->stdWrap('Hello World', ['wrap' => '|!']);
    }

..  deprecated:: 13.4
    The class :php-short:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController`
    and its global instance :php:`$GLOBALS['TSFE']`, which were formerly used to fetch the
    ContentObjectRenderer, have been marked as
    deprecated. The class will be removed in TYPO3 v14. See
    `TSFE <https://docs.typo3.org/permalink/t3coreapi:tsfe>`_ for migration steps.
