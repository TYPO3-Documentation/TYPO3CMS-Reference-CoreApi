.. include:: ../../../Includes.txt


.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.


.. _xclasses-user-defined:

User-defined methods in classes
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Prefix user defined methods and internal variables with :code:`ux_`!
Thus you don't risk choosing a method name which may later be added to the
parent class in the TYPO3 distribution!

Example, continued from above:

.. code-block:: php
   :emphasize-lines: 2,4,13

   class ux_tslib_fe extends tslib_fe {
       var $ux_fLPmode = 1;    // If you "feelLuckyPunk" this is the no_cache value

     function ux_tslib_fe($TYPO3_CONF_VARS, $id, $type, $no_cache='', $cHash='', $jumpurl='') {
               // setting no_cache?
           $no_cache=$this->ux_settingNoCache();
               // Calling parent constructor:
           parent::tslib_fe($TYPO3_CONF_VARS, $id, $type, $no_cache, $cHash, $jumpurl);
     }
     /**
      * Setting the no_cache value based on user-input in GET/POST var, feelLuckyPunk
      */
     function ux_settingNoCache() {
         return t3lib_div::GPvar('feelLuckyPunk') ? $this->ux_fLPmode : 0;
     }
   }

User-defined methods and variables are highlighted.

