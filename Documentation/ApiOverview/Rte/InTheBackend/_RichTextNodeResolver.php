<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Form\Resolver;

use MyVendor\MyExtension\Form\Element\RichTextElement;
use TYPO3\CMS\Backend\Form\NodeResolverInterface;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;

/**
 * This resolver returns the RichTextElement render class if RTE is enabled
 * for this field.
 */
class RichTextNodeResolver implements NodeResolverInterface
{
  /**
   * Global options from NodeFactory
   */
  protected array $data;

  /**
   * The NodeFactory passes the full data array after creating the resolver
   */
  public function setData(array $data): void
  {
    $this->data = $data;
  }

  /**
   * Returns RichTextElement as class name if RTE widget should be rendered.
   *
   * @return string|null New class name or null if this resolver does not
   *                     change the current class name.
   */
  public function resolve(): string|null
  {
    $config = $this->data['parameterArray']['fieldConf']['config'];
    $backendUser = $this->getBackendUserAuthentication();
    if (// This field is not read only
      !$config['readOnly']
      // If RTE is generally enabled by user settings and RTE object
      // registry can return something valid
      && $backendUser->isRTE()
      // If RTE is enabled for field
      && isset($config['enableRichtext'])
      && (bool)$config['enableRichtext'] === true
      // If RTE config is found (prepared by TcaText data provider)
      && isset($config['richtextConfiguration'])
      && is_array($config['richtextConfiguration'])
      // If RTE is not disabled on configuration level
      && !$config['richtextConfiguration']['disabled']
    ) {
      return RichTextElement::class;
    }
    return null;
  }

  protected function getBackendUserAuthentication(): BackendUserAuthentication
  {
    return $GLOBALS['BE_USER'];
  }
}
