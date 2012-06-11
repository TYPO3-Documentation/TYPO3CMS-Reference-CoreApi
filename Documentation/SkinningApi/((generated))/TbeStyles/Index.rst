

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


$TBE\_STYLES
^^^^^^^^^^^^

When you make skins for TYPO3 you basically set up values in the
global array $TBE\_STYLES which will make the system use alternative
icons, stylesheets, frame widths etc.

You change values in $TBE\_STYLES through an extension, setting the
alternative values in the “ext\_tables.php” file of the extension. For
an example, see the extension “skin360”.


$TBE\_STYLES API
""""""""""""""""

The $TBE\_STYLES array contains these keys

When the values are references to files (icons, logos etc) the path
must be  *relative* to the TYPO3 backend dir.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Key
         Key
   
   Subkeys
         Subkeys
   
   Description
         Description


.. container:: table-row

   Key
         colorschemes
   
   Subkeys
         [0-x]
   
   Description
         *Related to TCEforms. See other section about visual style of
         TCEforms.*


.. container:: table-row

   Key
         styleschemes
   
   Subkeys
         [0-x]
   
   Description
         *Related to TCEforms. See other section about visual style of
         TCEforms.*


.. container:: table-row

   Key
         borderschemes
   
   Subkeys
         [0-x]
   
   Description
         *Related to TCEforms. See other section about visual style of
         TCEforms.*


.. container:: table-row

   Key
         mainColors
   
   Subkeys
         bgColor
         
         bgColor2
         
         bgColor3
         
         bgColor4
         
         bgColor5
         
         bgColor6
         
         hoverColor
   
   Description
         Main colorscheme in interface. Notice that these colors are
         redundantly set in the stylesheet and you have to keep them in sync.
         Setting the colors here is still necessary but secondary in priority
         to the stylesheet settings.
         
         Always use #xxxxxx color definitions!
         
         Here is a description of the colors.
         
         - bgColor *Light page background color*
         
         - bgColor2 *Alternative header background (steel blue)*
         
         - bgColor3 *Color for “documents” - concept which is now removed.
           Anyways, light color)*
         
         - bgColor4 *For table content cells (light tablerow background,
           brownish)*
         
         - bgColor5 *For table header cells in sections (light tablerow
           background, greenish)*
         
         - bgColor6 *For backend module section headers (light H2 background,
           yellowish. Light)*
         
         - hoverColor *Link hover color*
         
         **Example:**
         
         ::
         
            $TBE_STYLES['mainColors'] = array(    
                'bgColor' => '#EDF4EB',
                'bgColor2' => '#7C8591',
                'bgColor3' => '#E4E8F2',
                'bgColor4' => '#92AA8B',
                'bgColor5' => '#A5B7C1',
                'bgColor6' => '#C7BF81',
                'hoverColor' => '#800000'
            );
         
         Corresponding stylesheet values:
         
         Here is an example of the stylesheet values corresponding to the
         “mainColors” values shown above. Notice how they share the same name -
         but with some variations. For instance “bgColor-10” and “bgColor-20”
         is based on “bgColor” but darkend approx. 10% and 20%. Such variations
         are available for usage when you want alternating values in a listing.
         
         ::
         
            .bgColor {background-color: #F7F3EF;}
            .bgColor-10 {background-color: #ede9e5;}
            .bgColor-20 {background-color: #e3dfdb;}
            .bgColor2 {background-color: #9BA1A8;}
            .bgColor3 {background-color: #F6F2E6;}
            .bgColor3-20 {background-color: #e2ded2;}
            .bgColor4 {background-color: #D9D5C9;}
            .bgColor4-20 {background-color: #c5c1b5;}
            .bgColor5 {background-color: #ABBBB4;}
            .bgColor6 {background-color: #E7DBA8;}
         
         (From file typo3/stylesheet.css)


.. container:: table-row

   Key
         background
   
   Subkeys
         -
   
   Description
         Background image generally in the backend
         
         *Deprecated - use the $TBE\_STYLES['skinImg'] feature instead!*


.. container:: table-row

   Key
         logo
   
   Subkeys
         -
   
   Description
         Logo in alternative backend, top left: 129x32 pixels
         
         *Deprecated - use the $TBE\_STYLES['skinImg'] feature instead!*


.. container:: table-row

   Key
         logo\_login
   
   Subkeys
         -
   
   Description
         Login-logo: 333x63 pixels
         
         *Deprecated - use the $TBE\_STYLES['skinImg'] feature instead!*


.. container:: table-row

   Key
         loginBoxImage\_rotationFolder
   
   Subkeys
         -
   
   Description
         Setting login box image rotation folder. From this folder images are
         selected randomly for display in the login box.


.. container:: table-row

   Key
         stylesheet
   
   Subkeys
         -
   
   Description
         Alternative stylesheet to the default "typo3/stylesheet.css"
         stylesheet.


.. container:: table-row

   Key
         stylesheet2
   
   Subkeys
         -
   
   Description
         Additional stylesheet (not used by default). Set BEFORE any in-
         document styles


.. container:: table-row

   Key
         styleSheetFile\_post
   
   Subkeys
         -
   
   Description
         Additional stylesheet. Set AFTER any in-document styles


.. container:: table-row

   Key
         inDocStyles\_TBEstyle
   
   Subkeys
         -
   
   Description
         Additional default in-document styles.


.. container:: table-row

   Key
         dims
   
   Subkeys
         leftMenuFrameW
         
         topFrameH
         
         shortcutFrameH
         
         selMenuFrame
         
         navFrameWidth
   
   Description
         Setting of alternative dimensions of framesets in TYPO3:
         
         Description of subkeys:
         
         - FrameW *Left menu frame width*
         
         - topFrameH *Top frame heigth*
         
         - shortcutFrameH *Shortcut frame height*
         
         - selMenuFrame *Width of the selector box menu frame*
         
         - navFrameWidth *Default navigation frame width*
         
         **Example:**
         
         ::
         
                // Alternative dimensions for frameset sizes:
            $TBE_STYLES['dims']['leftMenuFrameW']=165;
            $TBE_STYLES['dims']['topFrameH']=35;
            $TBE_STYLES['dims']['shortcutFrameH']=35;
            $TBE_STYLES['dims']['selMenuFrame']=180;
            $TBE_STYLES['dims']['navFrameWidth']=350;


.. container:: table-row

   Key
         scriptIDindex
   
   Subkeys
         [script-id]
   
   Description
         All scripts in TYPO3s backend calculates an automatic “script-id”.
         This id can be found in the HTML source:
         
         ::
         
            <html>
            <head>
                    <!-- TYPO3 Script ID: typo3/mod/web/perm/index.php -->
            ...
         
         With the “scriptIDindex” feature you can override  *any* $TBE\_STYLES
         setting on a per-script basis as long as you know the script ID.
         
         An example is in the “skin360” extension where the rollover color of
         the Context Sensitive Menus is defined by
         $TBE\_STYLES['mainColors']['bgColor5']. However the color should be
         different from the general “bgColor5”. This can be done by the PHP
         line below - because the script ID 'typo3/alt\_clickmenu.php' simply
         configures the bgColor5 value differently when the alt\_clickmenu.php
         script requests it!
         
         ::
         
            $TBE_STYLES['scriptIDindex']['typo3/alt_clickmenu.php']['mainColors']['bgColor5']='#E0E7C7';


.. container:: table-row

   Key
         skinImgAutoCfg
   
   Subkeys
         absDir
         
         relDir
         
         forceFileExtension
         
         scaleFactor
   
   Description
         Configures automatic detection of alternative icons. This works by
         setting up a directory inside of which TYPO3 looks to find a file with
         the same filename as the one requested - and if found, the icon is
         used instead.
         
         - absDir *Absolute path to the directory with the icons (needed so icons
           can be read by getimagesize)*
         
         - relDir *Relative path to the directory with the icons (needed for
           making the <img> tag.)*
         
         - forceFileExtension *This can allow you to specify an alternative file
           extension to look for. For instance most icons in TYPO3 are gif-files.
           By setting this value to “png” all filenames looked for will be the
           gif-filename body but with a “.png” extension.*
         
         - scaleFactor *Allows you to enter a value between 0-1 by which to scale
           the icons. Thus you can size-down all icons from the skin.*
           ***Notice:***  *Backend Module icons are not affected by this scaling
           factor*
         
         **Example code listing:**
         
         ::
         
                // Setting up auto detection of alternative icons:
            $TBE_STYLES['skinImgAutoCfg']=array(
                'absDir' => t3lib_extMgm::extPath($_EXTKEY).'icons/',
                'relDir' => t3lib_extMgm::extRelPath($_EXTKEY).'icons/',
                'forceFileExtension' => 'png',
                'scaleFactor' => 2/3,
            );


.. container:: table-row

   Key
         skinImg
   
   Subkeys
         [icon reference]
   
   Description
         Manual configuration of icon alternatives.
         
         This is needed especially for backend module icons since they are not
         possible to skin with the feature “skinImgAutoCfg” which is otherwise
         recommended instead of manual configuration.
         
         Generally each subkey is a reference to the icon, relative to TYPO3
         main dir (e.g. “gfx/ol/blank.gif”) or if from an extension, relative
         to “ext/[extension key]/” folder.
         
         For modules the key is special. It is prefixed “MOD:” and then the
         module key. For example “MOD:web/website.gif” or
         “MOD:web\_uphotomarathon/tab\_icon.gif”
         
         For examples, see code listing below.


.. container:: table-row

   Key
         border
   
   Subkeys
   
   
   Description
         Path to an alternative HTML file instead of the default
         "typo3/border.html" which is displayed between the page tree and the
         right frame.


.. ###### END~OF~TABLE ######

Here is an example code listing for how most of these values can be
set up in a “ext\_tables.php” file for an extension:

::

      0: 
      1: 
      2: if (TYPO3_MODE=='BE')    {
      3: 
      4:     $presetSkinImgs = is_array($TBE_STYLES['skinImg']) ? $TBE_STYLES['skinImg'] : array();    // Means, support for other extensions to add own icons...
      5:     
      6:     $TBE_STYLES['mainColors'] = array(    
      7:         'bgColor' => '#EDF4EB',
      8:         'bgColor2' => '#7C8591',
      9:         'bgColor3' => '#E4E8F2',
     10:         'bgColor4' => '#92AA8B',
     11:         'bgColor5' => '#A5B7C1',
     12:         'bgColor6' => '#C7BF81',
     13:         'hoverColor' => '#800000'
     14:     );
     15: 
     16:         // Setting the relative path to the extension in temp. variable:    
     17:     $temp_eP = t3lib_extMgm::extRelPath($_EXTKEY);
     18:     
     19:         // Setting login box image rotation folder:
     20:     $TBE_STYLES['loginBoxImage_rotationFolder'] = $temp_eP.'loginimages/';
     21:     
     22:         // Setting up stylesheets (See template() constructor!)
     23:     $TBE_STYLES['styleSheetFile_post'] = $temp_eP.'stylesheet_post.css';    // Additional stylesheet. Set AFTER any in-document styles
     24: 
     25:         // Alternative dimensions for frameset sizes:
     26:     $TBE_STYLES['dims']['leftMenuFrameW']=165;        // Left menu frame width
     27:     $TBE_STYLES['dims']['topFrameH']=35;            // Top frame heigth
     28:     $TBE_STYLES['dims']['shortcutFrameH']=35;        // Shortcut frame height
     29:     $TBE_STYLES['dims']['selMenuFrame']=180;        // Width of the selector box menu frame
     30:     $TBE_STYLES['dims']['navFrameWidth']=350;        // Default navigation frame width
     31:     
     32:         // Setting roll-over background color for click menus:
     33:         // Notice, this line uses the the 'scriptIDindex' feature to override another value in this array (namely $TBE_STYLES['mainColors']['bgColor5']), for a specific script "typo3/alt_clickmenu.php"
     34:     $TBE_STYLES['scriptIDindex']['typo3/alt_clickmenu.php']['mainColors']['bgColor5']='#E0E7C7';
     35: 
     36:         // Setting up auto detection of alternative icons:
     37:     $TBE_STYLES['skinImgAutoCfg']=array(
     38:         'absDir' => t3lib_extMgm::extPath($_EXTKEY).'icons/',
     39:         'relDir' => t3lib_extMgm::extRelPath($_EXTKEY).'icons/',
     40:         'forceFileExtension' => 'png',    // Force to look for PNG alternatives...
     41:     );
     42:     
     43:         // Manual setting up of alternative icons. This is mainly for module icons which has a special prefix:
     44:     $TBE_STYLES['skinImg'] = array_merge($presetSkinImgs, array(
     45:         'gfx/ol/blank.gif' => array('clear.gif','width="27" height="24"'),
     46:         
     47:         'MOD:web/website.gif'  => array($temp_eP.'icons/module_web.png','width="24" height="24"'),
     48:         'MOD:web_layout/layout.gif'  => array($temp_eP.'icons/module_web_layout.png','width="24" height="24"'),
     49:         'MOD:web_view/view.gif'  => array($temp_eP.'icons/module_web_view.png','width="23" height="24"'),
     50:         'MOD:web_list/list.gif'  => array($temp_eP.'icons/module_web_list.png','width="24" height="24"'),
     51:         'MOD:web_info/info.gif'  => array($temp_eP.'icons/module_web_info.png','width="24" height="24"'),
     52:         'MOD:web_perm/perm.gif'  => array($temp_eP.'icons/module_web_perms.png','width="24" height="24"'),
     53:         'MOD:web_func/func.gif'  => array($temp_eP.'icons/module_web_func.png','width="24" height="24"'),
     54:         'MOD:web_ts/ts1.gif'  => array($temp_eP.'icons/module_web_ts.png','width="24" height="24"'),
     55:         'MOD:web_modules/modules.gif' => array($temp_eP.'icons/module_web_modules.png','width="24" height="24"'),
     56:         'MOD:file/file.gif'  => array($temp_eP.'icons/module_file.png','width="24" height="24"'),
     57:         'MOD:file_list/list.gif'  => array($temp_eP.'icons/module_file_list.png','width="24" height="24"'),
     58:         'MOD:file_images/images.gif'  => array($temp_eP.'icons/module_file_images.png','width="24" height="24"'),
     59:         'MOD:doc/document.gif'  => array($temp_eP.'icons/module_doc.png','width="24" height="24"'),
     60:         'MOD:user/user.gif'  => array($temp_eP.'icons/module_user.png','width="24" height="24"'),
     61:         'MOD:user_task/task.gif'  => array($temp_eP.'icons/module_user_taskcenter.png','width="24" height="24"'),
     62:         'MOD:user_setup/setup.gif'  => array($temp_eP.'icons/module_user_setup.png','width="24" height="24"'),
     63:         'MOD:tools/tool.gif'  => array($temp_eP.'icons/module_tools.png','width="25" height="24"'),
     64:         'MOD:tools_beuser/beuser.gif'  => array($temp_eP.'icons/module_tools_user.png','width="24" height="24"'),
     65:         'MOD:tools_em/em.gif'  => array($temp_eP.'icons/module_tools_em.png','width="24" height="24"'),
     66:         'MOD:tools_dbint/db.gif'  => array($temp_eP.'icons/module_tools_dbint.png','width="25" height="24"'),
     67:         'MOD:tools_config/config.gif'  => array($temp_eP.'icons/module_tools_config.png','width="24" height="24"'),
     68:         'MOD:tools_install/install.gif'  => array($temp_eP.'icons/module_tools_install.png','width="24" height="24"'),
     69:         'MOD:tools_log/log.gif'  => array($temp_eP.'icons/module_tools_log.png','width="24" height="24"'),
     70:         'MOD:tools_txphpmyadmin/thirdparty_db.gif'  => array($temp_eP.'icons/module_tools_phpmyadmin.png','width="24" height="24"'),
     71:         'MOD:tools_isearch/isearch.gif' => array($temp_eP.'icons/module_tools_isearch.png','width="24" height="24"'),
     72:         'MOD:help/help.gif'  => array($temp_eP.'icons/module_help.png','width="23" height="24"'),
     73:         'MOD:help_about/info.gif'  => array($temp_eP.'icons/module_help_about.png','width="25" height="24"'),
     74:         'MOD:help_aboutmodules/aboutmodules.gif'  => array($temp_eP.'icons/module_help_aboutmodules.png','width="24" height="24"'),
     75:     ));
     76:         
     77:         // Adding icon for photomarathon extensions' backend module, if enabled:
     78:     if (t3lib_extMgm::isloaded('user_photomarathon'))    {
     79:         $TBE_STYLES['skinImg']['MOD:web_uphotomarathon/tab_icon.gif'] = array($temp_eP.'icons/ext/user_photomarathon/tab_icon.png','width="24" height="24"');
     80:     }
     81:         // Adding icon for templavoila extensions' backend module, if enabled:
     82:     if (t3lib_extMgm::isloaded('templavoila'))    {
     83:         $TBE_STYLES['skinImg']['MOD:web_txtemplavoilaM1/moduleicon.gif'] = array($temp_eP.'icons/ext/templavoila/mod1/moduleicon.png','width="24" height="24"');
     84:     }
     85: }

Notice the last lines from 77-84; they configures alternative icons
two extensions, “user\_photomarathon” (see testsite package) and
“templavoila”. Thus the skin can include skinning information for
other extensions.

When talking about skinning across extensions another way of making
sure that a skin also includes other extensions is shown in line 4
where any values set in $TBE\_STYLES['skinImg'] prior to this
extension is preserved. Thus other extensions can also autonomously
provide support for popular skins by themselves!

