.. include:: ../Includes.txt

.. _extension-scanner:


=================
Extension scanner
=================

Introduction
------------

The "extension scanner" which has been introduced with TYPO3 core version 9 as part of the system
management (formerly "install tool") provides a click-able interface to actively "scan" extension code
for usage of TYPO3 core API which has been removed or deprecated.

The module can be a great helper for extension developers and site maintainers when upgrading to
new core versions. It can point out code places within extensions that should have a look. However,
the detection approach - based on static code analysis - is limited by concept: There can be false
positives as well as false negatives and this can not be entirely avoided.

This document has been written to explain the design goals of the scanner, to point out what it can
do and what it can't. The document should help extension and project developers to get the best out
of the tool, and it should help core developers to add core patches which use it best.


Goals and non goals
-------------------

* Help extension authors to quickly find places in extensions that may need an eye when upgrading to
  younger core versions.

* Supply the existing "ReST" documentation files which are shown in the "Upgrade Analysis" section
  with additional information giving extension authors and site developers hints if they are affected
  by a specific change or not.

* It is not a design goal to scan for everything the core changes in it's API giving extension authors
  reliable information if they violate something. This can't be done.

* It should later be possible to scan different languages - not only PHP - TypoScript of Fluid could be examples.

* Core developers should be able to register and maintain "matchers" for new deprecated or breaking patches easily
  and provide according configuration along with their patches.

* Implementation within the TYPO3 core backend has been primary goal. While it might be possible, integration
  into IDE's like PhpStorm has not been design goal. Also, matcher configuration is bound to the core version,
  it is not planned to run the core version 9 tests in a core version 8 or similar. Both IDE integration and
  upgrade testing based for different core version could be side projects, those will however not be integrated
  into the core, nor maintained by the core team.

* Some of ReST files that document a breaking or deprecated API change can be "fully" scanned in extensions.
  If those find no matches, according ReST documentation files are tagged as "no match", telling integrators
  and project developers "You do not need to read this file since you are not affected anyway".

* The extension scanner is not meant to be used with core extensions, it is not a core development helper.

* It is not scope of the extension scanner to automatically fix code.


Limits
------

The extension scanner is based on `static code analysis <https://en.wikipedia.org/wiki/Static_program_analysis>`__.
"Understanding and analyzing" code flow from within code itself (dynamic code analysis) is not performed.
This means the scanner is basically not much more clever than a simple string search paired with
some magic to reduce false positives and false negatives.

Let's explain this by example. Suppose the core deprecated a static method call:

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
of arguments that must be given to the method, :php:`maximumNumberOfArguments` is the maximum
number of arguments the method accepts. The :php:`restFiles` array contains file names of
:php:`.rst` file(s) that explain details of the deprecation.

Now let's look at some class of an extension that uses this deprecated method:

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

The first three method calls are classified as "strong" matches: The full class name is given
and the method name matches including the argument restrictions.
The fourth call :php:`$foo::someMethod();` is classified as "weak" match and is a false
positive: Class :php:`SomeOtherUtility` is called instead of :php:`SomeUtility`.
The sixth method call :php:`SomeUtility::someMethod('foo', 'bar')` does not match because the
method is called with two arguments instead of the one argument the method accepts.

The "too many arguments" restriction is a measure to suppress false positives: If a method with
the same name exists that accepts a different number of arguments, valid calls to the other method
may not be found as false positives depending on the count of given arguments.

As you can see, depending on given extension code the scanner may find false positives and it may
not find matches if for instance the number of arguments is not within a specified range. This can
not be avoided.

The example above looks at static method calls which are relatively reliable matches. If
it comes to "dynamic" :php:`->` method call, the "strong" part considering the class name is
almost never done, so all matches are usually "weak" and the number of false positive matches
raises. These cases are especially hard to avoid.

Additionally, an extension may already have a "version check" around a code call to run a call
on one core version and a different one on another core version. The extension scanner does not
understand these constructs and would still show the deprecated call as match, even if wrapped
in a core version constraint.


Extension authors
-----------------

While the extension scanner can be a great helper to quickly see which places of an extension
may need attention when upgrading an extension to support a younger core version, the following
points should be considered:

* It should not be a goal to always have a "green" output of the extension scanner, especially
  if the extension scanner shows a false positive (a wrong match).

* A "green" output when scanning an extension does *not* mean the extension actually works with
  that core version: Not everything is scanned, some deprecations or breaking changes are not
  scanned: The scanner does not support all languages, and some possible matches may have been
  actively removed since they raise too many false positives.

* The breaking / deprecation ReST files coming with a core update should still be read.

