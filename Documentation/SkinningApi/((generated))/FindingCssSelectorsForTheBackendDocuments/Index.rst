.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt
.. include:: Images.txt


Finding CSS selectors for the backend documents
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

In the process of skinning TYPO3 with CSS styles you should proceed
from general to specific. This means

- First, create styles for main elements like BODY, H2, H3, P, PRE,
  INPUT etc. making the interface look as you want in  *general* .

- Secondly, create specific style rules for specific scripts as needed.

If you look inside "typo3/stylesheet.css" you will see that this is
the way that stylesheet proceeds. In fact it might not be so bad an
idea to take this stylesheet as an example for your own! In that case
you can either choose to totally substitute the default stylesheet,
"typo3/stylesheet.css", with a new one (by $TBE\_STYLES['stylesheet'])
or simply create an additional stylesheet (set up by
$TBE\_STYLES['styleSheetFile\_post']) which will be included as the
last one - and in this stylesheet you override any of the previous
rules you want to change (recommended method).


Addressing specific elements in the backend
"""""""""""""""""""""""""""""""""""""""""""

Lets say you want to specifically style the two elements shown in this
image:

|img-42|

- #1 should be blueish in the background

- #2 should have a dotted border around

What you do is this:

- Right-click the frame, select "Show HTML source" or whatever your
  browser allows you.

- Paste the HTML source of the script into the tool "CSS analyzer" found
  in the extension "extdeveval" - this will analyse the hierarchy of CSS
  selectors.

- Find your selector, write CSS rules!

In this screenshot you can see how I have pasted the HTML source of
the script into the tool mentioned and in return I get a nice overview
of the CSS selectors inside:

|img-43|

In less than 10 seconds this has allowed me to spot that the exact
address of the header cell is "BODY#typo3-db-list-php
TABLE.typo3-dblist TR TD.c-headLineTable" and I can now add to my
stylesheet::

   BODY#typo3-db-list-php TABLE.typo3-dblist TR TD.c-headLineTable {
           background-color: #ccccff;
   }

Likewise I could easily find that the two selector boxes were
encapsulated in a DIV section which I could address like this::

   BODY#typo3-db-list-php DIV#typo3-listOptions {
           border: dotted 1px #999999;
   }

The result was:

|img-44|

Now, as you can see the selector contained "BODY#typo3-db-list-php"
which is a specific address to the Web > List module (using its script
ID!). If I wanted my styles to be more general so also the File >
Filelist module would affected, then I could (in this case) remove the
BODY#... part::

   DIV#typo3-listOptions {
           border: dotted 1px #999999;
   }

|img-45|


