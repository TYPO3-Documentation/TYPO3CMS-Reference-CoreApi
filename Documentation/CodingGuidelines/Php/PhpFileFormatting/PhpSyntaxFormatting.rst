.. include:: ../../../Includes.txt


.. _cgl-php-syntax-formatting:

PHP syntax formatting
^^^^^^^^^^^^^^^^^^^^^


Identifiers
"""""""""""

All identifiers must use camelCase and start with a lowercase letter.
Underscore characters are not allowed. Hungarian notation is not
encouraged. Abbreviations should be avoided. Examples of good
identifiers::

   $goodName
   $anotherGoodName

Examples of bad identifiers::

   $BAD_name
   $unreasonablyLongNamesAreBadToo
   $noAbbrAlwd

The lower camel case rule also applies to acronyms. Thus::

   $someNiceHtmlCode

is correct, whereas ::

   $someNiceHTMLCode

is not.

In particular the abbreviations "FE" and "BE" should be avoided and
the full "Frontend" and "Backend" words used instead.

Identifier names must be descriptive. However it is allowed to use
traditional integer variables like :code:`$i`, :code:`$j`, :code:`$k` in
for loops. If such variables are used, their meaning must be absolutely
clear from the context where they are used.

The same rules apply to functions and class methods. In contrast to
class names, function and method names should not only use nouns, but
also verbs. Examples::

   protected function getFeedbackForm()
   public function processSubmission()

Class constants should be clear about what they define. Correct::

   const USERLEVEL_MEMBER = 1;

Incorrect::

   const UL_MEMBER = 1;

Variables on the global scope may use uppercase and underscore
characters.

Examples::

   $GLOBALS['TYPO3_CONF_VARS']
   $GLOBALS['TYPO3_DB']


Comments
""""""""

Comments in the code are highly welcome and recommended. Inline
comments must precede the commented line and be indented with
the same number of spaces as the commented line.
Example::

   protected function processSubmission()
   {
       // Check if user is logged in
       if ($GLOBALS['TSFE']->fe_user->user['uid']) {
           …
       }
   }

Comments must start with ":code:`//`". Starting comments with
":code:`#`" is not allowed.

Class constants and variable comments should follow PHP doc style and
precede the variable. The variable type must be specified for
non–trivial types and is optional for trivial types. Example::

      /** Number of images submitted by user */
      protected $numberOfImages;

      /**
       * Local instance of the ContentObjectRenderer class
       *
       * @var ContentObjectRenderer
       */
      protected $localCobj;

Single line comments are allowed when there is no type declaration for
the class variable or constant.

If a variable can hold values of different types, use :code:`mixed` as
type.


Debug output
""""""""""""

During development it is allowed to use :code:`debug()` or
:code:`GeneralUtility::debug()` function calls to produce debug output.
However all debug statements must be removed (not only commented!)
before pushing the code to the Git repository. Only very exceptionally
is it allowed to even *think* of leaving a debug statement, if it is
definitely a major help when developing user code for the TYPO3 Core.


Curly braces
""""""""""""

Usage of opening and closing curly braces is mandatory in all cases
where they can be used according to PHP syntax (except
:code:`case` statements).

The opening curly brace is always on the same line as the preceding
construction. There must be one space (not a tab!) before the opening
brace. An exception are classes and functions: Here the opening curly
brace is on a new line with the same indentation as the line with class
or function name. The opening brace is always followed by a new line.

The closing curly brace must start on a new line and be indented to
the same level as the construct with the opening brace. Example::

   protected function getForm()
   {
       if ($this->extendedForm) {
           // generate extended form here
       } else {
           // generate simple form here
       }
   }

The following is not allowed::

   protected function getForm() {
       if ($this->extendedForm) { // generate extended form here
       } else {
           // generate simple form here
       }
   }


Conditions
""""""""""

Conditions consist of :code:`if`, :code:`elseif` and :code:`else`
keywords. TYPO3 code must not use the :code:`else if` construct.

