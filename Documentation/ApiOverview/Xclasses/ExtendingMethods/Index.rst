.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../../Includes.txt






.. _xclasses-methods:

Extending methods
^^^^^^^^^^^^^^^^^

When extending a method like in the case above with stdWrap() please
observe that such a method might gain new parameters in the future
without further notice. For instance stdWrap is currently defined like
this::

      function stdWrap($content, $conf) {

... but maybe some day this method will have another parameter added,
e.g.::

      function stdWrap($content, $conf, $yet_a_parameter=0) {

This means if you want to override stdWrap(), but still call the
parent class' method, you must extend your own method call from...::

       function stdWrap($content, $conf) {
               // Call the real stdWrap method in the parent class:
           $content = parent::stdWrap($content, $conf);
           ...

... to::

       function stdWrap($content, $conf, $yet_a_parameter=0) {
               // Call the real stdWrap method in the parent class:
           $content = parent::stdWrap($content, $conf,$ yet_a_parameter);
           ...


Also be aware of constructors. If you have a constructor in your
extension class you must observe if there is a constructor in the
parent class which you should call first / after. In case, you can do
it by "parent::[original class name]"

For instance the class :code:`\TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController` is instantiated into the global
object $TSFE. This class has a constructor looking like this::

	public function __construct($TYPO3_CONF_VARS, $id, $type, $no_cache = '', $cHash = '', $jumpurl = '', $MP = '', $RDCT = '') {
		// Setting some variables:
		$this->TYPO3_CONF_VARS = $TYPO3_CONF_VARS;
		$this->id = $id;
		$this->type = $type;
		if ($no_cache) {
			if ($this->TYPO3_CONF_VARS['FE']['disableNoCacheParameter']) {
				$warning = '&no_cache=1 has been ignored because $TYPO3_CONF_VARS[\'FE\'][\'disableNoCacheParameter\'] is set!';
				$GLOBALS['TT']->setTSlogMessage($warning, 2);
			} else {
				$warning = '&no_cache=1 has been supplied, so caching is disabled! URL: "' . \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL') . '"';
				$this->disableCache();
			}
			\TYPO3\CMS\Core\Utility\GeneralUtility::sysLog($warning, 'cms', \TYPO3\CMS\Core\Utility\GeneralUtility::SYSLOG_SEVERITY_WARNING);
		}
		$this->cHash = $cHash;
		$this->jumpurl = $jumpurl;
		$this->MP = $this->TYPO3_CONF_VARS['FE']['enable_mount_pids'] ? (string) $MP : '';
		$this->RDCT = $RDCT;
		$this->clientInfo = \TYPO3\CMS\Core\Utility\GeneralUtility::clientInfo();
		$this->uniqueString = md5(microtime());
		$this->csConvObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Charset\\CharsetConverter');
		// Call post processing function for constructor:
		if (is_array($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['tslib_fe-PostProc'])) {
			$_params = array('pObj' => &$this);
			foreach ($this->TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['tslib_fe-PostProc'] as $_funcRef) {
				\TYPO3\CMS\Core\Utility\GeneralUtility::callUserFunction($_funcRef, $_params, $this);
			}
		}
		$this->cacheHash = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Page\\CacheHashCalculator');
		$this->initCaches();
	}

So as you see, you probably want to call this method. But let's also
say you wish to make sure the :code:`$no_cache` parameter is always set to 1
(for some strange reason...). So you make an extension class like this
with a new constructor, :code:`ux_tslib_fe()`, overriding the :code:`$no_cache`
variable and then calling the parent class constructor::

   class ux_tslib_fe extends \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController {
	public function __construct($TYPO3_CONF_VARS, $id, $type, $no_cache = '', $cHash = '', $jumpurl = '', $MP = '', $RDCT = '') {
        $no_cache = 1;
        parent::__construct($TYPO3_CONF_VARS, $id, $type, $no_cache, $cHash, $jumpurl, $MP, $RDCT);
    }
   }

.. important::
   The above code is a bad example, because setting the :code:`$no_cache`
   parameter to 1 is an evil thing to do. This code should be replaced at some point.

