

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


File structure
^^^^^^^^^^^^^^

TYPO3 files use the following structure:

#. Opening PHP tag

#. Copyright notice

#. File information block (with optional function index) in phpDoc format

#. Included files

#. Class information block in phpDoc format

#. PHP class

#. XCLASS declaration

#. Optional module execution code (for example, in eID classes)

#. Closing PHP tag

The following sections discuss each of these parts.


Copyright notice
""""""""""""""""

TYPO3 is released under the terms of GNU General Public License
version 2 or any later version. The copyright notice with a reference
to the GPL must be included at the top of every TYPO3 PHP class file.
user\_files must have this copyright notice as well. Example:

::

   <?php
   /***************************************************************
   *  Copyright notice
   *
   *  (c) YYYY Your name here (your@email.here)
   *  All rights reserved
   *
   *  This script is part of the TYPO3 project. The TYPO3 project is
   *  free software; you can redistribute it and/or modify
   *  it under the terms of the GNU General Public License as published by
   *  the Free Software Foundation; either version 2 of the License, or
   *  (at your option) any later version.
   *
   *  The GNU General Public License can be found at
   *  http://www.gnu.org/copyleft/gpl.html.
   *  A copy is found in the textfile GPL.txt and important notices to the license
   *  from the author is found in LICENSE.txt distributed with these scripts.
   *
   *
   *  This script is distributed in the hope that it will be useful,
   *  but WITHOUT ANY WARRANTY; without even the implied warranty of
   *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   *  GNU General Public License for more details.
   *
   *  This copyright notice MUST APPEAR in all copies of the script!
   ***************************************************************/

This notice may not be altered except for the year, author name and
author e-mail.


File information block
""""""""""""""""""""""

File information block follows the copyright statement and provides
basic information about the file. It should include file name,
description of the file and information about the author (or authors).
Example:

::

   /**
    * class.tx_myext_pi1.php
    *
    * Provides XYZ plugin implementation.
    *
    * @author John Doe <john.doe@example.com>
    */

The file information block can also contain the optional function
index. This index is created and updated by the extdevevalextension.


Included files
""""""""""""""

Files are included using require\_oncefunction. All TYPO3 files must
use absolute paths in calls to require\_once. There are two ways to
obtain the path to the included file:

#. Use one of the predefined TYPO3 constants: PATH\_tslib, PATH\_t3lib,
   PATH\_typo3, PATH\_site. The first three contain absolute paths to the
   corresponding TYPO3 directories. The last constant contains absolute
   path to the TYPO3 root directory. Example:

::

   require_once(PATH_tslib . 'class.tslib_pibase.php');
   

#. Use t3lib\_extMgm::extPath()function. This function accepts two
   arguments: extension key and path to the included file. The second
   argument is optional but recommended to use. Examples:

::

   require_once(t3lib_extMgm::extPath('lang', 'lang.php'));
   require_once(t3lib_extMgm::extPath('lang') . 'lang.php');

Always use one of these two ways to include files. This is required to
include files even from the current directory. Some installations do
not have the current directory in the PHP include path and
require\_oncewithout a proper path will result in fatal PHP error.


Class information block
"""""""""""""""""""""""

Class information block is similar to the file information block and
describes the class in the file. Example:

::

   /**
    * This class provides XYZ plugin implementation.
    *
    * @author John Doe <john.doe@example.com>
    * @author Jane Doe <jane.doe@example.com>
    */


PHP class
"""""""""

PHP class follows the Class information block. PHP code must be
formatted as described in chapter “PHP syntax formatting” on page 13.

The class name is expected to follow some conventions. The namespace
and path parts (see “Namespaces” on page 8) are all lowercase and
separated by underscores (“\_”). At the end comes the “true” class
name which must be written in upper camel case.

Taking again the example of file
class.t3lib\_cache\_backend\_abstractbackend.php, the PHP class
declaration will look like:

::

   class t3lib_cache_backend_AbstractBackend {
           …
   }


XCLASS declaration
""""""""""""""""""

The XCLASS declaration must follow the PHP class. The format of the
XCLASS is very important. Please follow the example below, otherwise
the TYPO3 Extension Manager will complain about a missing XCLASS
declaration.

The XCLASS declaration must include proper path to the current class
file. The following example assumes that extension key is myext, file
name is class.tx\_myext\_pi1.phpand file is located in the
pi1subdirectory of the extension:

::

   if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/myext/pi1/class.tx_myext_pi1.php'])) {
           include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/myext/pi1/class.tx_myext_pi1.php']);
   }


Optional module execution code
""""""""""""""""""""""""""""""

Module execution code instantiates the class and runs its method(s).
Typically this code can be found in eID scripts and old Backend
modules. Here is how it may look like:

::

   $controller = t3lib_div::makeInstance('tx_myext_ajaxcontroller');
   $controller->main();

This code must appear  **after** the XCLASS declaration. $SOBEis
traditional but not required name.

