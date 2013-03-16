.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt
.. include:: Images.txt


Adding Context Sensitive Menu items
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

When the CSM is being generated in the "alt\_clickmenu.php" script an
array with the elements is created. Before the array is passed over to
the final rendering function that will create the menu HTML, the array
will be passed in turns to external processing scripts. These scripts
are configured in this global array::

   $GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'];

Each script will then have a chance to manipulate the content of the
array and add/remove items as the script wants. This is what makes it
possible to add custom options to CSM.

The extensions "extra\_page\_cm\_options" adds a lot of CSM options.
The extension has an "ext\_tables.php" file and it contains code that
adds an entry in the array mentioned above::

   <?php
   if (!defined ('TYPO3_MODE'))     die ('Access denied.');
   if (TYPO3_MODE=='BE') {
       $GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][] = array(
           'name' => 'tx_extrapagecmoptions',
           'path' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'class.tx_extrapagecmoptions.php'
       );
   }
   ?>

The value of the "path" key is pointed to the absolute path of the
class file that contains code for manipulation of the CSM array. This
file must contain a class by the name of "name" and inside that class
a "main()" method that will be called for manipulation. The basic
skeleton looks like this::

   /**
    * Class, adding extra context menu options
    *
    * @author    Kasper Skaarhoj <kasper@typo3.com>
    * @package TYPO3
    * @subpackage tx_extrapagecmoptions
    */
   class tx_extrapagecmoptions {
       /**
        * Adding various standard options to the context menu.
        * This includes both first and second level.
        *
        * @param    object        The calling object. Value by reference.
        * @param    array        Array with the currently collected menu items to show.
        * @param    string        Table name of clicked item.
        * @param    integer        UID of clicked item.
        * @return    array        Modified $menuItems array
        */
       function main(&$backRef, $menuItems, $table, $uid) {
           global $BE_USER,$TCA,$LANG;
           $localItems = array();    // Accumulation of local items.
           ...
               $menuItems = array_merge($menuItems, $localItems);
               return $menuItems;
           }
       }
   }

The "extra\_page\_cm\_options" is a slightly special since it produces
additional CSM elements by calls back to the parent object where
rendering functions exists. This is due to historical reasons. Better
examples of handcrafted menu items can be found in extensions such as
"templavoila" (1st level additions for specific table) and "impexp"
(2nd level addition). Finally, the best way to initiate adding
elements is using the Kickstarter Wizard which contains an options for
creating CSMs:


|img-26| Implementing Context Sensitive Menus
"""""""""""""""""""""""""""""""""""""""""""""

If you want to implement a CSM for an element in your own backend
modules you have to do two things:

- Include standard JavaScript and HTML code in the HTML document for all
  CSM instances.

- Wrap the icon / element title with a link that opens the CSM.

The standard JavaScript and HTML can be fetched from the backend
document template object. In a typical backend module environment this
object is available as $this->doc and these four lines will do the
trick::

      1:             // Setting up the context sensitive menu:
      2:         $CMparts = $this->doc->getContextMenuCode();
      3:         $this->doc->bodyTagAdditions = $CMparts[1];
      4:         $this->doc->JScode .= $CMparts[0];
      5:         $this->doc->postCode.= $CMparts[2];

These lines must be executed  *before* calling
"$this->doc->startPage()".

- Line 2 asks the template object to generate the standard content. It
  is returned in an array.

- Line 3 adds event handlers for the <body> tag::

           onmousemove="GL_getMouse(event);" onload="initLayer();"

- Line 4 adds JavaScript functions in the <head> of the HTML output

- Line 5 adds the <div> layers in the bottom of the page::

           <div id="contentMenu0" style="z-index:1; position:absolute;visibility:hidden"></div>
           <div id="contentMenu1" style="z-index:2; position:absolute;visibility:hidden"></div>


CSM for database elements
"""""""""""""""""""""""""

Linking icons to open the CSM is easy::

       // Get icon with CSM:
   $icon = \TYPO3\CMS\Backend\Utility\IconUtility::getIconImage('tx_templavoila_datastructure', $row, $GLOBALS['BACK_PATH'], 'align="top"');
   $content .= $this->doc->wrapClickMenuOnIcon($icon, 'tx_templavoila_datastructure', $row['uid'], 1);

In this example the first line creates an <img> tag with the icon of a
record from the table "tx\_templavoila\_datastructure". The variable
$row must be the record array of an element from this database table.

The second line wraps the icon ($icon) in a link that will open the
CSM over it. This is done by calling "template::wrapClickMenuOnIcon()"
with $icon HTML, table name and element uid. The fourth argument is a
boolean you should set if your script is shown in the list frame of
the backend. This will tell "alt\_clickmenu.php" which generates the
HTML content that it should be written back to the list frame and not
the navigation frame for instance.

Result:


|img-27| CSM for files
""""""""""""""""""""""

Activating a CSM for a file is also easy. As for database elements it
requires that the standard content is added to the HTML document. From
that point you just call the same function,
"template::wrapClickMenuOnIcon()" but set the second argument to the
absolute path of the file (and keep the third argument, the uid,
blank). ::

   $GLOBALS['SOBE']->doc->wrapClickMenuOnIcon($theIcon,$path);

Notice, that in this case the document template object used is the
global variable $SOBE which is normally available in backend modules
as well. You might also use the default instance found in
$TBE\_TEMPLATE.

For more information see the inline documentation of the function
wrapClickMenuOnIcon(). It is found in the file "template.php" in the
typo3/ folder.


