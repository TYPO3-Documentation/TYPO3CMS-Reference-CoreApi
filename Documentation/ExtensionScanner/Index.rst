.. include:: ../Includes.txt

.. _extension-scanner:


=================
Extension scanner
=================

Introduction
------------

The extension scanner which has been introduced with TYPO3 core version 9 as part of the system
management (formerly "install tool") provides an interactive interface to scan extension code
for usage of TYPO3 core API which has been removed or deprecated.

The module can be a great help for extension developers and site maintainers when upgrading to
new core versions. It can point out code places within extensions that need attention. However,
the detection approach - based on static code analysis - is limited by concept: false positives/negatives
are impossible to avoid.

This document has been written to explain the design goals of the scanner, to point out what it can
and can't do. The document should help extension and project developers to get the best out of the tool,
and it should help core developers to add core patches which use the scanner.


Goals and non goals
-------------------

* Help extension authors quickly find code in extensions that may need attention when upgrading to
  newer core versions.

* Extend the existing RST documentation files which are shown in the ``Upgrade Analysis`` section
  with additional information giving extension authors and site developers hints if they are affected
  by a specific change.

* It is not a design goal to scan for every TYPO3 core API change.

* It should later be possible to scan different languages - not only PHP - TypoScript or Fluid could be examples.

* Core developers should be able to easily register and maintain matchers for new deprecations or breaking patches.

* Implementation within the TYPO3 core backend has been primary goal. While it might be possible, integration
  into IDEs like PhpStorm has not been a design goal. Also, matcher configuration is bound to the core version,
  e.g. tests concerning v9 are not intended to be executed on v8.

* Some of RST files that document a breaking change or deprecated API can be used to scan extensions.
  If those find no matches, the RST documentation files are tagged with a "no match" label telling integrators
  and project developers that they do not need to concern themselves with that particular change.

* The extension scanner is not meant to be used on core extensions - it is not a core development helper.


Limits
------

The extension scanner is based on `static code analysis <https://en.wikipedia.org/wiki/Static_program_analysis>`__.
"Understanding and analyzing" code flow from within code itself (dynamic code analysis) is not performed.
This means the scanner is basically not much more clever than a simple string search paired with
some additional analysis to reduce false positives/negatives.

Let's explain this by example. Suppose a static method was deprecated:

.. code-block:: php

    <?php
    namespace TYPO3\CMS\Core\Utility;

    class SomeUtility
    {
        /**
         * @deprecated since ...
         */
        public static function someMethod($foo = '') {
            // do something deprecated
        }
    }

This method is registered in the matcher class
:php:`TYPO3\CMS\Install\CodeScanner\Php\MethodCallStaticMatcher` like this:

.. code-block:: php

    'TYPO3\CMS\Core\Utility\SomeUtility::someMethod' => [
        'numberOfMandatoryArguments' => 0,
        'maximumNumberOfArguments' => 1,
        'restFiles' => [
            'Deprecation-12345-DeprecateSomeMethod.rst',
        ],
    ],

The array key is the class name plus method name, :php:`numberOfMandatoryArguments` is the number
of arguments that must be passed to the method, :php:`maximumNumberOfArguments` is the maximum
number of arguments the method accepts. The :php:`restFiles` array contains file names of
:php:`.rst` file(s) that explain details of the deprecation.

Now let's look at a theoretical class of an extension that uses this deprecated method:

.. code-block:: php

    <?php
    namespace My\Extension\Consumer;

    use TYPO3\CMS\Core\Utility\SomeUtility;

    class SomeClass
    {
        public function someMethod()
        {
            // "Strong" match: Full class combination and method call matches
            \TYPO3\CMS\Core\Utility\SomeUtility::someMethod();

            // "Strong" match: Full class combination and method call matches
            \TYPO3\CMS\Core\Utility\SomeUtility::someMethod('foo');

            // "Strong" match: Use statements are resolved
            SomeUtility::someMethod('foo');

            // "Weak" match: Scanner does not know if $foo is class "SomeUtility", but method name matches
            $foo = '\TYPO3\CMS\Core\Utility\SomeOtherUtility';
            $foo::someMethod();

            // No match: The method is static but called dynamically
            $foo->someMethod();

            // No match: The method is called with too many arguments
            SomeUtility::someMethod('foo', 'bar');

            // No match: A different method is called
            SomeUtility::someOtherMethod();
        }
    }

The first three method calls are classified as strong matches: the full class name is used
and the method name matches including the argument restrictions.
The fourth call :php:`$foo::someMethod();` is classified as a weak match and is a false
positive: Class :php:`SomeOtherUtility` is called instead of :php:`SomeUtility`.
The sixth method call :php:`SomeUtility::someMethod('foo', 'bar')` does not match because the
method is called with two arguments instead of one argument.

The "too many arguments" restriction is a measure to suppress false positives: If a method with
the same name exists which accepts a different number of arguments, valid calls to the other method
may be reported as false positives depending on the number of arguments used in the call.

As you can see, depending on given extension code, the scanner may find false positives and it may
not find matches if for instance the number of arguments is not within a specified range.

The example above looks for static method calls, which are relatively reliable to match. For dynamic
:php:`->` method call, a strong match on the class name is almost never achieved, which means almost
all matches for such cases will be weak matches.

