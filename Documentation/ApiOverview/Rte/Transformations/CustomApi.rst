.. include:: /Includes.rst.txt


.. _transformations-custom:

==========================
Custom Transformations API
==========================

Instead of using the built-in transformations of TYPO3 you can program
your own. This is done by creating a PHP class with two methods for
transformation. Additionally you have to define a key (like
"css\_transform") for your transformation so you can refer to it in
the configuration of Rich Text Editors.


.. _transformations-custom-key:


Custom Transformation Key
=========================

You should pick a custom transformation key prefixed by :code:`tx_`,
something like :code:`tx_[extension key]_[suffix]`. The key must **not**
contain dashes (see :ref:`transformations-custom`).

.. note::

   If you pick one of the default transformation keys (except
   the meta-transformations) you will actually *override it* and your
   transformation will be called instead!


.. _transformations-custom-key-registration:

Registering the Transformation Key in the System
================================================

In :code:`ext_localconf.php`, simply set a :code:`$GLOBALS['TYPO3_CONF_VARS']` variable
to point to the class which contains the transformation methods::

   $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_parsehtml_proc.php']['transformation']['tx_examples_transformation']
      = 'Documentation\Examples\Service\RteTransformation';

Here the *transformation key* is defined to be :code:`tx_examples_transformation`
and the value is the fully qualified class name.

This class must contain two public methods, :code:`transform_db()` and
:code:`transform_rte()`.

It must also contain two public variables called by TYPO3 Core
(this is an old part, which doesn't use a proper API):

- :code:`$pObj` which will contain an instance of :code:`\TYPO3\CMS\Core\Html\RteHtmlParser`.

- :code:`$transformationKey` which should contain your transformation's key
  (in this case :code:`tx_examples_transformation`).


.. _transformations-custom-code:

Code Listing
============

This code listing shows a simple transformation. When content is
delivered to the RTE it will add a :code:`<hr/>` tag to the end of the
content. When the content is stored in the database any :code:`<hr/>` tag at
the end of the content will be removed and substituted with
whitespace. ::

   class RteTransformation {
      /**
       * NOTE: must be public as it is accessed by \TYPO3\CMS\Core\Html\RteHtmlParser without API
       *
       * @var \TYPO3\CMS\Core\Html\RteHtmlParser
       */
      public $pObj;

      /**
       * NOTE: must be public as it is accessed by \TYPO3\CMS\Core\Html\RteHtmlParser without API
       *
       * @var string
       */
      public $transformationKey = 'tx_examples_transformation';

      /**
       * @var array
       */
      protected $configuration;

      /**
       * Loads the transformation's configuration
       *
       * @return void
       */
      protected function loadConfiguration() {
         $this->configuration = $this->pObj->procOptions['usertrans.'][$this->transformationKey . '.'];
      }

      /**
       * Transforms RTE content prior to database storage
       *
       * @param string $value RTE HTML to clean for database storage
       * @return string
       */
      public function transform_db($value) {
         $this->loadConfiguration();

         if ($this->configuration['addHrulerInRTE'])    {
            $value = preg_replace('/<hr[[:space:]]*[\/]>[[:space:]]*$/i', '', $value);
         }

         return $value;
      }

      /**
       * Transforms database content for RTE display
       *
       * @param string $value Database content to transform into RTE-ready HTML
       * @return string
       */
      public function transform_rte($value) {
         $this->loadConfiguration();

         if ($this->configuration['addHrulerInRTE'])    {
            $value .= '<hr/>';
         }

         return $value;
      }
   }


- The transformation methods :code:`transform_rte` and :code:`transform_db` take
  a single argument which is the value to transform. They have to return
  that value again, modified as needed.

- Notice that both transformation functions call :code:`initConfig()` which uses
  the reference to the parser object to retrieve configuration related to the
  custom transformation.
