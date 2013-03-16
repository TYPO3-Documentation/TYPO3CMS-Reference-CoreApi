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
  the system class, :code:`\TYPO3\CMS\Backend\Rte\AbstractRte`
  and override functions from the parent class to the degree
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


RTE API class
"""""""""""""

In the base class for the RTE API (:code:`\TYPO3\CMS\Backend\Rte\AbstractRte`)
there are three main methods of interest:

- **function isAvailable()** This method is asked for the availability
  of the RTE; This is where you should check for environmental
  requirements that is needed for your RTE. Basically the method must
  return TRUE if the RTE is available. If it is not, the RTE can put
  text entries in the internal array ->errorLog which is used to report
  back the reason why it was not available.

- **function drawRTE(&$pObj,$table,$field,$row,$PA,$specConf,$thisConfig
  ,$RTEtypeVal,$RTErelPath,$thePidValue)** This method draws the content
  for the editing form of the RTE. It is called from the
  :code:`\TYPO3\CMS\Backend\Form\FormEngine` class which also passes a reference to itself in
  $pObj. For details on the arguments in the method call, please see
  inside :code:`\TYPO3\CMS\Backend\Rte\AbstractRte`.

- **function transformContent($dirRTE,$value,$table,$field,$row,$specCon
  f,$thisConfig,$RTErelPath,$pid)** This method is used both from
  ->drawRTE() and from :code:`\TYPO3\CMS\Core\DataHandling\DataHandler` to transform the content between
  the database and RTE. When content is loaded from the database to the
  RTE (and vice versa) it may need some degree of transformation. For
  instance references to links and images in the database might have to
  be relative while the RTE requires absolute references. This is just a
  simple example of what "transformations" can do for you and why you
  need them. There are plenty of details on this topic later.
