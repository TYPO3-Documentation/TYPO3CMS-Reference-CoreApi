.. include:: Images.txt

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


Which classes?
^^^^^^^^^^^^^^

Most code in TYPO3 resides in classes and therefore anything in the
system can be extended. So you should rather say to yourself: In which
script (and thereby which class) is it that I'm going to extend/change
something. When you know which script, you simply open it, look inside
and somewhere you'll find the lines of code which are responsible for
the inclusion of the extension, typically in the bottom of the script.

The exceptions to this rule is classes like "t3lib\_div",
"t3lib\_extMgm" or "t3lib\_BEfunc". These classes contain methods
which are designed to be call non-instantiated, like
"t3lib\_div::fixed\_lgd\_cs()". Whether a class works on this basis is
normally noted in the header of the class file. When methods in a
class is called non-instantiated there is no way you can extend that
method/class.


Example - Adding a small feature in the interface
"""""""""""""""""""""""""""""""""""""""""""""""""

Say you wish to add a little section with help text in the bottom of
the "New" dialog:

|img-16| So this is what you do:

#. Find out that the script in question is "typo3/db\_new.php" (right-
   click frame, select "Properties" and look at URL...:-)

#. Then examine the scripts for its classes and methods. In this case
   you'll find two classes in the file; "localPageTree" (extends
   t3lib\_pageTree) and "SC\_db\_new". The class "SC\_db\_new" is the so
   called "Script Class" - this will hold the code specifically for this
   script.You also find that the only code executed in the global scope
   is this:

   ::

         $SOBE = t3lib_div::makeInstance('SC_db_new');
         $SOBE->init();
         $SOBE->main();
         $SOBE->printContent();

#. When you examine the SC\_db\_new class you find that the main() method
   is the one you would like to extend.

#. Finally you find that immediately after the definition of the two
   classes there is three lines of code which will provide you with the
   final piece of knowledge you need:

   ::

      // Include extension?
      if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['typo3/db_new.php'])    {
          include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['typo3/db_new.php']);
      }

   So now you know that the key to use is "typo3/db\_new.php" when you
   wish to define a script which should be included as the extension.

Let's see what happens then in the extension "examples":

#. First we have a class that extends the SC\_db\_new
   (xclasses/class.tx\_examples\_scdbnew.php): :code:`function
   regularNew() {parent::regularNew();$this->code .= $this->doc->section(
   $GLOBALS['LANG']->sL('LLL:EXT:examples/locallang.xml:help'),
   $GLOBALS['LANG']->sL('LLL:EXT:examples/locallang.xml:make\_choice'),
   0, 1);}`

#. The XCLASS is then registered in the extension's ext\_localconf.php
   file: :code:`$TYPO3\_CONF\_VARS['BE']['XCLASS']['typo3/db\_new.php'] =
   t3lib\_extMgm::extPath($\_EXTKEY,
   'xclasses/class.tx\_examples\_scdbnew.php');`

There is no "table of extendable classes" in this document because 1)
all classes are extendable and 2) the number of classes will grow as
TYPO3 is further developed and extensions are made and 3) finally you
cannot extend a class unless you know it exists and have analyzed some
of its internal structure (methods / variables) - so you'll have to
dig into the source anyway!

Therefore, if you wish to extend something, follow this suggestion for
an analysis of the situation and you'll end up with the knowledge
needed in order to extend that class and thereby extend TYPO3
*without* loosing backwards compatibility with future updates. Great.


Notes on SC\_\* classes (script classes)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

There is one more thing to note about especially the SC\_\* classes in
the backend:

#. **Global vars:** They use a lot of variables from the global scope.
   This is due to historical reasons; The code formerly resided in the
   global scope and a quick conversion into classes demanded this
   approach. Future policy is to keep as many variables internal as
   possible and if any of these SC\_\* classes are developed further in
   the future, some of the globals might on that occasion be
   internalized.

#. **Large methods:** There are typically a init(), main() and
   printContent() method in the SC-classes. Each of these, in particular
   the main() method may grow large. Processing stuff in the start and
   end of the methods is easy - you just call parent::[methodname]() from
   your extension. But if you want to extend or process something in the
   middle of one of these methods, it would be necessary to call a dummy
   method at that point in the parent class. Such a dummy method would
   then be used for processing in  *your* class, but would not affect the
   general use of the parent class. Such dummy-method calls are not
   widely included yet, but will be as suggestions for them appears. And
   you are very welcome to give in such suggestions.I'll just give an
   example to illustrate what I mean:

   ::

      class SC_example {
          function main() {
              $number = 100;
              echo 'The number is ' . $number;
          }
      }


   This class prints the text "The number is 100". If you wish to do some
   calculations to the $number-variable before it is printed, you are
   forced to simply include the whole original main-method in your
   extension script. Here it would be no problem because the method is 2
   lines long. But it could be 200 lines! So what you do is that you
   suggest to the TYPO3 development to call a "harmless" dummy method in
   the main() method...

   ::

      class SC_example {
          function main() {
              $number = 100;
              $number = $this->processNumber($number);
              echo 'The number is ' . $number;
          }
          function processNumber($theNumber) {
              return $theNumber;
          }
      }


   ... and then you extend the class as follows: :code:`class`
   :code:`ux\_SC\_example` :code:`extends` :code:`SC\_example`
   :code:`{function` :code:`processNumber` :code:`(` :code:`$theNumber`
   :code:`){return(` :code:`$theNumber` :code:`<` :code:`100)` :code:`?`
   :code:`'less than 100'` :code:`:` :code:`'greater than 100'`
   :code:`;}}`

   ... and now the main() method would print "The number is greater than
   100" instead.Notice that you'll have to make such suggestions for
   dummy method calls because we will include them only as people need
   them.

