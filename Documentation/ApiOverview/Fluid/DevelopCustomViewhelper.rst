.. include:: /Includes.rst.txt
.. index::
   ViewHelpers; Custom
   Fluid; Custom ViewHelpers
.. _fluid-custom-viewhelper:

==============================
Developing a custom ViewHelper
==============================

This chapter will demonstrate how to write a custom Fluid ViewHelper in TYPO3.

A "Gravatar" ViewHelper is created, which uses an email address as parameter
and shows the picture from gravatar.com if it exists.

The official documentation of Fluid for writing custom ViewHelpers can be found
within Fluid documentation at
https://github.com/TYPO3/Fluid/blob/master/doc/FLUID_CREATING_VIEWHELPERS.md.

.. contents:: Contents of this page
   :local:
   :depth: 2


Fluid
=====

The custom ViewHelper is not part of the default distribution. Therefore a
namespace import is necessary to use this ViewHelper. In the following example,
the namespace :php:`\MyVendor\BlogExample\ViewHelpers` is imported with the
prefix `blog`. Now, all tags starting with `blog:` are interpreted as
ViewHelper from within this namespace:

.. code-block:: html
   :caption: EXT:blog_example/Resources/Private/Templates/SomeTemplate.html

   {namespace blog=MyVendor\BlogExample\ViewHelpers}

For further information about namespace import, see
:ref:`fluid-syntax-viewhelpers-import-namespaces`.

The ViewHelper should be given the name "gravatar" and only take an email
address as a parameter. The ViewHelper is called in the template as follows:

.. code-block:: html
   :caption: EXT:blog_example/Resources/Private/Templates/SomeTemplate.html

   <blog:gravatar emailAddress="username@example.org" />

See :ref:`global-namespace-import` for information how to import
namespaces globally.

AbstractViewHelper implementation
=================================

Every ViewHelper is a PHP class. For the Gravatar ViewHelper, the name of the
class is :php:`\MyVendor\BlogExample\ViewHelpers\GravatarViewHelper`.

.. code-block:: php
   :caption: EXT:blog_example/Classes/ViewHelpers/GravatarViewHelper.php
   :linenos:

   <?php
   namespace MyVendor\BlogExample\ViewHelpers;

   use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
   use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

   final class GravatarViewHelper extends AbstractViewHelper
   {
      use CompileWithRenderStatic;

      protected $escapeOutput = false;

      public function initializeArguments()
      {
          // registerArgument($name, $type, $description, $required, $defaultValue, $escape)
          $this->registerArgument('emailAddress', 'string', 'The email address to resolve the gravatar for', true);
      }

      public static function renderStatic(
          array $arguments,
          \Closure $renderChildrenClosure,
          RenderingContextInterface $renderingContext
      ) {
          // this is improved with the TagBasedViewHelper (see below)
          return '<img src="http://www.gravatar.com/avatar/' .
            md5($arguments['emailAddress']) .
            '" />';
      }
   }

:php:`AbstractViewHelper`
-------------------------

*line 7*

Every ViewHelper must inherit from the class
:php:`\TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper`.

A ViewHelper can also inherit from subclasses of :php:`AbstractViewHelper`, e.g.
from :php:`\TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper`.
Several subclasses are offering additional functionality. The
:php:`TagBasedViewHelper` will be explained :ref:`later on in this chapter
<creating-xml-tags-using-tagbasedviewhelper>` in detail.

.. _fluid-viewhelper-custom-escaping-of-output:

Escaping of output
------------------

*line 11*

Setting the property :php:`$escapeOutput` to false is necessary to prevent
escaping of output.

By default, all output is escaped by :php:`htmlspecialchars` to prevent cross
site scripting.

If escaping of children is disabled, no nodes passed with inline
syntax or values used as tag content will be escaped. Note that
:php:`$escapeOutput` takes priority: if it is disabled, escaping child nodes
is also disabled unless explicitly enabled.

Passing in children is explained in :ref:`prepare-viewhelper-for-inline-syntax`.

.. _fluid-viewhelper-custom-initializeArguments:

:php:`initializeArguments()`
----------------------------

*line 13*

The :php:`Gravatar` ViewHelper must hand over the email address which
identifies the Gravatar. Every ViewHelper has to declare which parameters are
accepted explicitly. The registration happens inside :php:`initializeArguments()`.

In the example above, the ViewHelper receives the argument `emailAddress` of
type `string`. These arguments can be accessed
through the array :php:`$arguments`, which is passed into the :php:`renderStatic()`
method (see :ref:`next section <fluid-viewhelper-custom-renderStatic>`).

