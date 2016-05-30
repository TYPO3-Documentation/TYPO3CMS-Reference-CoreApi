
.. include:: ../../Includes.txt


.. _myths:
.. _faq:
.. _acknowledgements:

Myths, FAQ and acknowledgments
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This section contains a few remarks and answers to questions you may
still have.


.. _myth-scripting-language:

Myth: "TypoScript is a scripting language"
""""""""""""""""""""""""""""""""""""""""""

This is misleading to say since you will think that TypoScript is like
PHP or JavaScript while it is not. From the previous pages you have
learned that TypoScript strictly speaking is just a syntax. However
when the TypoScript syntax is applied to create TypoScript Templates
then it begins to look like programming.

In any case TypoScript is **not** comparable to a scripting language like
PHP or JavaScript. In fact, if TYPO3 CMS offers any scripting language it
is PHP itself! TypoScript is only an API which is often used to
configure underlying PHP code.

Finally the name "TypoScript" is misleading as well. We are sorry
about that; too late to change that now.


.. _myth-javascript:

Myth: "TypoScript has the same syntax as JavaScript"
""""""""""""""""""""""""""""""""""""""""""""""""""""

TypoScript was designed to be simple to use and understand. Therefore
the syntax looks like JavaScript objects to some degree. But again; it
is very dangerous to say this since it all stops with the syntax -
TypoScript is still not a procedural programming language!


.. _myth-proprietary:

Myth: "TypoScript is a proprietary standard"
""""""""""""""""""""""""""""""""""""""""""""

Since TypoScript is not a scripting language it does not make sense to
claim this in comparison to PHP, JavaScript, Java or whatever
*scripting language* .

However compared to XML or PHP arrays (which also contain
*information*) you can say that TypoScript is a proprietary syntax
since a PHP array or XML file could be used to contain the same
information as TypoScript does. But this is *not* a drawback. For
storage and exchange of *content* TYPO3 uses SQL (or XML if you need
to), for storage of *configuration values* XML is not suitable
anyways - TypoScript is much better at that job (see below).

To claim that TypoScript is a proprietary standard as an argument
against TYPO3 is really unfair since the claim makes it sound like
TypoScript is a whole new programming language or likewise. Yes, the
TypoScript *syntax* is proprietary but extremely useful and when you
get the hang of it, it is very easy to use. In all other cases TYPO3
uses official standards like PHP, SQL, XML, XHTML etc. for all
*external* data storage and manipulation.

The most complex use of TypoScript is probably with the TypoScript
Template Records. It is understandable that TypoScript has earned a
reputation of being complex when you consider how much of the Frontend
Engine you can configure through TypoScript Template records. But
basically TypoScript is just an API to the PHP functions underneath.
And if you think there are a lot of options there it would be no
better if you were to use the PHP functions directly! Then there would
be maybe even more API documentation to explain the API and you
wouldn't have the streamlined abstraction provided by TypoScript
Templates. This just served to say: The amount of features and the
time it would take to learn about them would not be eliminated, if
TypoScript was not invented!


.. _myth-complex:

Myth: "TypoScript is very complex"
""""""""""""""""""""""""""""""""""

TypoScript is simple in nature. But certainly it can quickly become
complex and get "out of hand" when the amount of code lines grows!
This can partly be solved by:

- Disciplined coding: Organize your TypoScript in a way that you can
  visually comprehend.

- Use the Syntax Highlighter to analyze and clean up your code - this
  gives you overview as well.


.. _xml:

Why not XML instead?
""""""""""""""""""""

A few times TypoScript has been compared with XML since both
"languages" are frameworks for storing information. Apart from XML
being a W3C standard (and TypoScript still not... :-) ) the main
difference is that XML is great for large amounts of information with
a high degree of "precision" while TypoScript is great for small
amounts of "ad hoc" information - like configuration values normally
are.

Actually a data structure defined in TypoScript could also have been
modeled in XML. Currently you *cannot* use XML as an alternative to
TypoScript, but this may happen at some
point. Let's present this fictitious example of how a TypoScript
structure could also have been implemented in "TSML" (our fictitious
name for the non-existing TypoScript Mark-Up Language):

.. code-block:: typoscript

   styles.content.bulletlist = TEXT
   styles.content.bulletlist {
     stdWrap.current = 1
     stdWrap.trim = 1
     stdWrap.if.isTrue.current = 1
     # Copying the object "styles.content.parseFunc" to this position
     stdWrap.parseFunc < styles.content.parseFunc
     stdWrap.split {
       token.char = 10
       cObjNum = 1
       1.current < .cObjNum
       1.wrap = <li>
     }
     # Setting wrapping value:
     stdWrap.fontTag = <ol type="1"> | </ol>
     stdWrap.textStyle.altWrap = {$styles.content.bulletlist.altWrap}
   }

That was 17 lines of TypoScript code and converting this information
into an XML structure could look like this:

.. code-block:: xml

   <TSML syntax="3">
     <styles>
       <content>
         <bulletlist>
           TEXT
           <stdWrap>
             <current>1</current>
             <trim>1</trim>
             <if>
               <isTrue>
                 <current>1</current>
               </isTrue>
             </if>
             <!-- Copying the object "styles.content.parseFunc" to this position -->
             <parseFunc copy="styles.content.parseFunc"/>
             <split>
               <token>
                 <char>10</char>
               </token>
               <cObjNum>1</cObjNum>
               <num:1>
                 <current>1</current>
                 <wrap>&lt;li&gt;</wrap>
               </num:1>
             </split>
             <!-- Setting wrapping value: -->
             <fontTag>&lt;ol type=&quot;1&quot;&gt; | &lt;/ol&gt;</fontTag>
             <textStyle>
               <altWrap>{$styles.content.bulletlist.altWrap}</altWrap>
             </textStyle>
           </stdWrap>
         </bulletlist>
       </content>
     </styles>
   </TSML>

That was 35 lines of XML - the double amount of lines! And in bytes
probably also much bigger. This example clearly demonstrates *why not
XML*! XML will just get in the way, it is not handy for what
TypoScript normally does. But hopefully you can at least use this
example in your understanding of what TypoScript is compared to XML.

The reasonable application for using XML as an alternative solution to
TypoScript is if an XML editor existed which in some way made the
entering of XML data into a structure like this possible and easy.

