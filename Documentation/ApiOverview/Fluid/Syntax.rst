..  include:: /Includes.rst.txt
..  _fluid-syntax:

============
Fluid syntax
============

..  _fluid-variables:

Variables
=========

Assign a variable in PHP:

..  code-block:: php

    $this->view->assign('title', 'An example title');

Output it in a Fluid template:

..  code-block:: html

    <h1>{title}</h1>

The result:

..  code-block:: html

    <h1>An example title</h1>

In the template's HTML code, wrap the variable name into curly
braces to output it.

..  _fluid-variables-reserved:

Reserved variables in Fluid
---------------------------

..  versionchanged:: Fluid 4.0 / TYPO3 v13.3
    Assigning variables of names `true`, `false` or `null` will throw
    an exception in Fluid v4.

    See also :ref:`fluid-variables-reserved-migration`.

The following variable names are reserved and may not be used:

*   `false`
*   `null`
*   `true`

..  _fluid-variables-reserved-migration:

Migration
~~~~~~~~~

..  literalinclude:: _Syntax/_MyController.diff
    :caption: EXT:my_extension/Classes/Controller/MyController.php (diff)


..  literalinclude:: _Syntax/_MyTemplate.diff
    :caption: EXT:my_extension/Resources/Private/Templates/MyTemplate.html (diff)

..  _fluid-boolean:

Boolean values
--------------

..  versionadded:: Fluid 4.0 / TYPO3 v13.3
    The boolean literals `{true}` and `{false}` have been introduced.

You can use the boolean literals `{true}` and `{false}` to enable or disable
properties of tag-based ViewHelpers:

..  code-block:: html

    <my:viewhelper async="{true}" />
    Result: <tag async="async" />

    <my:viewhelper async="{false}" />
    Result: <tag />

Of course, any variable containing a boolean can be supplied as well:

..  code-block:: html

    <my:viewhelper async="{isAsync}" />

It is also possible to cast a string to a boolean

..  code-block:: html

    <my:viewhelper async="{myString as boolean}" />

For compatibility reasons empty strings still lead to the attribute
being omitted from the tag.

..  code-block:: html

    <f:variable name="myEmptyString"></f:variable>
    <my:viewhelper async="{myEmptyString}" />
    Result: <tag />

..  _fluid-arrays:

Arrays and objects
------------------

Assign an array in PHP:

..  code-block:: php

    $this->view->assign('data', ['Low', 'High']);

Use the dot ``.`` to access array keys:

..  code-block:: html
    :caption: EXT:site_package/Resources/Private/Templates/SomeTemplate.html

    <p>{data.0}, {data.1}</p>

This also works for object properties:

..  code-block:: php
    :caption: EXT:site_package/Classes/Controller/SomeController.php

    $this->view->assign('product', $myProduct);

Use it like this:

..  code-block:: html
    :caption: EXT:site_package/Resources/Private/Templates/SomeTemplate.html

    <p>{product.name}: {product.price}</p>

..  _fluid-dynamic-properties:

Accessing dynamic keys/properties
---------------------------------

It is possible to access array or object values by a dynamic index:

..  code-block:: html
    :caption: EXT:site_package/Resources/Private/Templates/SomeTemplate.html

    {myArray.{myIndex}}

..  _fluid-syntax-viewhelpers:

ViewHelpers
===========

ViewHelpers are special tags in the template which provide more complex
functionality such as loops or generating links.

The functionality of the ViewHelper is implemented in PHP, every ViewHelper has
its own PHP class.

See the :ref:`Fluid ViewHelper Reference <t3viewhelper:start>` for a complete
list of all available ViewHelpers.

Within Fluid, the ViewHelper is used as a special HTML element with a namespace
prefix, for example the namespace prefix "f" is used for ViewHelpers from the
Fluid namespace:

..  code-block:: html
    :caption: Fluid example with for ViewHelper

    <f:for each="{results}" as="result">
       <li>{result.title}</li>
    </f:for>

The "f" namespace is already defined, but can be explicitly specified to
improve IDE autocompletion.

Fluid example with custom ViewHelper "custom" in namespace "blog":

..  code-block:: html
    :caption: EXT:blog_example/Resources/Private/Templates/SomeTemplate.html

    <blog:custom argument1="something"/>

Here, we are using a custom ViewHelper within the namespace "blog". The namespace
must be registered explicitly, see the next section.

..  _fluid-syntax-viewhelpers-import-namespaces:

Import ViewHelper namespaces
----------------------------

There are 3 ways to import ViewHelper namespaces in TYPO3. In all three examples
`blog` is the namespace available within the Fluid template and
`MyVendor\BlogExample\ViewHelpers` is the PHP namespace to import into Fluid.

1.  Use an :html:`<html>` tag with xmlns

    ..  code-block:: html
        :caption: EXT:blog_example/Resources/Private/Templates/SomeTemplate.html

        <html
           xmlns:blog="http://typo3.org/ns/Myvendor/MyExtension/ViewHelpers"
           data-namespace-typo3-fluid="true"
        >
        </html>

    This is useful for various IDEs and HTML auto-completion. The :html:`<html>`
    element itself will not be rendered if the attribute
    :html:`data-namespace-typo3-fluid="true"` is specified.

    The namespace is built using the fixed `http://typo3.org/ns` prefix followed
    by the vendor name, package name and the fixed `ViewHelpers` suffix.

    ..  important::
        Do not use `https://typo3.org` (HTTPS instead of HTTP). Fluid would not be
        able to detect this namespace to convert it to PHP class name prefixes.
        Remember: This is a unique XML namespace, it does not need to contain a valid URI.

