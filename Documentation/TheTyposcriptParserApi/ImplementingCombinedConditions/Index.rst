

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Implementing combined conditions
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Conditions can be combined using OR and AND. This feature already is
implemented for TypoScript Templates. Here the explanation, how that
was done. For an overview of the resulting possibilities see the
chapter "Conditions" in TSref. It contains short information about the
syntax and an overview of the available conditions.

In the context of TypoScript Templates you can place several
"conditions" in the same (real) condition:

::

   [browser = msie][browser = opera]
   someTypoScript = 123
   [GLOBAL]

They are evaluated by OR-ing the result of each sub-condition (done in
the class t3lib\_matchCondition). We could implement something alike
and maybe even better. For instance we could implement a syntax like
this:

::

   [ CON 1 ] && [ CON 2 ] || [ CON 3 ]

This will be read like "Returns TRUE if condition 1 and condition 2
are TRUE OR if condition 3 is TRUE". In other words we implement the
ability to AND and OR conditions together.

The implementation goes as follows:

::

      1: class myConditions {
      2:   
      3:   /**
      4:    * Splits the input condition line into AND and OR parts 
      5:    * which are separately evaluated and logically combined to the final output.
      6:    */
      7:   function match($conditionLine) {
      8:       // Getting the value from inside of the wrapping 
      9:       // square brackets of the condition line:
     10:     $insideSqrBrackets = trim(ereg_replace('\]$', '', substr($conditionLine, 1)));
     11: 
     12:       // The "weak" operator, OR, takes precedence:
     13:     $ORparts = split('\][[:space:]]*\|\|[[:space:]]*\[', $insideSqrBrackets);
     14:     foreach($ORparts as $andString) {
     15:       $resBool = FALSE;
     16: 
     17:         // Splits by the "&&" and operator:
     18:       $ANDparts = split('\][[:space:]]*\&\&[[:space:]]*\[', $andString);
     19:       foreach($ANDparts as $condStr) {
     20:         $resBool = $this->evalConditionStr($condStr) ? TRUE : FALSE;
     21:         if (!$resBool) break;
     22:       }
     23: 
     24:       if ($resBool) break;
     25:     }
     26:     return $resBool;
     27:   }
     28: 
     29:   /**
     30:    * Evaluates the inner part of the conditions.
     31:    */
     32:   function evalConditionStr($condStr) {
     33:       // Splitting value into a key and value based on the "=" sign
     34:     list($key, $value) = explode('=', $condStr, 2);
     35: 
     36:     switch(trim($key)) {
     37:       case 'UserIpRange':
     38:         return t3lib_div::cmpIP(t3lib_div::getIndpEnv('REMOTE_ADDR'), trim($value)) ? TRUE : FALSE;
     39:       break;
     40:       case 'Browser':
     41:         return $GLOBALS['CLIENT']['BROWSER']==trim($value);
     42:       break;
     43:     }
     44:   }
     45: }

With this implementation I can make a condition line like this:

::

      9: 
     10: [UserIpRange = 192.168.*.*] && [Browser = msie]
     11: 
     12:   headerImage = fileadmin/img1.jpg
     13: 

So if I'm in the right IP range AND have the right browser the value
of "headerImage" will be "fileadmin/img1.jpg"

If we modify the TypoScript as follows, the same condition applies but
if the browser is Firefox then the condition will evaluate to TRUE
regardless of the IP range:

::

      9: 
     10: [UserIpRange = 192.168.*.*] && [Browser = msie] || [Browser = firefox]
     11: 
     12:   headerImage = fileadmin/img1.jpg

This is because the conditions are read like the parenthesis levels
show:

**(** "UserIpRange = 192.168.\*.\*"  **AND** "Browser = msie" **) OR**
"Browser = firefox"

The order of the "\|\|" and "&&" operators may be a problem now. For
instance:

::

      9: 
     10: [UserIpRange = 192.168.*.*] || [UserIpRange = 212.237.*.*] && [Browser = msie]
     11: 
     12:   headerImage = fileadmin/img1.jpg

I would like it to read as "If User IP Range is either #1 or #2
provided that the browser is MSIE in any case!". But right now it will
be TRUE if the User IP range is 192.168.... OR if either the range is
212.... and the browser is MSIE.

Formally, this is what I want:

**(** "UserIpRange = 192.168.\*.\*"  **OR** "UserIpRange =
212.237.\*.\*" **) AND** "Browser = msie"

My solution is to implement a second way of OR'ing conditions together
- by simply implying an OR between two "condition sections" if no
operator is there. Thus the line above could be implemented as
follows:

::

      9: 
     10: [UserIpRange = 192.168.*.*][UserIpRange = 212.237.*.*] && [Browser = msie]
     11: 
     12:   headerImage = fileadmin/img1.jpg

Line 10 will be understood in this way:

::

   [UserIpRange = 192.168.*.*](implied OR here!)[UserIpRange = 212.237.*.*] && [Browser = msie]

The function match() of the condition class will have to be modified
as follows:

::

      1:   /**
      2:    * Splits the input condition line into AND and OR parts 
      3:    * which are separately evaluated and logically combined to the final output.
      4:    */
      5:   function match($conditionLine) {
      6:       // Getting the value from inside of the wrapping 
      7:       // square brackets of the condition line:
      8:     $insideSqrBrackets = trim(ereg_replace('\]$', '', substr($conditionLine, 1)));
      9: 
     10:       // The "weak" operator, OR, takes precedence:
     11:     $ORparts = split('\][[:space:]]*\|\|[[:space:]]*\[', $insideSqrBrackets);
     12:     foreach($ORparts as $andString) {
     13:       $resBool = FALSE;
     14: 
     15:         // Splits by the "&&" and operator:
     16:       $ANDparts = split('\][[:space:]]*\&\&[[:space:]]*\[', $andString);
     17:       foreach($ANDparts as $subOrStr) {
     18: 
     19:           // Split by no operator between ] and [ (sub-OR)
     20:         $subORparts = split('\][[:space:]]*\[', $subOrStr);
     21:         $resBool = FALSE;
     22:         foreach($subORparts as $condStr) {
     23:           if ($this->evalConditionStr($condStr)) {
     24:             $resBool = TRUE;
     25:             break;
     26:           }
     27:         }
     28: 
     29:         if (!$resBool) break;
     30:       }
     31:       
     32:       if ($resBool) break;
     33:     }
     34:     return $resBool;
     35:   }

That's it.


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

where the key denotes a type of condition from the table below:

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Key
         Key
   
   Description
         Description
   
   Example
         Example


.. container:: table-row

   Key
         UserIpRange
   
   Description
         Returns TRUE if the client's remote IP address matches the pattern
         given as value.
         
         The value is matched against REMOTE\_ADDR by the function
         t3lib\_div::cmpIP(), which you can consult for details on the syntax.
   
   Example
         [UserIpRange = 192.168.\*.\*]


.. container:: table-row

   Key
         Browser
   
   Description
         Returns TRUE, if the client's browser matches one of the keywords
         below.
         
         Values you can use:
         
         **konqu** = Konqueror
         
         **opera** = Opera
         
         **msie** = Microsoft Internet Explorer
         
         **net** = Netscape (or any other)
         
         Values are evaluated against the output of the function
         t3lib\_div::clientInfo() which can be consulted for details on the
         values for browsers.
         
         **Note** : These values are  **examples** , which fit to the code we
         have built above. In current TYPO3 versions the available values have
         changed!
         
         **For an overview of the values currently possible, always consult
         TSref!**
   
   Example
         [Browser = msie]


.. ###### END~OF~TABLE ######

