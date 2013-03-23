.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _implementing-combined-conditions:

Implementing combined conditions
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Conditions can be combined using OR and AND. This feature already is
implemented for TypoScript Templates. Here the explanation, how that
was done. For an overview of the resulting possibilities see the
chapter "Conditions" in TSref. It contains short information about the
syntax and an overview of the available conditions.

In the context of TypoScript Templates you can place several
"conditions" in the same (real) condition::

   [browser = msie][browser = opera]
   someTypoScript = 123
   [GLOBAL]

They are evaluated by OR-ing the result of each sub-condition (done in
the class AbstractConditionMatcher (formerly t3lib\_matchCondition)). We
could implement something alike and maybe even better. For instance we could
implement a syntax like this::

   [ CON 1 ] && [ CON 2 ] || [ CON 3 ]

This will be read like "Returns TRUE if condition 1 and condition 2
are TRUE OR if condition 3 is TRUE". In other words we implement the
ability to AND and OR conditions together.

The implementation goes as follows::

      1: class myConditions {
      2:
      3:   /**
      4:    * Splits the input condition line into AND and OR parts
      5:    * which are evaluated separately and logically combined to the final output.
      6:    *
      7:    * @param string $conditionLine The condition line
      8:    * @return boolean value
      9:    */
     10:   public function match($conditionLine) {
     11:     // Getting the value from inside of the wrapping; take away the very outer
     12:     // square brackets of the condition line:
     13:     $insideSqrBrackets = trim(preg_replace('/\]$/', '', substr($conditionLine, 1)));
     14:
     15:     // The "weak" operator, OR, takes precedence:
     16:     $ORparts = preg_split('/\]\s*\|\|\s*\[/', $insideSqrBrackets);
     17:     foreach($ORparts as $andString) {
     18:       $resBool = FALSE;
     19:
     20:       // Splits by the "&&" and operator:
     21:       $ANDparts = preg_split('/\]\s*\&\&\s*\[/', $andString);
     22:       foreach($ANDparts as $condStr) {
     23:         $resBool = $this->evalConditionStr($condStr) ? TRUE : FALSE;
     24:         if (!$resBool) break;
     25:       }
     26:
     27:       if ($resBool) break;
     28:     }
     29:     return $resBool;
     30:   }
     31:
     32:   /**
     33:    * Evaluates the inner part of the conditions.
     34:    *
     35:    * @param string $condStr The text of one single condition
     36:    * @return boolean The return value of the according condition
     37:    */
     38:   public function evalConditionStr($condStr) {
     39:     // Splitting value into a key and value based on the "=" sign
     40:     list($key, $value) = explode('=', $condStr, 2);
     41:
     42:     switch(trim($key)) {
     43:       case 'UserIpRange':
     44:         return GeneralUtility::cmpIP(GeneralUtility::getIndpEnv('REMOTE_ADDR'), trim($value)) ? TRUE : FALSE;
     45:       break;
     46:       case 'Browser':
     47:         return $GLOBALS['CLIENT']['BROWSER'] == trim($value);
     48:       break;
     49:     }
     50:   }
     51: }

With this implementation I can make a condition line like this::

      9:
     10: [UserIpRange = 192.168.*.*] && [Browser = msie]
     11:
     12:   headerImage = fileadmin/img1.jpg
     13:

So if I'm in the right IP range AND have the right browser the value
of "headerImage" will be "fileadmin/img1.jpg"

If we modify the TypoScript as follows, the same condition applies but
if the browser is Firefox then the condition will evaluate to TRUE
regardless of the IP range::

      9:
     10: [UserIpRange = 192.168.*.*] && [Browser = msie] || [Browser = firefox]
     11:
     12:   headerImage = fileadmin/img1.jpg

This is because the conditions are read like the parenthesis levels
show:

**(** "UserIpRange = 192.168.\*.\*" **AND** "Browser = msie" **) OR**
"Browser = firefox"

The order of the "\|\|" and "&&" operators may be a problem now. For
instance::

      9:
     10: [UserIpRange = 192.168.*.*] || [UserIpRange = 212.237.*.*] && [Browser = msie]
     11:
     12:   headerImage = fileadmin/img1.jpg

I would like it to read as "If User IP Range is either #1 or #2
provided that the browser is MSIE in any case!". But right now it will
be TRUE if the User IP range is 192.168.... OR if either the range is
212.... and the browser is MSIE.