.. tip::

   Sometimes arguments can take various types. In this case, the type `mixed`
   should be used.

.. _fluid-viewhelper-custom-renderStatic:

:php:`renderStatic()`
---------------------

*line 19*

The method :php:`renderStatic()` is called once the ViewHelper is rendered. The
return value of the method is rendered directly.

* line 9*

The trait :php:`CompileWithRenderStatic` must be used if the class implements
:php:`renderStatic()`.

.. _creating-xml-tags-using-tagbasedviewhelper:
.. _creating-html-tags-using-tagbasedviewhelper:

Creating HTML/XML tags with the :php:`AbstractTagBasedViewHelper`
=================================================================

For ViewHelpers which create HTML/XML tags, Fluid provides an enhanced base
class: :php:`\TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper`.  This
base class provides an instance of
:php:`\TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder` that can be used to create
HTML-tags. It takes care of the syntactically correct creation and, for example,
escapes single and double quotes in attribute values.

.. attention::

   Correctly escaping the attribute values is mandatory as it affects security
   and prevents cross-site scripting attacks.

Because the Gravatar ViewHelper creates an :html:`img` tag the use of the
:php:`\TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder` is advised:

.. code-block:: php
   :caption: EXT:blog_example/Classes/ViewHelpers/GravatarViewHelper.php
   :linenos:

   <?php
   namespace MyVendor\BlogExample\ViewHelpers;

   use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

   class GravatarViewHelper extends AbstractTagBasedViewHelper
   {
       protected $tagName = 'img';

       public function initializeArguments()
       {
           parent::initializeArguments();
           $this->registerUniversalTagAttributes();
           $this->registerTagAttribute('alt', 'string', 'Alternative Text for the image');
           $this->registerArgument('emailAddress', 'string', 'The email address to resolve the gravatar for', true);
       }

       public function render()
       {
           $this->tag->addAttribute(
               'src',
               'http://www.gravatar.com/avatar/' . md5($this->arguments['emailAddress'])
           );
           return $this->tag->render();
       }
   }

What is different in this code?

The attribute :php:`$escapeOutput` is no longer necessary.

:php:`AbstractTagBasedViewHelper`
---------------------------------

*line 6*

The ViewHelper does not inherit directly from :php:`AbstractViewHelper` but
from :php:`AbstractTagBasedViewHelper`, which provides and initializes the tag builder.

:php:`$tagName`
---------------

*line 8*

There is a class property :php:`$tagName` which stores the name of the tag to be
created (:html:`<img>`).

:php:`$this->tag->addAttribute()`
---------------------------------

*line 20*

The tag builder is available at property :php:`$this->tag`. It offers the method
:php:`addAttribute()` to add new tag attributes. In our example the attribute
`src` is added to the tag.

:php:`$this->tag->addAttribute()`
---------------------------------

*line 24*

The GravatarViewHelper creates an img tag builder, which has a method named
:php:`render()`. After configuring the tag builder instance, the rendered tag
markup is returned.

.. note::

   As :php:`$this->tag` is an object property, :php:`render()` is used to
   generate the output. :php:`renderStatic()` would have no access. For further
   information take a look at :ref:`the-different-render-methods`.

:php:`$this->registerTagAttribute()`
------------------------------------

Furthermore the :php:`TagBasedViewHelper` offers assistance for ViewHelper
arguments that should recur directly and unchanged as tag attributes. These
must be registered with the method :php:`$this->registerTagAttribute()`
within :php:`initializeArguments`.
If support for the :html:`<img>` attribute :html:`alt`
should be provided in the ViewHelper, this can be done by initializing this in
:php:`initializeArguments()` in the following way:

.. code-block:: php
   :caption: EXT:blog_example/Classes/ViewHelpers/GravatarViewHelper.php

   public function initializeArguments()
   {
       // registerTagAttribute($name, $type, $description, $required = false)
       $this->registerTagAttribute('alt', 'string', 'Alternative Text for the image');
   }

For registering the universal attributes id, class, dir, style, lang, title,
accesskey and tabindex there is a helper method
:php:`registerUniversalTagAttributes()` available.

If support for universal attributes should be provided and in addition to the
`alt` attribute in the Gravatar ViewHelper the following
:php:`initializeArguments()` method will be necessary:

