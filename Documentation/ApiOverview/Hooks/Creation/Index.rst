.. include:: ../../../Includes.txt


.. _hooks-creation:

==============
Creating Hooks
==============

You are encouraged to create hooks in your extensions if they seem
meaningful. Typically someone would request a hook somewhere. Before
you implement it, consider if it is the right place to put it etc. On
the one hand we want to have many hooks but not more than needed.
Redundant hooks or hooks which are implemented in the wrong context is
just confusing. So put a little thought into it first, but be
generous.

There are two main methods of calling a user defined function in
TYPO3.

- :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction()` - The classic way. Takes a
  file/class/method reference as value and calls that function. The
  argument list is fixed to a parameter array and a parent object. So
  this is the limitation. The freedom is that the reference defines the
  function name to call. This method is mostly useful for small-scale
  hooks in the sources.

- :php:`\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance()` - Create an
  object from a user defined
  file/class. The method called in the object is fixed by the hook, so
  this is the non-flexible part. But it is cleaner in other ways, in
  particular that you can even call many methods in the object and you
  can pass an arbitrary argument list which makes the API more
  beautiful. You can also define the objects to be singletons,
  instantiated only once in the global scope.

Here follows some examples.


.. _hooks-creation-object:

Using \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance()
============================================================

Data submission to extensions::

   // Hook for processing data submission to extensions
   foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']
         ['checkDataSubmission'] ?? [] as $className) {
      $_procObj = GeneralUtility::makeInstance($className);
      $_procObj->checkDataSubmission($this);
   }


.. _hooks-creation-function:

Using with \TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction()
=====================================================================

Constructor post-processing::

      // Call post-processing function for constructor:
   if (is_array($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['tslib_fe-PostProc'])) {
      $_params = array('pObj' => &$this);
      foreach($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['tslib_fe-PostProc'] as $_funcRef) {
         \TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction($_funcRef,$_params, $this);
      }
   }

