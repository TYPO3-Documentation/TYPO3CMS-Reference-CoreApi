.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _custom-typoscript:

Parsing custom TypoScript
^^^^^^^^^^^^^^^^^^^^^^^^^

Let's imagine that you have created an application in TYPO3, for
example a plug-in. You have defined certain parameters editable
directly in the form fields of the plug-in content element. However
you want advanced users to be able to set up more detailed parameters.
But instead of adding a host of such detailed options to the interface
- which would just clutter it all up - you rather want advanced users
to have a text area field into which they can enter configuration
codes based on a little reference you make for them.

The reference could look like this:


Root level
""""""""""

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         colors

   Data type
         ->COLORS

   Description
         Defining colors for various elements.


.. container:: table-row

   Property
         adminInfo

   Data type
         ->ADMINFO

   Description
         Define administrator contact information for cc-emails


.. container:: table-row

   Property
         headerImage

   Data type
         file-reference

   Description
         A reference to an image file relative to the websites path
         (PATH\_site)


.. ###### END~OF~TABLE ######

[TLO]


->COLORS
""""""""

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         backgroundColor

   Data type
         HTML-color

   Description
         The background color of ...

   Default
         white


.. container:: table-row

   Property
         fontColor

   Data type
         HTML-color

   Description
         The font color of text in ...

   Default
         black


.. container:: table-row

   Property
         popUpColor

   Data type
         HTML-color

   Description
         The shadow color of the pop up ...

   Default
         #333333


.. ###### END~OF~TABLE ######

[colors]


->ADMINFO
"""""""""

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Property
         cc\_email

   Data type
         string

   Description
         The email address that ...


.. container:: table-row

   Property
         cc\_name

   Data type
         string

   Description
         The name of ...


.. container:: table-row

   Property
         cc\_return\_adr

   Data type
         string

   Description
         The return address of ...

   Default
         [servers]


.. container:: table-row

   Property
         html\_emails

   Data type
         boolean

   Description
         If set, emails are sent in HTML.

   Default
         false


.. ###### END~OF~TABLE ######

[adminInfo]

So these are the "objects" and "properties" you have chosen to offer
to your users of the plug-in. This reference defines *what
information makes sense* to put into the TypoScript field
(semantically), because you will program your application to use this
information as needed.


A case story
~~~~~~~~~~~~

Now let's imagine that a user inputs this TypoScript configuration in
whatever medium you have offered (e.g. a textarea field). (In a syntax
highlighted version with line numbers it would look like the listing,
which indicates that there are no *syntax errors* and everything is
fine in that regard.) ::

      0: colors {
      1:   backgroundColor = red
      2:   fontColor = blue
      3: }
      4: adminInfo {
      5:   cc_email = email@email.com
      6:   cc_name = Copy Name
      7: }
      8: showAll = true
      9:
     10: [UserIpRange = 123.456.*.*]
     11:
     12:   headerImage = fileadmin/img1.jpg
     13:
     14: [ELSE]
     15:
     16:   headerImage = fileadmin/img2.jpg
     17:
     18: [GLOBAL]
     19:
     20: // Wonder if this works... :-)
     21: wakeMeUp = 7:00

(Syntax highlighting of TS (and XML and PHP) can be done with the
extension "extdeveval").

In order to parse this TypoScript we can use the following code
provided that the variable $tsString contains the above TypoScript as
its value::

      3: require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('core') . 'Classes/TypoScript/Parser/TypoScriptParser.php');
      4:
      5: $TSparserObject = GeneralUtility::makeInstance('TypoScriptParser');
      6: $TSparserObject->parse($tsString);
      7:
      8: echo '<pre>';
      9: print_r($TSparserObject->setup);
     10: echo '</pre>';

- Line 3: The TypoScript parser class is included (most likely already
  done in both frontend and backend of TYPO3).

- Line 5: Creates an object of the parser class.

- Line 6: Initiates parsing of the TypoScript content of the string
  $tsString.

- Line 8-10: Outputs the parsed result which is located in
  $TSparserObject->setup.

The result of this code being run will be this::

   Array
   (
     [colors.] => Array
     (
       [backgroundColor] => red
       [fontColor] => blue
     )

     [adminInfo.] => Array
     (
       [cc_email] => email@email.com
       [cc_name] => Copy Name
     )

     [showAll] => true
     [headerImage] => fileadmin/img2.jpg
     [wakeMeUp] => 7:00
   )

Now your application could use this information in a manner like this::

   echo '<table bgcolor="'.$TSparserObject->setup['colors.']['backgroundColor'].'">
     <tr>
       <td>
         <font color="'.$TSparserObject->setup['colors.']['fontColor'].'">HELLO WORLD!</font>
       </td>
     </tr>
   </table>';

As you can see some of the TypoScript properties (or *object paths*)
which are found in the reference tables above are implemented here.
There is not much mystique about this and in fact this is how all
TypoScript is used in its respective contexts; **TypoScript contains
simply configuration values that make our underlying PHP code act
accordingly - parameters, function arguments, as you please;
TypoScript is an API to instruct an underlying system.**

This also means that now we can begin to meaningfully talk about
invalid information in TypoScript - it is obvious that two properties
are entered in TypoScript but do not make any sense: "showAll" and
"wakeMeUp". Both properties are not defined in the reference tables
and therefore they should neither be implemented in the PHP code of
course. However no errors are issued by the parser since the syntax
used to define those properties is still right. The only problem is
that they are irrelevant; it is like defining a variable in PHP and
then never using it! A waste of time - and probably confusing later.

As noted there exists only the input mode of t3editor to do
"semantics-checking". However, this only works during input, not at a
later time. It might be interesting and very helpful some day if we
had that as well so we could also be warned if we use non-existing
properties (which could just be spelling errors).