2.  Local namespace import via curly braces {}-syntax

    ..  code-block:: html
        :caption: EXT:blog_example/Resources/Private/Templates/SomeTemplate.html

        {namespace blog=MyVendor\BlogExample\ViewHelpers}

    Each of the rows will result in a blank line. Multiple import statements can go
    into a single or multiple lines.

3.  Global namespace import

    Fluid allows to register global namespaces. This is already done for
    `typo3/cms-fluid` and `typo3fluid/fluid` ViewHelpers. Therefore they are always
    available via the `f` namespace.

    Custom ViewHelpers, for example for a site package, can be registered the same way.
    Namespaces are registered within
    :php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']`, for example:

     ..  literalinclude:: _Syntax/_ext_localconf.php
         :language: php
         :caption: EXT:mye_extension/ext_localconf.php

..  _fluid-viewhelper-attributes:

ViewHelper attributes
---------------------

..  _fluid-viewhelper-attributes-simple:

Simple
~~~~~~

Variables can be inserted into ViewHelper attributes by putting them in
curly braces:

..  code-block:: html
    :caption: EXT:site_package/Resources/Private/Templates/SomeTemplate.html

    Now it is: <f:format.date format="{format}">{date}</f:format.date>

..  _fluid-inline-notation:

Fluid inline notation
=====================

..  tip::

    There is an online converter from tag-based syntax to inline syntax:
    `Fluid Converter <https://fluid-to-inline-converter.com/>`__

An alternative to the tag based notation used above is inline notation. For
example, compare the 2 identical Fluid constructs:

..  code-block:: html
    :caption: EXT:my_extensions/Resources/Private/Templates/Something.html

    <!-- tag based notation -->
    <f:translate key="LLL:EXT:core/Resources/Private/Language/locallang_misc.xlf:bookmark_inactive"/>

    <!-- inline notation -->
    {f:translate(key: 'LLL:EXT:core/Resources/Private/Language/locallang_misc.xlf:bookmark_inactive')}

Tag based notation and inline notation can be freely mixed within one Fluid
template.

Inline notation is often a better choice if HTML tags are nested, for example:

..  code-block:: html
    :caption: EXT:my_extensions/Resources/Private/Templates/Something.html

    <!-- tag based notation -->
    <span title="<f:translate key='LLL:EXT:core/Resources/Private/Language/locallang_misc.xlf:bookmark_inactive'/>">

    <-- inline notation -->
    <span title="{f:translate(key: 'LLL:EXT:core/Resources/Private/Language/locallang_misc.xlf:bookmark_inactive')}">

More complex example with chaining:

..  code-block:: html
    :caption: EXT:my_extensions/Resources/Private/Templates/Something.html

    <!-- tag based notation -->
    <f:format.padding padLength="40"><f:format.date format="Y-m-d">{post.date}</f:format.date></f:format.padding>

    <!-- inline notation -->
    {post.date -> f:format.date(format: 'Y-m-d') -> f:format.padding(padLength: 40)}

..  _fluid-syntax-boolean-conditions:

Boolean conditions
==================

Boolean conditions are expressions that evaluate to true or false.

Boolean conditions can be used as ViewHelper arguments, whenever the datatype
:html:`boolean` is given, e.g. in the
:ref:`if ViewHelper <t3viewhelper:typo3fluid-fluid-if>` :html:`condition` argument.

1.  The expression can be a variable which is evaluated as follows:

    *   number: evaluates to :php:`true`, if > 0.
    *   array: evaluates to :php:`true` if it contains at least one element

2.  The expression can be a statement consisting of: term1 operator term2, for
    example :html:`{variable} > 3`

    *   The operator can be one of :html:`>`, :html:`>=`, :html:`<`, :html:`<=`,
        :html:`==`, :html:`===`, :html:`!=`, :html:`!==` or :html:`%`,

3.  The previous expressions can be combined with :html:`||` (or) or :html:`&&`
    (and).


Examples:

..  code-block:: none

    <f:if condition="{myObject}">
      ...
    </f:if>

    <f:if condition="{myNumber} > 3 || {otherNumber} || {somethingelse}">
       <f:then>
          ...
       </f:then>
       <f:else>
          ...
       </f:else>
    </f:if>

    <my:custom showLabel="{myString} === 'something'">
      ...
    </my:custom>


Example using the inline notation:

..  code-block:: html

    <div class="{f:if(condition: blog.posts, then: 'blogPostsAvailable', else: 'noPosts')}">
      ...
    </div>

..  _fluid-comments:

Comments
========

If you want to completely skip parts of your template, you can make use of
the :ref:`t3viewhelper:typo3fluid-fluid-comment`.

..  versionchanged:: 13.3
    The content of the :ref:`t3viewhelper:typo3fluid-fluid-comment` is removed
    before parsing. It is no longer necessary to combine it with CDATA tags
    to disable parsing.

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

    <f:comment>
        This will be ignored by the Fluid parser and will not appear in
        the source code of the rendered template
    </f:comment>

You can also use the :ref:`t3viewhelper:typo3fluid-fluid-comment` to temporarily comment
out some Fluid syntax while debugging:

..  code-block:: html
    :caption: EXT:my_extension/Resources/Private/Templates/SomeTemplate.html

    <f:comment>
        <x:someBrokenFluid>
    </f:comment>