Additionally, an extension may already have a version check around a function call to run one function
on one core version and a different one on another core version. The extension scanner does not
understand these constructs and would still show the deprecated call as a match, even if it was wrapped
in a core version check.


Extension authors
-----------------

Even though the extension scanner can be a great help to quickly see which places of an extension
may need attention when upgrading to a newer core version, the following points should be considered:

* It should not be a goal to always have a green output of the extension scanner, especially
  if the extension scanner shows a false positive.

* A green output when scanning an extension does *not* imply that the extension actually works with
  that core version: Some deprecations or breaking changes are not scanned (for example those causing 
  too many false positives) and the scanner does not support all script/markup languages.

* The breaking change / deprecation RST files shipped with a core version are still relevant and should
  be read.

* If the extension scanner shows one or more false positives the extension author has the following options:

  * Ignore the false positive

  * Suppress a single match with an inline comment:

    .. code-block:: php

        // @extensionScannerIgnoreLine
        $foo->someFalsePositiveMatch('foo');

  * Suppress all matches in an entire file with a comment. This is especially useful for
    dedicated classes which act as proxies for core API:

    .. code-block:: php

        <?php

        /**
         * @extensionScannerIgnoreFile
         */
        class SomeClassIgnoredByExtensionScanner
        {
            ...
        }

  * The author could request a core patch to remove a specific match from the extension scanner
    if it triggers too many false positives. If multiple authors experience the same false positives
    they are even more likely to be removed upon request.

  * Some of the matchers can be restricted to only include strong matches and ignore weak ones. The
    extension author may request a "strong match only" patch for specific cases to suppress
    common false positives.

* If a PHP file is invalid and can not be compiled for a given PHP version, the extension scanner
  may throw a general parse error for that file. Additionally, if an extension calls a matched method
  with too many arguments (which is valid in PHP) then the extension scanner will not show that
  as a match. In general: the cleaner the code base of a given extension is and the simpler the code lines are,
  the more useful the extension scanner will be.

* If an extension is cluttered with ``@extensionScannerIgnoreLine`` or ``@extensionScannerIgnoreFile``
  annotations this could be an indication to the extension author to consider branching off
  an extensions to support individual core versions instead of supporting multiple versions in the same release.


Project developers
------------------

Project developers are developers who maintain a project that consists of third party extensions
(eg. from TER) together with some custom, project-specific extensions. When analysing the output of
an extension scanner run the following points should be considered:

* It is not necessary for all scanned extensions to report green status. Due to the nature of the
  extension scanner which can show false positives, extension authors may decide to ignore a false
  positive (see above). That means that even well maintained extensions may not report green.

* A green status in the scanner does not imply that the extension also works, just that it neither
  uses deprecated methods nor core any API which received breaking changes. It also does not indicate
  anything about the quality of the extension: false positives can be caused by for example supporting
  multiple TYPO3 versions in the same extension release.

Core developers
---------------

When changing core API, core developers should keep an eye on the extension scanner and add matcher
configurations if possible. This is typically the case if PHP API was changed and the patch comes with
a deprecation or breaking ReST file to document the change.

Connection to Changelog RST files
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

All changelog type RST file since core version 9 have to be tagged with one of the three tags
``FullyScanned``, ``PartiallyScanned`` or ``NotScanned``. In particular, the ``FullyScanned`` tag is
used by the extension scanner to mark instances as "not affected by this change", as such they should
be added with care and only if the scanner configuration matches all changes mentioned in the RST file.
If only parts of the RST file are covered, ``PartiallyScanned`` has to be added and the RST file should
mention which parts are and are not covered. If the scanner does not cover a RST file at all then
``NotScanned`` can be added.

If an RST file is renamed the file may be covered in a matcher configuration which then needs to be
adapted, too. The RST files are not bound to specific directories in the matcher configuration
so moving a RST file to a different location within the ``Changelog`` directory has no effect.

Extension scanner PHP configuration
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The PHP part of the extension scanner is based on the library
`nikic/php-parser <https://github.com/nikic/PHP-Parser>`__. This library creates an
`abstract syntax tree <https://en.wikipedia.org/wiki/Abstract_syntax_tree>`__ from any given
compilable PHP file. It comes with a traverser for recursive iteration over the tree that
implements a visitor pattern, own visitors can be added. A single "matcher" is a visitor added
to the traverser. A default visitor resolves all shortened namespaced class usages to their
fully qualified name, which is a great help for our matchers.

This basically means: The whole AST is traversed exactly once for each PHP file and all matchers
are called for each node. Matches can then decide if they match a configured deprecation or breaking
scenario.

All matchers are covered by unit tests and a fixture that shows what exactly is matched. Studying the
fixture can be a good way to understand the matcher.

Matchers are systematically named: for method calls there is a usually one variant for dynamic and
one for static calls. If for example a static method changed its argument signature by removing
an argument then the according matcher class is :php:`TYPO3\CMS\Install\CodeScanner\Php\MethodArgumentDroppedStaticMatcher`.

Single matcher configurations are pretty obvious, new ones should be added at the end. When adding
matcher configurations it should be verified the match it is not already covered by some other matcher
(possibly in another RST file).
