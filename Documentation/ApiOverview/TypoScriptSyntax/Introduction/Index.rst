.. include:: ../../../Includes.txt


.. _typoscript-syntax-introduction:

Introduction
============


.. _typoscript-syntax-about:

About this chapter
------------------

This chapter describes the syntax of TypoScript. It also covers the
nature of TypoScript and what the differences are between the various
contexts in which it can be used (i.e. templates and TSconfig).


.. _typoscript-syntax-what-is-typoscript:

What is TypoScript?
-------------------

People are often confused about what TypoScript (TS) is, where it can
be used and have a tendency to think of it as something complex. This
chapter has been written in the hope of clarifying these issues.

First let's start with a basic truth:

- TypoScript is a *syntax* for defining information in a hierarchical
  structure using simple ASCII text content.

This means that:

- TypoScript itself does not "do" anything - it just contains
  information.

- TypoScript is *only* transformed into function when it is passed to a
  program which is designed to act according to the information in a
  TypoScript information structure.

So strictly speaking TypoScript has no function in itself, only when
used in a certain context. Since the context is almost always to
*configure* something you can often understand TypoScript as
*parameters* (or function arguments) passed to a function which acts
accordingly (e.g. "background\_color = red"). And on the contrary you
will probably never see TypoScript used to store information like a
database of addresses - you would use XML or SQL for that.


.. _typoscript-syntax-php-arrays:

PHP arrays
^^^^^^^^^^

In the scope of its use you can also understand TypoScript as a non-
strict way to enter information into a *multidimensional array* . In
fact when TypoScript is parsed, it is *transformed into a PHP array*
! So when would you define static information in PHP arrays? You would
do that in configuration files - but probably not to build your
address database!

This can be summarized as follows:

- When TypoScript is *parsed* it means that the information is
  transformed into a *PHP array* from where TYPO3 applications can
  access it.

- So the *same* information could in fact be defined in TypoScript *or
  directly* in PHP; but the syntax would be different for the two of
  course.

- TypoScript offers convenient features which is the reason why we don't
  just define the information directly with PHP syntax into arrays.
  These features include a relaxed handling of syntax errors, definition
  of values with less language symbols needed and the ability of using
  an object/property metaphor, etc.


.. _typoscript-syntax-object-paths:

TypoScript syntax, object paths, objects and properties
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

See, that is what this chapter is about - the *syntax* of
TypoScript; the rules you must obey in order to store information in
this structure. Obviously we'll not explain the full syntax here again
but just give an example to convey the idea.

Remember it is about storing information, so think about TypoScript as
*assigning values to variables* : The "variables" are called "object
paths" because TypoScript easily lends itself to the metaphor of
"objects" and "properties". This has some advantages as we shall see
but at the same time TypoScript is designed to allow a very simple and
straight forward assignment of values; simply by using the equal sign
as an operator::

   asdf = qwerty

Now the object path "asdf" contains the value "qwerty".

Another example::

   asdf.zxcvbnm = uiop
   asdf.backgroundColor = blue

Now the object path "asdf.zxcvbnm" contains the value "uiop" and
"asdf.backgroundColor" contains the value "blue". According to *the
syntax* of TypoScript this could also have been written more
comfortably as::

   asdf {
     zxcvbnm = uiop
     backgroundColor = blue
   }

What happened here is that we broke down the full *object path*,
"asdf.zxcvbnm" into its components "asdf" and "zxcvbnm" which are
separated by a period, ".", and then we used the curly brace
operators, { and } , to bind them together again. To describe this
relationship of the components of an *object path* we normally call
"asdf" *the object* and "zxcvbnm" *the property* of that object.

So although the terms *objects* and *properties* normally hint at
some context (semantics) we may also use them purely to describe the
various parts of an object path without considering the context and
meaning. Consider this::

   asdf {
     zxcvbnm = uiop
     backgroundColor = blue
     backgroundColor.transparency = 95%
   }

Here we can say that "zxcvbnm" and "backgroundColor" are *properties*
of (the object) "asdf". Further, "transparency" is a property of (the
object / the property) "backgroundColor" (or "asdf.backgroundColor").


.. _typoscript-syntax-semantics:

Note about perceived semantics
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

You may now think that "backgroundColor = blue" makes more sense than
"zxcvbnm = uiop" but having a look at the **syntax** only it doesn't!
The only reason that "backgroundColor = blue" seems to make sense is
that in the *English language* we understand the words "background
color" and "blue" and automatically imply some meaning. We understand
the **semantics** of it. But to a machine like a computer the word
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


.. _typoscript-syntax-parsed-php-array:

Note about the internal structure when parsed into a PHP array
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Let's take the TypoScript from above as an example::

   asdf {
     zxcvbnm = uiop
     backgroundColor = blue
     backgroundColor.transparency = 95%
   }

When parsed, this information will be stored in a PHP array which
could be defined as follows::

   $TS['asdf.']['zxcvbnm'] = 'uiop';
   $TS['asdf.']['backgroundColor'] = 'blue';
   $TS['asdf.']['backgroundColor.']['transparency'] = '95%';

Or alternatively you could define the information in that PHP array
like this::

   $TS = [
     'asdf.' => [
       'zxcvbnm' => 'uiop',
       'backgroundColor' => 'blue',
       'backgroundColor.' => [
         'transparency' => '95%'
       ]
     ]
   ]

The information inside a PHP array like that one is used by TYPO3 to
apply the configurations, which you have set.


.. _typoscript-syntax-credits:

Credits
-------

This chapter was formerly maintained by Michael Stucki and Francois
Suter. Additions have been made by Sebastian Michaelsen. The updates
for recent versions were done by Christopher Stelmaszyk and Francois
Suter.
