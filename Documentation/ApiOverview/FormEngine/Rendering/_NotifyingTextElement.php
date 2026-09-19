<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\Form;

use MyVendor\MyExtension\Backend\Form\Behavior\NotifyOnFieldChange;
use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class NotifyingTextElement extends AbstractFormElement
{
  public function render(): array
  {
    $resultArray = $this->initializeResultArray();
    $parameterArray = $this->data['parameterArray'];

    // Keep the behavior the Core added, for example marking
    // the field as changed, and add an own one
    $fieldChangeFunc = $parameterArray['fieldChangeFunc'] ?? [];
    $fieldChangeFunc['myExtensionNotify'] = new NotifyOnFieldChange(
      'Title changed',
      'Remember to update the teaser as well.',
    );

    $attributes = [
      'type' => 'text',
      'class' => 'form-control',
      'name' => $parameterArray['itemFormElName'],
      'value' => (string)$parameterArray['itemFormElValue'],
      // Renders the behaviors as data attributes for FormEngine
      ...$this->getOnFieldChangeAttrs('change', $fieldChangeFunc),
    ];
    $resultArray['html'] =
        '<input ' . GeneralUtility::implodeAttributes($attributes, true) . '>';

    $resultArray['javaScriptModules'][] = JavaScriptModuleInstruction::create(
      '@my-vendor/my-extension/notify-on-field-change.js',
    );
    return $resultArray;
  }
}
