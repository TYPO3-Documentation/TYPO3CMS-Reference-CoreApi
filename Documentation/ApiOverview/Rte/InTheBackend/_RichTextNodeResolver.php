<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Form\Resolver;

use MyVendor\MyExtension\Form\Element\RichTextElement;
use TYPO3\CMS\Backend\Form\NodeFactory;
use TYPO3\CMS\Backend\Form\NodeResolverInterface;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;

/**
 * This resolver will return the RichTextElement render class if RTE is enabled for this field.
 */
class RichTextNodeResolver implements NodeResolverInterface
{
    /**
     * Global options from NodeFactory
     */
    protected array $data;

    /**
     * Default constructor receives full data array
     */
    public function __construct(NodeFactory $nodeFactory, array $data)
    {
        $this->data = $data;
    }

    /**
     * Returns RichTextElement as class name if RTE widget should be rendered.
     *
     * @return string|null New class name or void if this resolver does not change current class name.
     */
    public function resolve(): string|null
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

    protected function getBackendUserAuthentication(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    public function setData(array $data): void
    {
        // TODO: Implement setData() method.
    }
}