* If the extension scanner shows one or more false positives, the extension author has the following options:

  * Ignore the false positive

  * Suppress a single match with an inline comment:

    .. code-block:: php

        // @extensionScannerIgnoreLine
        $foo->someFalsePositiveMatch('foo');

  * Suppress matches in an entire file with a comment. This is especially useful for
    dedicated files that act as "Core API usage version switcher helper":

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
    if it triggers tons on false positives. This might be accepted by the core team if further
    extension authors have the same problem and if that is a common match. Single false positives
    will be ignored and not removed from the matchers since the core team rates the benefit of
    finding a possible correct match higher than having false positives.

  * Some of the matchers can be restricted to "strong" matches ingnoring "weak" matches. The
    extension author may request a "strong match only" patch for specific cases to suppress
    common false positives. The decision about that is again in the core team and mostly depends
    on how common false positives show up.

  * If a PHP file is invalid and can not be compiled for a given PHP version, the extension scanner
    may throw a general parse error for that file. Not compilable code will not be scanned, this is
    a task of a general language linter. Additionally, if an extension calls a method detected by the
    scanner with too many arguments (which is valid in PHP), the extension scanner will not show that
    as a match. In general, the cleaner the code base of a given extension is and the less magic it uses,
    the more useful the extension scanner will be.

* If an extension is cluttered with lots of "@extensionScannerIgnoreLine" or "@extensionScannerIgnoreFile"
  annotations, this could be rated as a sign the extension authors may think about branching off
  an extensions to support more dedicated core versions only in their branches.

* If adding "@extensionScannerIgnoreLine" or "@extensionScannerIgnoreFile" to a file or code line,
  the extension scanner is effectively turned off and can't help with further core deprecations or
  removals in this area. It is up to the extension author to track and update these places.


Project developers
------------------

Project developers are devs who maintain a project that consists of third party extensions
(eg. from the TER) together with some own or project specific extensions. To rate the output of
an extension scanner run, the following points should be considered:

* It is not necessary to have all extensions "green" when scanning them. With the nature of the
  extension scanner which can show false positives, extension authors may decide to ignore a false
  positive (see above). That means even a well maintained extension may not be green. The
  extension scanner is an imperfect helper and can not give a "go" or "no go".

* The number of false positives of an extension scanner run depends on the amount of core API
  calls, the size of the extension in general and the number of methods names that are identical
  to core method names. Depending on what the extension does, this is hard to avoid from an
  extensions author point of view.

* An extension "green" in the scanner does not mean it works.

* If the extension scanner shows a huge number of "ignored lines" and "ignored files" it could mean
  the extension author overreacted with these annotations, should maybe branch off the extension to
  support more dedicated core versions only, the extension is huge in general, the extension uses
  lots of core API that has been changed, or the extension is in bad luck and hits lots of false
  positives. It does not necessarily mean the extension is of bad code quality.


Core developers
---------------

When changing core API, core developers should keep an eye on the extension scanner and add matcher
configuration if possible. This is typically the case if PHP API changed and the patch comes with
a deprecation or breaking ReST file to document the change.

Connection to Changelog ReST files
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

All "Changelog" ReST file since core version 9 have to be tagged with one of the three tags
"FullyScanned", "PartiallyScanned" or "NotScanned". Especially the "FullyScanned" tag is used by
the extension scanner to mark instances as "not affected by this change", they should be added
with care and only if the scanner configuration matches all changes mentioned in the ReST file.
If parts of the ReST file are covered, "PartiallyScanned" has to be added and the ReST file should
mention which parts are scanned and which are not covered. If the scanner does not cover a ReST file
at all, "NotScanned" can be added.

If a ReST file is renamed, the file may be covered in a matcher configuration, so it needs to be
adapted, too. The ReST files are not bound to specific directories in the matcher configuration,
so moving a ReST file to a different location within the Changelog directory needs no adaption.

Extension scanner "PHP" configuration
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The PHP part of the extension scanner is based on the library
`nikic/php-parser <https://github.com/nikic/PHP-Parser>`__. This library creates an
`abstract syntax tree <https://en.wikipedia.org/wiki/Abstract_syntax_tree>`__ from any given
compilable PHP file. It comes with a traverser for recursive iteration over the tree that
implements a visitor pattern, own visitors can be added. A single "matcher" is a visitor added
to the traverser. A default visitor resolves all "shortened" namespaced class usages to their
fully qualified name, which is a great help for our matchers.

This basically means: The whole AST is traversed exactly once for each PHP file and all matchers
are called for every node. They can then decide if they match a configured deprecation or breaking
scenario.

All matchers are covered by unit tests and a fixture that show what exactly the match. The fixture
files are a good source to find out what a matcher can do.

Matchers are systematically named: For method calls, there is a usually a variant for dynamic and
one for static calls. If for instance a static method changed the argument signature by removing
an argument, the according matcher class is :php:`TYPO3\CMS\Install\CodeScanner\Php\MethodArgumentDroppedStaticMatcher`.

Single matcher configuration are pretty obvious, new ones should be added at the end. If adding
matcher configuration it should be checked it is not yet covered by some other matcher.

A matcher configuration can be removed if it creates too many false positives. This is the case
rather seldom, cases where this has been done are "generic" method names that occur often. Examples
are the dynamic methods :php:`->setIcon()`, :php:`->getIcon()` and :php:`->render()`. Decision to
remove a single matcher configuration or to not add one should be done with huge care.

One special issue is if a method is moved from one class to a different one and keeps its name. The
extension scanner (for dynamic methods) will then find a call to the new method as false positive.
In general, this should be avoided if possible: Maybe the method could be given a better name along the way?
