.. include:: /Includes.rst.txt
.. index::
   ! XCLASS
   Extending Classes
   Overwriting Methods
.. _xclasses:

============================
XCLASSes (Extending Classes)
============================


.. _xclasses-intro:

Introduction
============

XCLASSing is a mechanism in TYPO3 CMS to extend classes or overwrite methods from the Core or extensions
with one's own code. This enables a developer to easily change a given functionality,
if other options like :ref:`hooks <hooks>`, signals, :ref:`events <EventDispatcher>`
or the dependency injection mechanisms do not work or do not exist.

.. warning::

   Using XCLASSes is risky: Your XCLASS may break if the underlying
   code is changed. Preferably use events or hooks to extend class functionality.
   For other limitations see :ref:`XClass limitations <xclasses-limitations>`

If you need a hook or event that does not exist, feel free to submit
a feature request and - even better - a patch. Consult the
`TYPO3 Contribution Guide <https://docs.typo3.org/typo3cms/ContributionWorkflowGuide/>`__
about how to do this.


.. _xclasses-mechanism:

How does it work?
=================

In general every class instance in the Core and in extensions that stick to
the recommended :ref:`coding guidelines <cgl>` is created with the API call
:code:`\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance()`.
The methods takes care of singletons and also searches for existing XCLASSes.
If there is an XCLASS registered for the specific class that should be instantiated,
an instance of that XCLASS is returned instead of an instance of the original class.


.. index::
   single: XCLASS; limitations

.. _xclasses-limitations:

Limitations
===========

- Using XCLASSes is risky: neither the Core, nor extensions authors
  can guarantee that XCLASSes will not break if the underlying code changes
  (for example during upgrades). Be aware that your XCLASS can easily break
  and has to be maintained and fixed if the underlying code changes.
  If possible, you should use a hook instead of an XCLASS.

- XCLASSes do **not** work for static classes, static methods or final classes.

- There can be **only one** XCLASS per base class, but an XCLASS can be XCLASSed again.
  Be aware that such a construct is even more risky and definitely not advisable.

- A small number of Core classes are required very early during bootstrap
  before configuration and other things are loaded. XCLASSing those classes will fail if they are singletons
  or might have unexpected side-effects.

.. index::
   single: XCLASS; declaration

.. _xclasses-declaration:

Declaration
===========

The :code:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']` global array acts as a registry
of overloaded (XCLASSed) classes.

The syntax is as follows and is commonly located in an extension's :file:`ext_localconf.php` file::

       $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][TYPO3\CMS\Backend\Controller\NewRecordController::class] = [
          'className' => Documentation\Examples\Xclass\NewRecordController::class
       ];


In this example, we declare that the :code:`\TYPO3\CMS\Backend\Controller\NewRecordController` class
will be overridden by the :code:`\T3docs\Examples\Xclass\NewRecordController`
class, the latter being part of the
`"examples" extension <https://extensions.typo3.org/extension/examples/>`__ .

When XCLASSing a class that does not use namespaces, simply use that class' name
in the declaration.


.. _xclasses-coding:

Coding practices
================

The recommended way of writing an XCLASS is to **extend** the original class and
overwrite only the methods where a change is needed. This lowers the chances of the
XCLASS breaking after a code update.

.. tip::

   You're even safer if you can do your changes before or after the parent method
   and just call the latter with :code:`parent::`.

The example below extends the new record wizard screen. It first calls the original
method and then adds its own content::

   class NewRecordController extends \TYPO3\CMS\Backend\Controller\NewRecordController
   {
       protected function renderNewRecordControls(ServerRequestInterface $request): void
       {
           parent::renderNewRecordControls($request);
           $ll = 'LLL:EXT:examples/Resources/Private/Language/locallang.xlf'
           $label = $GLOBALS['LANG']->sL($ll . ':help');
           $text = $GLOBALS['LANG']->sL($ll . ':make_choice');
           $str = '<div><h2 class="uppercase" >' .  htmlspecialchars($label)
               . '</h2>' . $text . '</div>';
           $this->code .= $str;
       }
   }

The result can be seen here:

.. figure:: /Images/ManualScreenshots/Xclasses/XclassNewElementWizard.png
   :alt: Adding an element to the new record wizard

   A help section is added at the bottom of the new record wizard.

The object oriented rules of PHP 7 such as rules about visibility apply here.
As you are extending the original Class you can overload or call methods
marked as public and protected but not private or static ones. Read more about
`visibility and inheritance at php.net <https://www.php.net/manual/en/language.oop5.visibility.php>`__
