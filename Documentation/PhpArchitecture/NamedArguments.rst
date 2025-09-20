..  include:: /Includes.rst.txt
..  index:: pair: Coding guidelines; Named Arguments
..  _cgl-named-arguments:

===============
Named arguments
===============

`Named arguments <https://www.php.net/manual/en/functions.arguments.php#functions.named-arguments>`__,
also known as “named parameters”, were `introduced in PHP 8 <https://wiki.php.net/rfc/named_params>`__,
offering a new approach to passing arguments to functions. Instead of relying on
the position of parameters, developers can now specify arguments based on their
corresponding parameter names:

..  code-block:: php
    :caption: Named arguments example

    <?php
    function createUser($username, $email)
    {
        // code to create user
    }
    createUser(email: 'john.doe@example.com', username: 'john');

This document discusses the use of named arguments within the TYPO3 Core ecosystem,
outlining best practices for TYPO3 extension and Core developers regarding the
adoption and avoidance of this language feature.


Named arguments in public APIs
==============================

The key consideration when using this feature is outlined in the
`PHP documentation <https://php.watch/versions/8.0/named-parameters>`__:

    With named parameters, the name of the function/method parameters become part of
    the public API, and changing the parameters of a function will be a semantic
    versioning breaking-change. This is an undesired effect of named parameters feature.


Utilizing named arguments in extensions
=======================================

While the TYPO3 Core cannot directly enforce or prohibit the use of named
arguments within extensions, it suggests certain best practices to ensure
forward compatibility:

*   Named arguments should only be used for initializing value objects
    using :ref:`PCPP (public constructor property promotion) <cgl-named-arguments-pcpp-value-objects>`.

*   Avoid named arguments when calling TYPO3 Core API methods unless dealing
    with PCPP-based value objects. The TYPO3 Core does not treat variable names as
    part of the API and may change them without considering it a breaking change.


TYPO3 Core development
======================

The decision on when to employ named parameters within the TYPO3 Core is carefully
deliberated and codified into distinct sections, each subject to scrutiny within
the Continuous Integration (CI) pipeline to ensure consistency and integrity over time.

It’s important to note that the TYPO3 Core Team will not accept patches that aim
to unilaterally transition the codebase from positional arguments to named arguments
or vice versa without clear further benefits.

..  _cgl-named-arguments-pcpp-value-objects:

Leveraging Named Arguments in PCPP Value Objects
------------------------------------------------

Advancements in the TYPO3 Core codebase emphasize the separation of
functionality and state, leading to the broad utilization of value objects.
Consider the following example:

..  code-block:: php
    :caption: Value object using public constructor property promotion

    final readonly class Label implements \JsonSerializable
    {
        public function __construct(
            public string $label,
            public string $color = '#ff8700',
            public int $priority = 0,
        ) {}

        public function jsonSerialize(): array
        {
            return get_object_vars($this);
        }
    }

Using public constructor property promotions (PCPP) facilitates object
initialization, representing one of the primary use cases for named arguments
envisioned by PHP developers:

..  code-block:: php
    :caption: Instantiate a PCPP value object using named arguments

    $label = new Label(
        label: $myLabel,
        color: $myColor,
        priority: -1,
    );

Objects with such class signatures MUST be instantiated using named arguments to
maintain API consistency. Standardizing named argument usage allows the TYPO3
Core to introduce deprecations for argument removals seamlessly.

Invoking 2nd-party (non-Core library) dependency methods
--------------------------------------------------------

The TYPO3 Core refrains from employing named arguments when calling library
code ("2nd-party") from dependent packages unless the library explicitly mandates such usage
and defines its variable names as part of the API, a practice seldom observed
currently.

As package consumer, the TYPO3 Core must assume that packages don’t treat their
variable names as API, they may change anytime. If TYPO3 Core would use named
arguments for library calls, this may trigger regressions: Suppose a patch level
release of a library changes a variable name of some method that we call using
named arguments. This would immediately break when TYPO3 projects upgrade to
this patch level release due to the power of semantic versioning. TYPO3 Core must
avoid this scenario.