The following is the correct layout for conditions::

   if ($this->processSubmission) {
       // Process submission here
   } elseif ($this->internalError) {
       // Handle internal error
   } else {
       // Something else here
   }

Here is an example of the incorrect layout::

   if ($this->processSubmission) {
       // Process submission here
   }
   elseif ($this->internalError) {
       // Handle internal error
   } else // Something else here

It is recommended to create conditions so that the shortest block of
code goes first. For example::

   if (!$this->processSubmission) {
       // Generate error message, 2 lines
   } else {
       // Process submission, 30 lines
   }

If the condition is long, it must be split into several lines.
The logical operators must be put in front of the
next condition and be indented to the same level as the first condition.
The closing round and opening curly bracket after the last condition
should be on a new line, indented to the same level as the :code:`if`::

   if ($this->getSomeCondition($this->getSomeVariable())
       && $this->getAnotherCondition()
   ) {
       // Code follows here
   }

The ternary conditional operator :code:`? :` must be used only, if it
has exactly two outcomes. Example::

   $result = ($useComma ? ',' : '.');

Wrong usage of the ternary conditional operator::

   $result = ($useComma ? ',' : $useDot ? '.' : ';');

Assignment in conditions should be avoided. However if it makes sense
to do an assignment in a condition, it should be surrounded by the
extra pair of brackets. Example::

   if (($fields = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
       // Do something
   }

The following is allowed, but not recommended::

   if (false !== ($fields = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
       // Do something
   }

The following is not allowed (missing the extra pair of brackets)::

   while ($fields = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
       // Do something
   }


Switch
""""""

:code:`case` statements are indented with one additional indent (four
spaces) inside the :code:`switch` statement. The code inside the
:code:`case` statements is further indented with an additional indent.
The :code:`break` statement is aligned with the code. Only one
:code:`break` statement is allowed per :code:`case`.

The :code:`default` statement must be the last in the :code:`switch`
and must not have a :code:`break` statement.

If one :code:`case` block has to pass control into another :code:`case`
block without having a :code:`break`, there must be a comment about it
in the code.

Examples::

   switch ($useType) {
       case 'extended':
           $content .= $this->extendedUse();
           // Fall through
       case 'basic':
           $content .= $this->basicUse();
           break;
       default:
           $content .= $this->errorUse();
   }


Loops
"""""

The following loops can be used:

- do

- while

- for

- foreach

The use of :code:`each` is not allowed in loops.

:code:`for` loops must contain only variables inside (no function
calls). The following is correct::

   $size = count($dataArray);
   for ($element = 0; $element < $size; $element++) {
       // Process element here
   }

The following is not allowed::

   for ($element = 0; $element < count($dataArray); $element++) {
       // Process element here
   }

:code:`do` and :code:`while` loops must use extra brackets, if an
assignment happens in the loop::

   while (($fields = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))) {
       // Do something
   }

There's a special case for :code:`foreach` loops when the value is not
used inside the loop. In this case the dummy variable :code:`$_`
(underscore) is used::

   foreach ($GLOBALS['TCA'] as $table => $_) {
       // Do something with $table
   }

This is done for performance reasons, as it is faster than calling
:code:`array_keys()` and looping on its result.


Strings
"""""""

All strings must use single quotes. Double quotes are allowed only to
create the new line character (:code:`"\n"`).

String concatenation operators must be surrounded by spaces. Example:

.. code-block:: php

    $content = 'Hello ' . 'world!';

However the space after the concatenation operator must not be present,
if the operator is the last construction on the line. See the section
about white spaces for more information.

Variables must not be embedded into strings. Correct:

.. code-block:: php

    $content = 'Hello ' . $userName;

Incorrect:

.. code-block:: php

    $content = "Hello $userName";

Multiline string concatenations are allowed. The line concatenation
operator must be at the beginning of the line. Lines starting from the
second must be indented relatively to the first line. It is recommended
to indent lines one level from the start of the string on the first
level.

.. note::

   The old rule allowed the operator only at the end. Both are still
   valid. Please do no "mass-change" across the core. Use the new rule for
   future changes or patches currently under review but do **not** block reviews
   because of the legacy concatenation. If you change a line/method anyway,
   you can of course adapt CGL-changes as well (as long as it's no
   "mass-change").

.. code-block:: php

    $content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. '
                    . 'Donec varius libero non nisi. Proin eros.';


Booleans
""""""""

Booleans must use the language constructs of PHP and not explicit
integer values like :code:`0` or :code:`1`. Furthermore they should be
written in lowercase, i.e. :code:`true` and :code:`false`.


NULL
""""

Similarly this special value is written in lowercase, i.e.
:code:`null`.


Arrays
""""""

Array declarations use the short array syntax :code:`[]`, instead of the
":code:`array`" keyword. Thus::

   $a = [];

Array components are declared each on a separate line. Such
lines are indented with four more spaces than the start of the
declaration. The closing square bracket is on the same indentation level as
the variable. Every line containing an array item ends with a comma.
This may be omitted if there are no further elements, at the
developer's choice. Example::

   $thisIsAnArray = [
       'foo' => 'bar',
       'baz' => [
           0 => 1
       ]
   ];

Nested arrays follow the same pattern. This formatting applies even to
very small and simple array declarations, e.g. ::

   $a = [
       0 => 'b',
   ];


PHP features
""""""""""""

The use of the newest PHP features is strongly recommended for
extensions and mandatory for the TYPO3 core.

Class functions must have access type specifiers: :code:`public`,
:code:`protected` or :code:`private`. Notice that :code:`private` may
prevent XCLASSing of the class. Therefore :code:`private` can be used
only if it is absolutely necessary.

Class variables must use access specifiers instead of the :code:`var`
keyword.

Type hinting must be used when the function expects an :code:`array` or
an :code:`instance` of a certain class. Example::

      protected function executeAction(MyAction &$action, array $extraParameters)
      {
          // Do something
      }

Static functions must use the :code:`static` keyword. This keyword must
be after the visibility declaration in the function definition::

      public static function executeAction(MyAction &$action, array $extraParameters)
      {
          // Do something
      }

The :code:`abstract` keyword also must be after the visibility declaration in the
function declaration::

      protected abstract function render();



Global variables
""""""""""""""""

Use of :code:`global` is not recommended. Always use
:code:`$GLOBALS['variable']`.


Functions
"""""""""

All **newly introduced** PHP functions must be as strongly typed as possible.
That means one must use the possibilities of PHP 7.0 as much as possible to declare and enforce
strict data types.

i.e.: Every function parameter should be type-hinted. If a function returns a value, a return type-hint must be used.
All data types must be documented in the phpDoc block of the function.

If a function is declared to return a value, all code paths must *always* return a value. The following is *not allowed*::

   /**
    * @param bool $enabled
    * @return string
    */
   function extendedUse(bool $enabled) : string
   {
       if ($enabled) {
           return 'Extended use';
       }
   }

The following is the correct behavior::

   /**
    * @param bool $enabled
    * @return string
    */
   function extendedUse(bool $enabled) : string
   {
       $content = '';
       if ($enabled) {
           $content = 'Extended use';
       }
       return $content;
   }

In general there should be a single :code:`return` statement in the
function (see the preceding example). However a function can return
during parameter validation (guards) before it starts its main logic. Example::

   /**
    * @param bool $enabled
    * @param MyUseParameters $useParameters
    * @return string
    */
   function extendedUse(bool $enabled, MyUseParameters $useParameters) : string
   {
       // Validation
       if (count($useParameters->urlParts) < 5) {
           return 'Parameter validation failed';
       }

       // Main functionality
       $content = '';
       if ($enabled) {
           $content = 'Extended use';
       } else {
           $content = 'Only basic use is available to you!';
       }
       return $content;
   }

Functions should not be long. "Long" is not defined in terms of lines.
General rule is that function should fit into :sup:`2` / :sub:`3` of
the screen. This rule allows small changes in the function without
splitting the function further. Consider refactoring long functions
into more classes or methods.
