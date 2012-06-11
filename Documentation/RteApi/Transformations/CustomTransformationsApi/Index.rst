

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


Custom transformations API
^^^^^^^^^^^^^^^^^^^^^^^^^^

Instead of using the built-in transformations of TYPO3 you can program
your own. This is done by creating a PHP class with two methods for
transformation. Additionally you have to define a key (like
"css\_transform") for your transformation so you can refer to it in
the configuration of Rich Text Editors.


Custom transformation key
"""""""""""""""""""""""""

You should pick a custom transformation key which is prefixed with
either "tx\_" or "user\_". Use "tx\_[extension key]\_[suffix]" if you
deliver your transformation inside an extension.

**Notice:** If you pick one of the default transformation keys (except
the meta-transformations) you will simply  *override it* and your
transformation will be called instead!


Registering the transformation key in the system
""""""""""""""""""""""""""""""""""""""""""""""""

In "ext\_localconf.php" you simply set a $TYPO3\_CONF\_VARS variable
to point to the class which contains the transformation methods:

::

   $TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_parsehtml_proc.php']['transformation']['tx_myext']
       = 'EXT:myext/custom_transformation.php:user_transformation';

Here the  *transformation key* is defined to be "tx\_myext" (assuming
the extension has the extension key "myext") and the value points to a
file inside the transformation which will contain the class
"user\_transformation" (instantiated by t3lib\_div::getUserObj())

This class must contain two methods, "transform\_db" and
"transform\_rte" for each transformation direction.


Code listing of "user\_transformation"
""""""""""""""""""""""""""""""""""""""

This code listing shows a simple transformation. When content is
delivered to the RTE it will add a <hr/> tag to the end of the
content. When the content is stored in the database any <hr/> tag in
the end of the content will be removed and substituted with
whitespace. This is of totally useless but nevertheless shows the
concept of transformations between RTE and DB.

::

      0: /**
      1:  * Custom RTE transformation
      2:  */
      3: class user_transformation {
      4: 
      5:         // object; Reference to the parent object, t3lib_parsehtml_proc
      6:     var $pObj;
      7: 
      8:         // Transformation key of self.
      9:     var $transformationKey = 'tx_myext';
     10: 
     11:         // Will contain transformation configuration if found:
     12:     var $conf;
     13: 
     14: 
     15:     /**
     16:      * Setting specific configuration for this transformation
     17:      *
     18:      * @return    void
     19:      */
     20:     function initConfig()    {
     21:         $this->conf = $this->pObj->procOptions['usertrans.'][$this->transformationKey.'.'];
     22:     }
     23: 
     24:     /**
     25:      * Reserved method name, called when content is transformed for DB storage
     26:      * If "proc.usertrans.tx_myext.addHrulerInRTE = 1" then a horizontal ruler in the
     27:      * end of the content will be removed (if found)
     28:      *
     29:      * @param    string        RTE HTML to clean for database storage
     30:      * @return    string        Processed input string.
     31:      */
     32:     function transform_db($value)    {
     33:         $this->initConfig();
     34: 
     35:         if ($this->conf['addHrulerInRTE'])    {
     36:             $value = eregi_replace('<hr[[:space:]]*[\/]>[[:space:]]*$','',$value);
     37:         }
     38: 
     39:         return $value;
     40:     }
     41: 
     42:     /**
     43:      * Reserved method name, called when content is transformed for RTE display
     44:      * If "proc.usertrans.tx_myext.addHrulerInRTE = 1" then a horizontal ruler
     45:      * will be added in the end of the content.
     46:      *
     47:      * @param    string        Database content to transform to RTE ready HTML
     48:      * @return    string        Processed input string.
     49:      */
     50:     function transform_rte($value)    {
     51:         $this->initConfig();
     52: 
     53:         if ($this->conf['addHrulerInRTE'])    {
     54:             $value.='<hr/>';
     55:         }
     56: 
     57:         return $value;
     58:     }
     59: }


Comments to code listing
""""""""""""""""""""""""

- The transformation methods "transform\_rte" and "transform\_db" takes
  a single argument which is the value to transform. They have to return
  that value again.

- The internal variable $pObj is set to be a reference to the parent
  object which is an instance of "t3lib\_parsehtml\_proc". Inside of
  this object you can access the default transformation functions if you
  need to and in particular you can read out configuration settings.

- The internal variable $transformationKey is automatically set to the
  transformation key that is active.

- Notice that both transformation functions call initConfig() (line 33
  and 51) which reads custom configuration.


Using the transformation
""""""""""""""""""""""""

In order to use the transformation you simply use it in the list of
transformations in Special Configuration. Here is an example that
works:

::

      1: 'TEST01' => Array (
      2:     'label' => 'TEST01: Text field',
      3:     'config' => Array (
      4:         'type' => 'text',
      5:     ),
      6:     'defaultExtras' => 'richtext[*]:rte_transform[mode=tx_myext-css_transform]'
      7: ),

The order is important. The order in this list is the order of calling
when the direction is "db". If the order is reversed the <hr/> tag
will come out as regular text in the RTE because "css\_transform"
protects all non-allowed tags with htmlspecialchars().

Now the transformations should be called correctly. Before the <hr/>
will be added/removed we also have to configure through Page TSconfig
(because we programmed our transformation to look for this
configuration option):

::

   RTE.default.proc.usertrans.tx_myext.addHrulerInRTE = 1

That's all!