Invoking Core API
-----------------

Within the TYPO3 Core, named arguments are not used when invoking its own methods.
There are exceptions in specific scenarios as outlined below, however these are
the reasons for not using named arguments:

*   TYPO3 Core tries to be as consistent as possible

*   Setting a good example for extension authors

*   Avoiding complications and side effects during refactoring

*   Addressing legacy code within the TYPO3 Core containing methods with less-desirable
    variable names, aiming for gradual improvement without disruptions

*   Preventing issues with inheritance, especially in situations like this:

    ..  code-block:: php
        :caption: PHP error using named arguments and inheritance

        interface I {
            public function test($foo, $bar);
        }

        class C implements I {
            public function test($a, $b) {}
        }

        $obj = new C();

        // Pass params according to I::test() contract
        $obj->test(foo: "foo", bar: "bar"); // ERROR!

Utilizing named arguments in PHPUnit test data providers
--------------------------------------------------------

The use of named arguments in PHPUnit test data providers is permitted and
encouraged, particularly when enhancing readability. Take, for example, this
instance where PHPUnit utilizes the array keys :php:`languageKey` and
:php:`expectedLabels` as named arguments in the test:

..  code-block:: php
    :caption: PHPUnit data provider using named arguments

    final class XliffLoaderTest extends UnitTestCase
    {
        public static function canLoadXliffDataProvider(): \Generator
        {
            yield 'Can handle default' => [
                'languageKey' => 'default',
                'expectedLabels' => [
                    'label1' => 'This is label #1',
                    'label2' => 'This is label #2',
                    'label3' => 'This is label #3',
                ],
            ];
            yield 'Can handle translation' => [
                'languageKey' => 'fr',
                'expectedLabels' => [
                    'label1' => 'Ceci est le libellé no. 1',
                    'label2' => 'Ceci est le libellé no. 2',
                    'label3' => 'Ceci est le libellé no. 3',
                ],
            ];
        }

        #[DataProvider('canLoadXliffDataProvider')]
        #[Test]
        public function canLoadXliff(string $languageKey, array $expectedLabels): void
        {
            // Test implementation
        }
    }

Leveraging named arguments when invoking PHP functions
------------------------------------------------------

TYPO3 Core may leverage named arguments when calling PHP functions, provided it
enhances readability and simplifies the invocation. It is allowed for functions
with more than three arguments. If named arguments are used, all arguments must
be named, mixtures are not allowed.

Let’s do this by example. Function :php:`json_decode()` has this signature:

..  code-block:: php
    :caption: json_decode() function signature

    json_decode(
        string $json,
        ?bool $associative = null,
        int $depth = 512,
        int $flags = 0
    ): mixed

In many cases, the arguments :php:`$associative` and :php:`$depth` suffice with their
default values, while :php:`$flags` typically requires :php:`JSON_THROW_ON_ERROR`.
Using named arguments in this scenario, bypassing the default values, results in a
clearer and more readable solution:

..  code-block:: php
    :caption: Calling json_decode() using named arguments

    json_decode(json: $myJsonString, flags: JSON_THROW_ON_ERROR);

Another instance arises with complex functions like :php:`preg_replace()`, where
developers often overlook argument positions and names:

..  code-block:: php
    :caption: Calling preg_replace() using named arguments

    $configurationFileContent = preg_replace(
        pattern: sprintf('/%s/', implode('\s*', array_map(
            static fn($s) => preg_quote($s, '/'),
            [
                'RewriteCond %{REQUEST_FILENAME} !-d',
                'RewriteCond %{REQUEST_FILENAME} !-l',
                'RewriteRule ^typo3/(.*)$ %{ENV:CWD}index.php [QSA,L]',
            ]
        ))),
        replacement: 'RewriteRule ^typo3/(.*)$ %{ENV:CWD}index.php [QSA,L]',
        subject: $configurationFileContent,
        count: $count
    );
