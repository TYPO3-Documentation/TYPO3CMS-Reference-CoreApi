<?php

declare(strict_types=1);
namespace MyVendor\MyExtension\Backend\Form;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;

final class InputTextElement extends AbstractFormElement
{
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

    public function render()
    {
        $resultArray = $this->initializeResultArray();

        $fieldWizardResult = $this->renderFieldWizard();
        $fieldWizardHtml = $fieldWizardResult['html'];
        $resultArray = $this->mergeChildReturnIntoExistingResult($resultArray, $fieldWizardResult, false);

        $mainFieldHtml = [];
        $mainFieldHtml[] = '<div class="form-control-wrap">';
        $mainFieldHtml[] =  '<div class="form-wizards-wrap">';
        $mainFieldHtml[] =      '<div class="form-wizards-element">';
        // Main HTML of element done here ...
        $mainFieldHtml[] =      '</div>';
        $mainFieldHtml[] =      '<div class="form-wizards-items-bottom">';
        $mainFieldHtml[] =          $fieldWizardHtml;
        $mainFieldHtml[] =      '</div>';
        $mainFieldHtml[] =  '</div>';
        $mainFieldHtml[] = '</div>';

        $resultArray['html'] = implode(LF, $mainFieldHtml);
        return $resultArray;
    }
}