.. code-block:: php
   :caption: EXT:blog_example/Classes/ViewHelpers/GravatarViewHelper.php

   public function initializeArguments()
   {
       parent::initializeArguments();
       $this->registerUniversalTagAttributes();
       $this->registerTagAttribute('alt', 'string', 'Alternative Text for the image');
   }

.. _insert-optional-arguments:

Insert optional arguments
=========================

An optional size for the image can be provided to the Gravatar ViewHelper. This
size parameter will determine the height and width in pixels of the
image and can range from 1 to 512. When no size is given, an image of 80px is
generated.

The :php:`render()` method can be improved like this:

.. code-block:: php
   :caption: EXT:blog_example/Classes/ViewHelpers/GravatarViewHelper.php

   public function initializeArguments()
   {
       $this->registerArgument('emailAddress', 'string', 'The email address to resolve the gravatar for', true);
       $this->registerArgument('size', 'integer', 'The size of the gravatar, ranging from 1 to 512', false, 80);
   }

   public function render()
   {
       $this->tag->addAttribute(
          'src',
          'http://www.gravatar.com/avatar/' .
              md5($this->arguments['emailAddress']) .
              '?s=' . urlencode($this->arguments['size'])
       );
       return $this->tag->render();
   }

With this setting of a default value and setting the fourth argument to `false`,
the `size` attribute becomes optional.

.. _prepare-viewhelper-for-inline-syntax:

Prepare ViewHelper for inline syntax
====================================

So far, the Gravatar ViewHelper has focused on the tag structure of the
ViewHelper. The call to render the ViewHelper was written with tag syntax, which
seemed obvious because it itself returns a tag:

.. code-block:: html
   :caption: EXT:blog_example/Resources/Private/Templates/SomeTemplate.html

   <blog:gravatar emailAddress="{post.author.emailAddress}" />

Alternatively, this expression can be written using the inline notation:

.. code-block:: html
   :caption: EXT:blog_example/Resources/Private/Templates/SomeTemplate.html

   {blog:gravatar(emailAddress: post.author.emailAddress)}

One should see the Gravatar ViewHelper as a kind of post-processor for an email
address and would allow the following syntax:

.. code-block:: html
   :caption: EXT:blog_example/Resources/Private/Templates/SomeTemplate.html

   {post.author.emailAddress -> blog:gravatar()}

This syntax places focus on the variable that is passed to the ViewHelper as it
comes first.

The syntax `{post.author.emailAddress -> blog:gravatar()}` is an alternative
syntax for `<blog:gravatar>{post.author.emailAddress}</blog:gravatar>`. To
support this, the email address comes either from the argument `emailAddress`
or, if it is empty, the content of the tag should be interpreted as email
address.

This is typically used with formatting ViewHelpers. These ViewHelpers all
support both tag mode and inline syntax.

Depending on the implemented method for rendering, the implementation is
different:

.. _with-renderstatic:

With :php:`renderStatic()`
--------------------------

To fetch the content of the ViewHelper, the argument
:php:`$renderChildrenClosure` is available.  This returns the evaluated object
between the opening and closing tag.

Lets have a look at the new code of the :php:`renderStatic()` method:

.. code-block:: php
   :caption: EXT:blog_example/Classes/ViewHelpers/GravatarViewHelper.php

   <?php
   namespace MyVendor\BlogExample\ViewHelpers;

   use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
   use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
   use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

   class GravatarViewHelper extends AbstractViewHelper
   {
       use CompileWithContentArgumentAndRenderStatic;

       protected $escapeOutput = false;

       public function initializeArguments()
       {
           $this->registerArgument('emailAddress', 'string', 'The email address to resolve the gravatar for');
       }

       public static function renderStatic(
           array $arguments,
           \Closure $renderChildrenClosure,
           RenderingContextInterface $renderingContext
       ) {
           $emailAddress = $renderChildrenClosure();

           return '<img src="http://www.gravatar.com/avatar/' .
               md5($emailAddress) .
               '" />';
       }
   }

.. _with-render:

With :php:`render()`
--------------------

To fetch the content of the ViewHelper the method :php:`renderChildren()` is
available in the :php:`AbstractViewHelper`. This returns the evaluated object
between the opening and closing tag.

Lets have a look at the new code of the :php:`render()` method:

