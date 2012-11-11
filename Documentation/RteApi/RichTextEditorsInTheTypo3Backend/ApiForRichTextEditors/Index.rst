.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


API for Rich Text Editors
^^^^^^^^^^^^^^^^^^^^^^^^^

Connecting an RTE in an extension to TYPO3 is easy.

- Create a class file in your extensions, named "class.tx\_[extensionkey
  minus underscores]\_base.php". Make the class inside an extension of
  the system class, "t3lib\_rteapi" (which you should include first of
  course) and override functions from the parent class to the degree
  needed.

- In the "ext\_localconf.php" file you put an entry in
  $TYPO3\_CONF\_VARS['BE']['RTE\_reg'] which registers the new RTE with
  the system. For example;$TYPO3\_CONF\_VARS['BE']['RTE\_reg']['myrte']
  = array('objRef' =>
  'EXT:myrte/class.tx\_myrte\_base.php:&tx\_myrte\_base');

The object reference in "objRef" consists of a filename reference (for
the class file) and then the name of the class prefixed with "&" which
ensures that you get the same instance (global) of the object each
time you ask for it. "myrte" is the extension key of your RTE
extension (with underscores stripped).


class.t3lib\_rteapi.php
"""""""""""""""""""""""

In the base class for the RTE API there are three main methods of
interest:

- **function isAvailable()** This method is asked for the availability
  of the RTE; This is where you should check for environmental
  requirements that is needed for your RTE. Basically the method must
  return TRUE if the RTE is available. If it is not, the RTE can put
  text entries in the internal array ->errorLog which is used to report
  back the reason why it was not available.

- **function drawRTE(&$pObj,$table,$field,$row,$PA,$specConf,$thisConfig
  ,$RTEtypeVal,$RTErelPath,$thePidValue)** This method draws the content
  for the editing form of the RTE. It is called from the
  "t3lib\_TCEforms" class which also passes a reference to itself in
  $pObj. For details on the arguments in the method call, please see
  inside "class.t3lib\_rteapi.php".

- **function transformContent($dirRTE,$value,$table,$field,$row,$specCon
  f,$thisConfig,$RTErelPath,$pid)** This method is used both from
  ->drawRTE() and from t3lib\_tcemain to transform the content between
  the database and RTE. When content is loaded from the database to the
  RTE (and vice versa) it may need some degree of transformation. For
  instance references to links and images in the database might have to
  be relative while the RTE requires absolute references. This is just a
  simple example of what "transformations" can do for you and why you
  need them. There are plenty of details on this topic later.


Example: The "rte" extension
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The "rte" extension has a "ext\_localconf.php" file which looks like
this::

   if (!defined ('TYPO3_MODE'))     die ('Access denied.');

   $TYPO3_CONF_VARS['BE']['RTE_reg']['rte'] = array('objRef' => 'EXT:rte/class.tx_rte_base.php:&tx_rte_base');

As you can see it registers the API class to the system. In the class
"tx\_rte\_base" the three methods from the list above is available.

The file "class.tx\_rte\_base.php" looks like this::

      4: require_once(PATH_t3lib.'class.t3lib_rteapi.php');
      5: /**
      6:  * RTE base class (Traditional RTE for MSIE 5+ on windows only!)
      7:  *
      8:  * @author    Kasper Skaarhoj <kasper@typo3.com>
      9:  * @package TYPO3
     10:  * @subpackage tx_rte
     11:  */
     12: class tx_rte_base extends t3lib_rteapi {
     13:
     14:         // External:
     15:     var $RTEdivStyle;                // Alternative style for RTE <div> tag.
     16:
     17:         // Internal, static:
     18:     var $ID = 'rte';                // Identifies the RTE ...
     19:     var $debugMode = FALSE;            // Debug mode
     20:
     21:
     22:     /**
     23:      * Returns true if the RTE is available. Here you check if the browser requirements are met.
     24:      * If there are reasons why the RTE cannot be displayed you simply enter them as text in ->errorLog
     25:      *
     26:      * @return    boolean        TRUE if this RTE object offers an RTE
     27:      */
     28:     function isAvailable()    {
     29:         global $CLIENT;
     30:
     31:         if (TYPO3_DLOG)    t3lib_div::devLog('Checking for availability...','rte');
     32:
     33:         $this->errorLog = array();
     34:         if (!$this->debugMode)    {    // If debug-mode, let any browser through
     35:             if ($CLIENT['BROWSER']!='msie')     $this->errorLog[] = '"rte": Browser is not MSIE';
     36:             if ($CLIENT['SYSTEM']!='win')         $this->errorLog[] = '"rte": Client system is not Windows';
     37:             if ($CLIENT['VERSION']<5)             $this->errorLog[] = '"rte": Browser version below 5';
     38:         }
     39:         if (!count($this->errorLog))    return TRUE;
     40:     }
     41:
     42:     /**
     43:      * Draws the RTE as an iframe for MSIE 5+
     44:      *
   ...
     55:      * @return    string        HTML code for RTE!
     56:      */
     57:     function drawRTE(&$pObj,$table,$field,$row,$PA,$specConf,$thisConfig,$RTEtypeVal,$RTErelPath,$thePidValue)    {
     58:
     59:             // Draw form element:
     60:         if ($this->debugMode)    {    // Draws regular text area (debug mode)
     61:             $item = parent::drawRTE($pObj,$table,$field,$row,$PA,$specConf,$thisConfig,$RTEtypeVal,$RTErelPath,$thePidValue);
     62:         } else {    // Draw real RTE (MSIE 5+ only)
     63:
     64:                 // Adding needed code in top:
     65:             $pObj->additionalJS_pre['rte_loader_function'] = $this->loaderFunc($pObj->formName);
     66:             $pObj->additionalJS_submit[] = "
     67:                             if(TBE_RTE_WINDOWS['".$PA['itemFormElName']."'])    { document.".$pObj->formName."['".$PA['itemFormElName']."'].value = TBE_RTE_WINDOWS['".$PA['itemFormElName']."'].getHTML(); } else { OK=0; }";
     68:
   ...
     82:
     83:                 // Transform value:
     84:             $value = $this->transformContent('rte',$PA['itemFormElValue'],$table,$field,$row,$specConf,$thisConfig,$RTErelPath,$thePidValue);
     85:
     86:                 // Register RTE windows:
     87:             $pObj->RTEwindows[] = $PA['itemFormElName'];
     88:             $item = '
     89:                 '.$this->triggerField($PA['itemFormElName']).'
     90:                 <input type="hidden" name="'.htmlspecialchars($PA['itemFormElName']).'" value="'.htmlspecialchars($value).'" />
     91:                 <div id="cdiv'.count($pObj->RTEwindows).'" style="'.htmlspecialchars($RTEdivStyle).'">
     92:                 <iframe
     93:                     src="'.htmlspecialchars($rteURL).'"
     94:                     id="'.$PA['itemFormElName'].'_RTE"
     95:                     style="visibility:visible; position:absolute; left:0px; top:0px; height:100%; width:100%;"></iframe>
     96:                 </div>';
     97:         }
     98:
     99:             // Return form item:
    100:         return $item;
    101:     }

Here follows some comments:

- Line 28-40 detects the browser. Only if the browser is MSIE on Windows
  and a version higher than or equal to 5, then will the RTE be
  available for the user. Notice how error messages are set in
  ->errorLog so the system can give the user a hint as to why the RTE
  didn't show up.

- Line 57 starts the method "drawRTE" which creates the RTE as HTML.
  This RTE is in fact created by another script inside an <iframe>. The
  content of the field is stored in a hidden field and the script in the
  IFRAME loads the content by JavaScript from this field.Basically, the
  content submitted from the RTE is  *in this hidden field!* In other
  words, the RTE has to load and save back content to this field. Other
  RTEs might integrate this differently. For instance a Java RTE would
  also communicate the content to and from a hidden field while the
  "rtehtmlarea" extension uses a normal <textarea> field but somehow
  overlays it with visual formatting.In all cases, the call to
  triggerField() is important (line 89); This returns a hidden field
  with the same field name as the main field but prefixed
  "\_TRANSFORM\_" and having the value "RTE". This hidden field triggers
  the transformation process from RTE content to database (DB) in
  TCEmain and therefore you have to add it!

- Notice how line 84 calls the "transformContent" method in the class to
  create the $value to put into the RTE. In the case of the "rte"
  extension the "transformContent" method is used from the parent class,
  but if you need special transformations you can easily do so by
  overriding the function in you child class.


