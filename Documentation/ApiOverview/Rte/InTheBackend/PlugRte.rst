.. include:: ../../../Includes.txt


.. _rte-plug:

==============
Plugging a RTE
==============


TYPO3 supports any Rich Text Editor for which someone might write a
connector to the RTE API. This means that you can freely choose
whatever RTE you want to use among those available from the Extension
Repository on typo3.org.

TYPO3 comes with a built-in RTE called "ckeditor", but other RTEs
are available in the TYPO3 Extension Repository and you can implement your
own RTE if you like.


.. _rte-api:

API for Rich Text Editors
=========================

Connecting an RTE in an extension to TYPO3 is easy. The following example is
based on the implementation of ext:rte_ckeditor.

- In the :file:`ext_localconf.php` you can use the FormEngine's NodeResolver
  to implement your own RichTextNodeResolver and give it a higher priority
  than the core's implementation:

.. code-block:: php

   $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeResolver'][1593194137] = [
       'nodeName' => 'text',
       'priority' => 50, // rte_ckeditor uses priority 50
       'class' => \Vendor\MyExt\Form\Resolver\RichTextNodeResolver::class,
   ];

- Now create the class :code:`\Vendor\MyExt\Form\Resolver\RichTextNodeResolver`.
  The RichTextNodeResolver needs to implement the NodeResolverInterface and
  the major parts happen in the resolve() function, where, if all conditions
  are met, the RichTextElement class name is returned:

.. code-block:: php

   <?php

   namespace Vendor\MyExt\Form\Resolver;

   use TYPO3\CMS\Backend\Form\NodeFactory;
   use TYPO3\CMS\Backend\Form\NodeResolverInterface;
   use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
   use Vendor\MyExt\Form\Element\RichTextElement;

   /**
    * This resolver will return the RichTextElement render class if RTE is enabled for this field.
    */
   class RichTextNodeResolver implements NodeResolverInterface
   {
       /**
        * Global options from NodeFactory
        *
        * @var array
        */
       protected $data;

       /**
        * Default constructor receives full data array
        *
        * @param NodeFactory $nodeFactory
        * @param array $data
        */
       public function __construct(NodeFactory $nodeFactory, array $data)
       {
           $this->data = $data;
       }

       /**
        * Returns RichTextElement as class name if RTE widget should be rendered.
        *
        * @return string|void New class name or void if this resolver does not change current class name.
        */
       public function resolve()
       {
           $parameterArray = $this->data['parameterArray'];
           $backendUser = $this->getBackendUserAuthentication();
           if (// This field is not read only
               !$parameterArray['fieldConf']['config']['readOnly']
               // If RTE is generally enabled by user settings and RTE object registry can return something valid
               && $backendUser->isRTE()
               // If RTE is enabled for field
               && isset($parameterArray['fieldConf']['config']['enableRichtext'])
               && (bool)$parameterArray['fieldConf']['config']['enableRichtext'] === true
               // If RTE config is found (prepared by TcaText data provider)
               && isset($parameterArray['fieldConf']['config']['richtextConfiguration'])
               && is_array($parameterArray['fieldConf']['config']['richtextConfiguration'])
               // If RTE is not disabled on configuration level
               && !$parameterArray['fieldConf']['config']['richtextConfiguration']['disabled']
           ) {
               return RichTextElement::class;
           }
           return null;
       }

       /**
        * @return BackendUserAuthentication
        */
       protected function getBackendUserAuthentication()
       {
           return $GLOBALS['BE_USER'];
       }
   }

- Next step is to implement the RichtTextElement class. You can look up the
  code of `\\TYPO3\\CMS\\RteCKEditor\\Form\\Element\\RichTextElement <https://github.com/TYPO3/TYPO3.CMS/blob/master/typo3/sysext/rte_ckeditor/Classes/Form/Element/RichTextElement.php>`__, which
  does the same for ckeditor. What basically happens in its render() function,
  is to apply any settings from the fields TCA config and then printing out all
  of the html markup and javascript necessary for booting up the ckeditor.
