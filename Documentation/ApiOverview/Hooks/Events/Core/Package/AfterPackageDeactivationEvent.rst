.. include:: ../../../../../Includes.txt


.. _AfterPackageDeactivationEvent:


=============================
AfterPackageDeactivationEvent
=============================

.. versionadded:: 10.3

Event that is triggered after a package has been deactivated.


API
---

 - :Method:
         getPackageKey()
   :Description:
         Returns the package key.
   :ReturnType:
         string

 - :Method:
         getType()
   :Description:
         Returns the package type (usually `typo3-cms-extension`)
   :ReturnType:
         string


 - :Method:
         getEmitter()
   :Description:
         Returns the emitter triggering the installation (usually :php:`InstallUtility`)
   :ReturnType:
         object


