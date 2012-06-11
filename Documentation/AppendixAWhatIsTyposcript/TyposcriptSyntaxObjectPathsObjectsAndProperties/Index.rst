

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


TypoScript syntax, object paths, objects and properties
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

See, that is what this document is about - the  *syntax* of
TypoScript; the rules you must obey in order to store information in
this structure. Obviously I'll not explain the full syntax here again
but just give an example to convey the idea.

Remember it is about storing information, so think about TypoScript as
*assigning values to variables* : The "variables" are called "object
paths" because TypoScript easily lends itself to the metaphor of
"objects" and "properties". This has some advantages as we shall see
but at the same time TypoScript is designed to allow a very simple and
straight forward assignment of values; simply by using the equal sign
as an operator:

::

   asdf = qwerty

Now the object path "asdf" contains the value "qwerty".

Another example:

::

   asdf.zxcvbnm = uiop
   asdf.backgroundColor = blue

Now the object path "asdf.zxcvbnm" contains the value "uiop" and
"asdf.backgroundColor" contains the value "blue". According to  *the
syntax* of TypoScript this could also have been written more
comfortably as:

::

   asdf {
     zxcvbnm = uiop
     backgroundColor = blue
   }

What happened here is that we broke down the full  *object path* ,
"asdf.zxcvbnm" into its components "asdf" and "zxcvbnm" which are
separated by a period, ".", and then we used the curly brace
operators, { and } , to bind them together again. To describe this
relationship of the components of an  *object path* we normally call
"asdf "  *the object* and " zxcvbnm "  *the property* of that object.

So although the terms  *objects* and  *properties* normally hint at
some context (semantics) we may also use them purely to describe the
various parts of an object path without considering the context and
meaning. Consider this:

::

   asdf {
     zxcvbnm = uiop
     backgroundColor = blue
     backgroundColor.transparency = 95%
   }

Here we can say that "zxcvbnm" and "backgroundColor" are  *properties*
of (the object) "asdf". Further, "transparency" is a property of (the
object / the property) "backgroundColor" (or "asdf.backgroundColor").


Note about perceived semantics
""""""""""""""""""""""""""""""

You may now think that "backgroundColor = blue" makes more sense than
"zxcvbnm = uiop" but having a look at the  **syntax** only it doesn't!
The only reason that "backgroundColor = blue" seems to make sense is
that in the  *English language* we understand the words "background
color" and "blue" and automatically imply some meaning. We understand
the  **semantics** of it. But to a machine like a computer the word
"backgroundColor" makes just as little sense as "zxcvbnm" unless it
has been programmed to understand either one, e.g. to take its value
as the background color for something. In fact "uiop" could be an
alias for blue color values and "zxcvbnm" could be programmed as the
property setting the background color of something.

This just serves to point one thing out: Although most programming
languages and also TypoScript use function, method, keyword and
property names which humans can often deduct some meaning from, it
ultimately is the programming reference, DTD or XML-Schema which
defines the meaning.


Note about the internal structure when parsed into a PHP array
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

As stated in the previous chapter TypoScript can be understood as a
lightweight way to enter information into a multidimensional PHP
array. Let’s take the TypoScript from above as an example:

::

   asdf {
     zxcvbnm = uiop
     backgroundColor = blue
     backgroundColor.transparency = 95%
   }

When parsed, this information will be stored in a PHP array which
could be defined as follows:

::

   $TS['asdf.']['zxcvbnm'] = 'uiop';
   $TS['asdf.']['backgroundColor'] = 'blue';
   $TS['asdf.']['backgroundColor.']['transparency'] = '95%';

Or alternatively you could define the information in that PHP array
like this:

::

   $TS = array(
     'asdf.' => array(
       'zxcvbnm' => 'uiop',
       'backgroundColor' => 'blue',
       'backgroundColor.' => array (
         'transparency' => '95%'
       )
     )
   )

The information inside a PHP array like that one is used by TYPO3 to
apply the configurations, which you have set.