.. code-block:: php
   :caption: EXT:blog_example/Classes/ViewHelpers/GravatarViewHelper.php

    <?php
    namespace MyVendor\BlogExample\ViewHelpers;

    use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

    class GravatarViewHelper extends AbstractTagBasedViewHelper
    {
        protected $tagName = 'img';

        public function initializeArguments()
        {
            $this->registerArgument('emailAddress', 'string', 'The email address to resolve the gravatar for', false, null);
        }

        public function render()
        {
            $emailAddress = $this->arguments['emailAddress'] ?? $this->renderChildren();

            $this->tag->addAttribute(
                'src',
                'http://www.gravatar.com/avatar/' . md5($emailAddress)
            );

            return $this->tag->render();
        }
    }



.. _handle-additional-arguments:

Handle additional arguments
===========================

If a ViewHelper allows further arguments which have not been explicitly
configured, the :php:`handleAdditionalArguments()` method can be implemented.

The :php:`\TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper` makes use
of this, to allow setting any `data-` argument for tag based ViewHelpers.

The method will receive an array of all arguments, which are passed in addition
to the registered arguments. The array uses the argument name as the key and the
argument value as the value. Within the method, these arguments can be handled.

For example, the :php:`AbstractTagBasedViewHelper` implements the following:

.. code-block:: php
   :caption: EXT:fluid/Classes/ViewHelpers/AbstractTagBasedViewHelper.php

    public function handleAdditionalArguments(array $arguments)
    {
        $unassigned = [];
        foreach ($arguments as $argumentName => $argumentValue) {
            if (strpos($argumentName, 'data-') === 0) {
                $this->tag->addAttribute($argumentName, $argumentValue);
            } else {
                $unassigned[$argumentName] = $argumentValue;
            }
        }
        parent::handleAdditionalArguments($unassigned);
    }

To keep the default behavior, all unwanted arguments should be passed to the
parent method call :php:`parent::handleAdditionalArguments($unassigned);`, to
throw exceptions accordingly.

.. _the-different-render-methods:

The different render methods
============================

ViewHelpers can have one or more of the following three methods for
implementing the rendering. The following section will describe the differences
between all three implementations.

.. _compile-method:

:php:`compile()`-Method
-----------------------

This method can be overwritten to define how the ViewHelper should be compiled.
That can make sense if the ViewHelper itself is a wrapper for another native PHP
function or TYPO3 function. In that case, the method can return the call to this
function and remove the need to call the ViewHelper as a wrapper at all.

The :php:`compile()` has to return the compiled PHP code for the ViewHelper.
Also the argument :php:`$initializationPhpCode` can be used to add further PHP
code before the execution.

.. note::

   The :php:`renderStatic()` method still has to be implemented for the non
   compiled version of the ViewHelper. In the future, this should no longer be
   necessary.

Example implementation:

.. code-block:: php
   :caption: EXT:blog_example/Classes/ViewHelpers/StrtolowerViewHelper.php

   <?php
   namespace MyVendor\BlogExample\ViewHelpers;

   use TYPO3Fluid\Fluid\Core\Compiler\TemplateCompiler;
   use TYPO3Fluid\Fluid\Core\Parser\SyntaxTree\ViewHelperNode;
   use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
   use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
   use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

   class StrtolowerViewHelper extends AbstractViewHelper
   {
       use CompileWithRenderStatic;

       public function initializeArguments()
       {
           $this->registerArgument('string', 'string', 'The string to lowercase.', true);
       }

       public static function renderStatic(
           array $arguments,
           \Closure $renderChildrenClosure,
           RenderingContextInterface $renderingContext
       ) {
           return strtolower($arguments['string']);
       }

       public function compile(
           $argumentsName,
           $closureName,
           &$initializationPhpCode,
           ViewHelperNode $node,
           TemplateCompiler $compiler
       ) {
           return 'strtolower(' . $argumentsName. '[\'string\'])';
       }
   }

.. _renderstatic-method:

:php:`renderStatic()`-Method
----------------------------

Most of the time, this method is implemented. It's the one that is called by
default from within the compiled Fluid.

It is, however, not called on AbstractTagBasedViewHelper implementations. With these classes
you still need to use the :php:`render()` method since that is the only way you can access :php:`$this->tag`
which contains the tag builder that generates the actual XML tag.

As this method has to be static, there is no access to object properties such as
:php:`$this->tag` (in a subclass of :php:`AbstractTagBasedViewHelper`) from within
:php:`renderStatic`.

.. note::

   This method can not be used when access to child nodes is necessary. This is
   the case for ViewHelpers like `if` or `switch` which need to access their
   children like `then` or `else`. In that case, :php:`render()` has to be used.

.. _render-method:

:php:`render()`-Method
----------------------

This method is the slowest one. Only use this method if it is necessary, for
example if access to properties is necessary.
