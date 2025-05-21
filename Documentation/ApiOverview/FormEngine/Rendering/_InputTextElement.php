<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\Form;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;

class InputTextElement extends AbstractFormElement
{
    /**
     * Default field information enabled for this element.
     *
     * @var array
     */
    protected $defaultFieldInformation = [
        'tcaDescription' => [
            'renderType' => 'tcaDescription',
        ],
    ];

    /**
     * Default field wizards enabled for this element.
     *
     * @var array
     */
    protected $defaultFieldWizard = [
        'localizationStateSelector' => [
            'renderType' => 'localizationStateSelector',
        ],
        'otherLanguageContent' => [
            'renderType' => 'otherLanguageContent',
            'after' => [
                'localizationStateSelector',
            ],
        ],
        'defaultLanguageDifferences' => [
            'renderType' => 'defaultLanguageDifferences',
            'after' => [
                'otherLanguageContent',
            ],
        ],
    ];

    public function render(): array
    {
        $resultArray = $this->initializeResultArray();

        $fieldInformationResult = $this->renderFieldInformation();
        $fieldInformationHtml = $fieldInformationResult['html'];

        $fieldControlResult = $this->renderFieldControl();
        $fieldControlHtml = $fieldControlResult['html'];

        $fieldWizardResult = $this->renderFieldWizard();
        $fieldWizardHtml = $fieldWizardResult['html'];

        $resultArray = $this->mergeChildReturnIntoExistingResult($resultArray, $fieldWizardResult, false);

        $mainFieldHtml = [];
        $mainFieldHtml[] = '<div class="form-control-wrap">';
        $mainFieldHtml[] =  '<div class="form-wizards-wrap">';
        $mainFieldHtml[] =      '<div class="form-wizards-item-element">';
        $mainFieldHtml[] =          '<input type="text"/>';
        $mainFieldHtml[] =      '</div>';

        // Add part for FieldControl between the label and the form element
        if (!empty($fieldControlHtml)) {
            $mainFieldHtml[] =      '<div class="form-wizards-item-aside form-wizards-item-aside--field-control">';
            $mainFieldHtml[] =          '<div class="btn-group">';
            $mainFieldHtml[] =              $fieldControlHtml;
            $mainFieldHtml[] =          '</div>';
            $mainFieldHtml[] =      '</div>';
        }

        // Add part for FieldWizards to the right of element node
        if (!empty($fieldWizardHtml)) {
            $mainFieldHtml[] = '<div class="form-wizards-item-bottom">';
            $mainFieldHtml[] = $fieldWizardHtml;
            $mainFieldHtml[] = '</div>';
        }

        $mainFieldHtml[] =  '</div>';
        $mainFieldHtml[] = '</div>';

        $fullElement = implode(LF, $mainFieldHtml);

        // Add part for FieldInformation to bottom of element node
        $resultArray['html'] = '
            <div class="formengine-field-item t3js-formengine-field-item">
                ' . $fieldInformationHtml . $fullElement . '
            </div>';

        return $resultArray;
    }
}
