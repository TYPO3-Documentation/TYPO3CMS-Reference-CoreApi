.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt


.. _rte-plug:

Plugging a RTE
^^^^^^^^^^^^^^

.. attention:: This page needs an update!

   `Issue #78 <https://github.com/TYPO3-Documentation/TYPO3CMS-Reference-CoreApi/issues/78>`_
   states that this contents needs an update. It says:
     
      The documentation of "Plugging a RTE" seems to be deprecated since TYPO3 CMS 7.4.
      RTE registration isn't made via :php:`$GLOBALS['TYPO3_CONF_VARS']['BE']['RTE_reg']` anymore.
      Instead the NodeFactory API is used.

TYPO3 supports any Rich Text Editor for which someone might write a
connector to the RTE API. This means that you can freely choose
whatever RTE you want to use among those available from the Extension
Repository on typo3.org.

TYPO3 comes with a built-in RTE called "rtehtmlarea", but other RTEs
are available in the TYPO3 Extension Repository.

You can enable more than one RTE if you like but only one will be
active at a time. Since Rich Text Editors often depend on browser
versions, operating systems etc. each RTE must have a method in the
API class which reports back to the system if the RTE is available in
the current environment. The Rich Text Editor available to the backend
user will be the *first loaded* RTE which reports back to TYPO3 that
it *is available* in the environment. If the RTE is not available,
the next RTE Extension loaded will be asked.


.. _rte-api:

API for Rich Text Editors
^^^^^^^^^^^^^^^^^^^^^^^^^

Connecting an RTE in an extension to TYPO3 is easy.

- Create a class file in your extension that extends
  the system class, :code:`\TYPO3\CMS\Backend\Rte\AbstractRte`
  and override functions from the parent class to the degree
  needed.

- In the :file:`ext_localconf.php` file put an entry in
  :code:`$TYPO3_CONF_VARS['BE']['RTE_reg']` which registers the new RTE with
  the system. For example::

     $TYPO3_CONF_VARS['BE']['RTE_reg']['myrte'] = array(
     	'objRef' => 'Foo\\MyRte\\Editors\\RteBase');

where the value of :code:`objRef` is the fully qualified name
of the class you declared in the first step.

There are three main methods of interest in the base class
for the RTE API (:code:`\TYPO3\CMS\Backend\Rte\AbstractRte`):

- :code:`isAvailable()` This method is asked for the availability
  of the RTE. This is where you should check for environmental
  requirements that is needed for your RTE. Basically the method must
  return TRUE if the RTE is available. If it is not, the RTE can put
  text entries in the internal array :code:`->errorLog` which is used to report
  back the reason why it was not available.

- :code:`drawRTE(&$pObj, $table, $field, $row, $PA, $specConf, $thisConfig, $RTEtypeVal, $RTErelPath, $thePidValue)`
  This method draws the content for the editing form of the RTE. It is called from the
  :code:`\TYPO3\CMS\Backend\Form\FormEngine` class which also passes a reference to itself in
  :code:`$pObj`. For details on the arguments in the method call, please see
  inside :code:`\TYPO3\CMS\Backend\Rte\AbstractRte`.

- :code:`transformContent($dirRTE, $value, $table, $field, $row, $specConf, $thisConfig, $RTErelPath,$pid)`
  This method is used both from :code:`->drawRTE()` and from
  :code:`\TYPO3\CMS\Core\DataHandling\DataHandler` to transform the content between
  the database and RTE. When content is loaded from the database to the
  RTE (and vice versa) it may need some degree of transformation. For
  instance references to links and images in the database might have to
  be relative while the RTE requires absolute references. This is just a
  simple example of what "transformations" can do for you and why you
  need them. See the next chapter for more details about :ref:`transformations <transformations>`.
