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


Rendering page trees
^^^^^^^^^^^^^^^^^^^^

In your backend modules you might like to show information or perform
processing for a part of the page tree. There is a whole family of
libraries in the core for making trees from records, static page trees
or page trees that can be browsed (open/close nodes).

In this simple example I will show how to get the HTML for a static
page tree, using the class "t3lib\_pageTree" (child of
"t3lib\_treeView"). The output will look like this (missing the normal
TYPO3 styles though):

|img-22|

The PHP code that generates this looks like:

::

      1: require_once(PATH_t3lib . 'class.t3lib_pagetree.php');
      2: 
      3:     // Initialize starting point of page tree:
      4: $treeStartingPoint = 1135;
      5: $treeStartingRecord = t3lib_BEfunc::getRecord('pages', $treeStartingPoint);
      6: $depth = 2;
      7: 
      8:     // Initialize tree object:
      9: $tree = t3lib_div::makeInstance('t3lib_pageTree');
     10: $tree->init('AND ' . $GLOBALS['BE_USER']->getPagePermsClause(1));
     11: 
     12:     // Creating top icon; the current page
     13: $HTML = t3lib_iconWorks::getIconImage('pages', $treeStartingRecord, $GLOBALS['BACK_PATH'], 'align="top"');
     14: $tree->tree[] = array(
     15:     'row' => $treeStartingRecord,
     16:     'HTML'=>$HTML
     17: );
     18: 
     19:     // Create the tree from starting point:
     20: $tree->getTree($treeStartingPoint, $depth, '');
     21: #debug($tree->tree);
     22: 
     23:     // Put together the tree HTML:
     24: $output = '
     25:     <tr  bgcolor="#999999">
     26:         <td><b>Icon / Title:</b></td>
     27:         <td><b>Page UID:</b></td>
     28:     </tr>';
     29: foreach($tree->tree as $data)    {
     30:     $output.='
     31:         <tr bgcolor="#cccccc">
     32:             <td nowrap="nowrap">' . $data['HTML'] . htmlspecialchars($data['row']['title']) . '</td>
     33:             <td>' . htmlspecialchars($data['row']['uid']) . '</td>
     34:         </tr>';
     35: }
     36: 
     37: $output = '<table border="0" cellspacing="1" cellpadding="0">' . $output . '</table>';

- In line 1 the class is included.Notice how the constant "PATH\_t3lib"
  is used to set the path for "t3lib/".

- Line 4-5 sets up the starting point. You need a page id for that and
  additionally you must select that page record.Notice how another
  important API function, t3lib\_BEfunc::getRecord(), is used to get the
  record array for the page!

- Line 6 defines that the page tree will go 2 levels down from the
  starting point.

- Line 9-10 initializes the class.Notice how the BE\_USER object is
  called to get an SQL where clause that will ensure that only pages
  that are accessible for the user will be shown in the tree!Notice how
  t3lib\_div::makeInstance() is used to create the object. This is
  required by the TYPO3 CGL.

- Line 13-17 sets up the starting point page in the tree. This must be
  done externally if you would like your tree to include the root page
  (which is not always the case).Notice how line 13 calls the function
  t3lib\_iconWorks::getIconImage() to get the correct icon image for the
  pages table record! Also, $GLOBALS['BACK\_PATH'] is used to make sure
  the icon has a correct "back-path" to the location where the icon is
  on the server.

- Line 20 renders the page tree from the starting point and $depth
  levels down (at least 1 level)

- The rendered page tree is stored in a data array inside of the tree
  object. We need to traverse the tree data to create the tree in HTML.
  This gives us the chance to organize the tree in a table for instance.
  That is very useful if you need to show additional information for
  each page.
  
  - Lines 24-28 renders a table row with headings for the tree.
  
  - Lines 29-35 traverses the tree data and for each element a table row
    will be rendered with the icon/title and an additional cell containing
    the uid.
  
  - Line 37 wraps the table rows in a table tag.


Local extensions of the page tree classes
"""""""""""""""""""""""""""""""""""""""""

If you search in the source for other places where this class is used
you will often find that the class is extended locally in those
scripts. This is because it is possible to override certain functions
that generate for instance the icon or wraps the title in some way.

