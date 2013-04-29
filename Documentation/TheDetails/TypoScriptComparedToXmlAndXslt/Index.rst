.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _comparison-to-xml:

More about syntax, semantics and TypoScript compared to XML and XSLT
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

If you think you perfectly understand TypoScript now (you might
already...), then don't bother with this section. I even risk
confusing you again. But anyways, here it is - more theoretical
information on TypoScript including references to the relationship
between XML and XSLT:

XML and TypoScript - all about syntax:

A chunk of "TypoScript code" is like an XML document - it only
contains information in a structured way, nothing else. But in order
to store information in TypoScript or XML you need to follow the
**syntax** - rules about *how* the information values can be inserted
in the structure. The syntax is like the grammar for a human language
defines in which order words can be combined.

For XML such rules include that "all tags must be ended, e.g.
<b>...</b> or <br />", correct nesting, using lowercase for element
and attribute names etc. If you follow these rules, an XML document is
called 'well formed'". For TypoScript similar rules exist like "The =
operator assigns the rest of the text string as the value to the
preceding object path" or "A line starting with # or / is a comment
and therefore ignored".

XSLT and "TypoScript Templates" - all about semantics (meaning,
function):

This is syntactically valid XML::

   <asdf>qwerty</asdf>

And this is syntactically valid TypoScript::

   asdf = qwerty

And this is syntactically valid English::

   footballs sing red

But none of these examples make sense without some reference which
defines how elements, values and words can be combined in order to
form *meaning* - they need a *context*. This is called
**semantics**. For human languages we have it internally because we
know footballs can't sing and you can't "sing red" - we know it's
nonsense while the sentence is correctly formed. For an XML document
you have a DTD or schema which defines if the element "<asdf>" exists
on that level in the document (and if not, then it's nonsense) and for
TypoScript you have a *reference document* for the context where the
TypoScript syntax is used to define an information hierarchy - for
instance the "TSref" for TypoScript Templates or the "TSconfig"
document for "Page TSconfig" or "User TSconfig".

So an XML document makes sense only if you know the relationship of
the information stored inside of the document and that is required if
you want an XSLT stylesheet to transform one XML document to another
document. In fact an XSLT stylesheet is like a translator for XML - it
translates one "language" of XML into another "language" of XML.

Similarly TypoScript is used as *the syntax* to build "TypoScript
Templates" (*containing semantics - meaning*); the information only
makes sense if it follows the rules defined in the "TSref" document.

BTW, the comparison of "TypoScript Templates" and "XSLT" is
intentional since both can be described as *declarational programming
languages* - programming by *configuring values* which *instructs* a
*real procedural program* (e.g. the TypoScript Frontend Engine which
is written in PHP) how to output data.

XSL was not the way to go as the XSL proposals were public from
November 1999 which is a little later than TypoScript was born.
Anyways, they were a brand new technology and it did not seem smart
using it until it was more stable or had proved to be useful and
supported. At that time there certainly would be no significant XSL(T)
processors.

But TypoScript is also a concept that fits the PHP and TYPO3
configuration very well (although it has been taken very far in
certain areas). TypoScript is basically a large object-like structure
of information which can be set from text-files (DB records...) and
the TYPO3 default PHP frontend code just reacts to the settings in
TypoScript.

TypoScript was not destined to be a procedural language and it is not
today! It could be compared to the Windows registration database which
is a similar bunch of hierarchical configuration.

For more on `syntax and semantics, you can read this article
<http://www.jguru.com/faq/view.jsp?EID=81>`_ that I found on the net.

