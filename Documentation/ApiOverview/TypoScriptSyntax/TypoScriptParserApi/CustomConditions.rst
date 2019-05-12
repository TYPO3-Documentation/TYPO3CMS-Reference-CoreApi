.. include:: ../../../Includes.txt


.. _typoscript-syntax-implementing-custom-conditions:

==============================
Implementing Custom Conditions
==============================

Now we know how to parse TypoScript and the only thing we still want
to do is to implement support for custom conditions. As stated in a few
places *the evaluation* of a condition is external to TypoScript and
all you need to do in order to have an external process deal with
conditions is to pass an object as the second parameter to the parse-
function. This is done in the code listing below:

.. code-block:: php

    class myConditions {
        /**
        * Evaluates, if the condition line was "[TYPO3 IS GREAT]".
        *
        * @param string $conditionLine The condition line
        * @return boolean value
        */
        public function match($conditionLine) {
            if ($conditionLine === '[TYPO3 IS GREAT]') {
                return true;
            }
        }
    }
    $matchObj = GeneralUtility::makeInstance(\myConditions::class);

    $TSparserObject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser::class);
    $TSparserObject->parse($tsString, $matchObj);

    debug($TSparserObject->setup);

In this example, we define a very simple class with a :php:`match()` function
inside. This :php:`match()` function must exist and take a string as its
argument. It is expected to return a boolean value. This
function should be programmed to evaluate the condition line according
to your specifications. Currently, if a condition line contains the
value "[TYPO3 IS GREAT]" then the condition will evaluate to true and
the subsequent TypoScript will be parsed.

To enable this condition, we simply create an instance of our class
and pass it to the TypoScript parser upon callings the :php:`parse()`
method.

Let's test the custom condition class from the code listing
above. This is done by parsing this TypoScript code:

.. code-block:: typoscript

   someOtherTS = 123

   [TYPO3 IS GREAT]

   message = Yes
   someOtherTS = 987

   [ELSE]

   message = No

   [GLOBAL]

   someTotallyOtherTS = 456

With this listing we would expect to get the object path "message" set
to "Yes" since the condition line "[TYPO3 IS GREAT]" matches the
criteria for what will return true. Let's try:

.. figure:: ../Images/ParserAPIConditionDebug1.png
   :alt: Debug output of our custom condition 1.

According to this output it worked!

Let's try to alter line 2 to this:

.. code-block:: typoscript

    [TYPO3 IS great]

The parsed result is now:

.. figure:: ../Images/ParserAPIConditionDebug2.png
   :alt: Debug output of our custom condition 2.

As you can see the value of "message" is now "No" since the condition
returned FALSE. The string "[TYPO3 IS great]" is obviously *not* the
same as "[TYPO3 IS GREAT]"! The value of "someOtherTS" was also
changed to "123" which was the value set before the condition and
since the condition was not TRUE the overriding of that former value
did not happen like in the first case.