Formally, this is what I want:

**(** "UserIpRange = 192.168.\*.\*" **OR** "UserIpRange =
212.237.\*.\*" **) AND** "Browser = msie"

My solution is to implement a second way of OR'ing conditions together
- by simply implying an OR between two "condition sections" if no
operator is there. Thus the line above could be implemented as
follows::

      9:
     10: [UserIpRange = 192.168.*.*][UserIpRange = 212.237.*.*] && [Browser = msie]
     11:
     12:   headerImage = fileadmin/img1.jpg

Line 10 will be understood in this way::

   [UserIpRange = 192.168.*.*](implied OR here!)[UserIpRange = 212.237.*.*] && [Browser = msie]

The function match() of the condition class will have to be modified
as follows::

      1:   /**
      2:    * Splits the input condition line into AND and OR parts
      3:    * which are separately evaluated and logically combined to the final output.
      4:    *
      5:    * @param string $conditionLine The condition line
      6:    * @return boolean value
      7:    */
      8:   public function match($conditionLine) {
      9:     // Getting the value from inside of the wrapping; take away the very outer
     10:     // square brackets of the condition line:
     11:     $insideSqrBrackets = trim(preg_replace('/\]$/', '', substr($conditionLine, 1)));
     12:
     13:     // The "weak" operator, OR, takes precedence:
     14:     $ORparts = preg_split('/\]\s*\|\|\s*\[/', $insideSqrBrackets);
     15:     foreach($ORparts as $andString) {
     16:       $resBool = FALSE;
     17:
     18:       // Splits by the "&&" and operator:
     19:       $ANDparts = preg_split('/\]\s*\&\&\s*\[/', $andString);
     20:       foreach($ANDparts as $subOrStr) {
     21:
     22:         // Split by no operator between ] and [ (sub-OR)
     23:         $subORparts = preg_split('/\]\s*\[/', $subOrStr);
     24:         $resBool = FALSE;
     25:         foreach($subORparts as $condStr) {
     26:           if ($this->evalConditionStr($condStr)) {
     27:             $resBool = TRUE;
     28:             break;
     29:           }
     30:         }
     31:
     32:         if (!$resBool) break;
     33:       }
     34:
     35:       if ($resBool) break;
     36:     }
     37:     return $resBool;
     38:   }

That's it.


.. _example-reference:

Addendum to the reference for our application
"""""""""""""""""""""""""""""""""""""""""""""

Remember in the previous sections? We defined three tables with
properties that could be used in TypoScript in the context of our
case-story application. To that reference we should now add a section
with conditions which defines the following:

**#1: Line syntax:**

A condition is split into smaller parts which are connected using a
logical AND or a logical OR. Each sub-part of the condition line is
separated by "] (Operator) [" where operator can be "&&" (AND) ,
"\|\|" (OR) or nothing at all (also meaning OR "below" AND in order).

The format of the condition line therefore is:

[ COND1 ] \|\| [ COND2 ] && [ COND3 ] [ COND4 ] ....etc

where the operators have precedence as indicated by these illustrative
parenthesis:

[ COND1 ] \|\|  **(** [ COND2 ] &&  **(** [ COND3 ] [ COND4 ]  **) )**

(Notice: Between COND3 and COND4 the blank space implicitly is an OR.)

**#2: Subpart syntax:**

For each subpart (for example "[ COND 1 ]") the content is evaluated
as follows:

[ KEY = VALUE ]

where the key denotes a type of condition from below:

**Key: UserIpRange**

Returns TRUE if the client's remote IP address matches the pattern
given as value.

The value is matched against REMOTE\_ADDR by the function
GeneralUtility::cmpIP() (formerly t3lib\_div::cmpIP()), which you can
consult for details on the syntax.

Example::

   [UserIpRange = 192.168.\*.\*]


**Key: Browser**

Returns TRUE, if the client's browser matches one of the keywords
below.

Values you can use:

**konqu** = Konqueror

**opera** = Opera

**msie** = Microsoft Internet Explorer

**net** = Netscape (or any other)

Values are evaluated against the output of the function
GeneralUtility::clientInfo() (formerly t3lib\_div::clientInfo())
which can be consulted for details on the values for browsers.

**Note**: These values are **examples**, which fit to the code we
have built above. In current TYPO3 versions the available values have
changed!

**For an overview of the values currently possible, always consult
TSref!**

Example::

   [Browser = msie]


