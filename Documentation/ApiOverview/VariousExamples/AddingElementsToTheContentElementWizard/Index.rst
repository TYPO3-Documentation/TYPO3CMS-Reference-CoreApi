.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


Adding elements to the Content Element Wizard
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Since TYPO3 4.3 the new content element wizard can be fully configured
using TSConfig. The example below describes the base method for adding
a plugin to the list of plugins in the wizard.


Adding elements under the "Plugins" header
""""""""""""""""""""""""""""""""""""""""""

If you want to add elements in the wizard under the plugins header
there is native support in the script for this.

Basically, what you do is to set content in the global variable
$TBE\_MODULES\_EXT['xMOD\_db\_new\_content\_el']['addElClasses']. The
keys in this array must be class names and the values is the absolute
path of the class. When the script is run the class files will be
included during initialization. Then, during the building of the array
of wizard elements the default wizard array is passed to the class you
have configured through the method proc() in your class.

For details the most easy thing will be to look into the script in the
function wizardArray() - this will make it clear to you how it works.


Example
~~~~~~~

As an example of how this works from an extension you can take a look
at the extension tt\_guest. This extension adds itself in the plugin
category by inserting these lines in its ext\_tables.php file::

   if (TYPO3_MODE=='BE')    {
       $TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_ttguest_wizicon'] =
           \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'class.tx_ttguest_wizicon.php';
   }

In the file class.tx\_ttguest\_wizicon.php you will find a class
looking like this::

   /**
    * Class, containing function for adding an element to the content element wizard.
    *
    * @author    Kasper Skaarhoj <kasper@typo3.com>
    * @package TYPO3
    * @subpackage tx_ttguest
    */
   class tx_ttguest_wizicon {

       /**
        * Processing the wizard-item array from db_new_content_el.php
        *
        * @param    array        Wizard item array
        * @return    array        Wizard item array, processed (adding a plugin for tt_guest extension)
        */
       function proc($wizardItems) {
           global $LANG;

               // Include the locallang information.
           $LL = $this->includeLocalLang();

               // Adding the item:
           $wizardItems['plugins_ttguest'] = array(
               'icon' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('tt_guest') . 'guestbook.gif',
               'title' => $LANG->getLLL('plugins_title', $LL),
               'description' => $LANG->getLLL('plugins_description', $LL),
               'params' => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]=3&defVals[tt_content][select_key]=' . rawurlencode('GUESTBOOK, POSTFORM')
           );

           return $wizardItems;
       }

       /**
        * Include locallang file for the tt_guest book extension (containing the description and title for the element)
        *
        * @return    array        LOCAL_LANG array
        */
       function includeLocalLang()    {
           include(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('tt_guest') . 'locallang.xml');
           return $LOCAL_LANG;
       }
   }

As you can see this class modifies the wizard array with an additional
item. This is how you can also add / modify elements in the array
using this API.


