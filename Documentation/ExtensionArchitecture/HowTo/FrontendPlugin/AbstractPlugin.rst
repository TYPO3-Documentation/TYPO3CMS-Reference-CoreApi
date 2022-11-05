:orphan:

=========================
AbstractPlugin (internal)
=========================

..  versionchanged:: 12.0
    :php:`\TYPO3\CMS\Frontend\Plugin\AbstractPlugin` has been marked as
    :php:`@internal`.

Extending the class :php:`\TYPO3\CMS\Frontend\Plugin\AbstractPlugin` is not a
recommended way of developing Frontend plugins anymore. This class is not
maintained anymore and may be removed in future versions without further notice.

Migration
=========

Remove the dependency of :php:`\TYPO3\CMS\Frontend\Plugin\AbstractPlugin`. If
functionality of this class is still used, copy it into your plugin.

Example
-------

Class before migration:

..  code-block:: php
    :caption: EXT:gh_randomcontent/Classes/Plugin/RandomContent.php

    class RandomContent extends AbstractPlugin
    {
        public function main(string $content, array $conf) : string
        {
            $this->conf = $conf;

            $this->pi_initPIflexForm(); // Init FlexForm configuration for plugin
            if ($this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'which_pages', 'sDEF')) {
                $this->conf['pages'] = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'which_pages', 'sDEF');
            }
            // ...
        }
    }

Class after migration:

..  code-block:: php
    :caption: EXT:gh_randomcontent/Classes/Plugin/RandomContent.php

    class RandomContent
    {
        /**
         * The back-reference to the mother cObj object set at call time
         */
        public $cObj;

        /**
         * This setter is called when the plugin is called from UserContentObject (USER)
         * via ContentObjectRenderer->callUserFunction().
         *
         * @param ContentObjectRenderer $cObj
         */
        public function setContentObjectRenderer(ContentObjectRenderer $cObj): void
        {
            $this->cObj = $cObj;
        }

        public function main(string $content, array $conf) : string
        {
             $this->conf = $conf;

            $this->pi_initPIflexForm(); // Init FlexForm configuration for plugin
            if ($this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'which_pages', 'sDEF')) {
                $this->conf['pages'] = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'which_pages', 'sDEF');
            }
            // ...
        }

        /**
         * Converts $this->cObj->data['pi_flexform'] from XML string to flexForm array.
         *
         * @param string $field Field name to convert
         */
        public function pi_initPIflexForm($field = 'pi_flexform')
        {
            // ...
        }

        public function pi_getFFvalue($T3FlexForm_array, $fieldName, $sheet = 'sDEF', $lang = 'lDEF', $value = 'vDEF')
        {
            // ...
        }

    }

It is also possible to migrate to an Extbase plugin using a controller.
See the :ref:`Extbase frontend plugins <extbase_registration_of_frontend_plugins>`.
