<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Xclass;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Controller\NewRecordController as CoreNewRecordController;

class NewRecordController extends CoreNewRecordController
{
  protected function renderNewRecordControls(
    ServerRequestInterface $request,
  ): void {
    parent::renderNewRecordControls($request);
    $languageDomain = 'my_extension:messages';
    $label = $GLOBALS['LANG']->translate('help', $languageDomain);
    $text = $GLOBALS['LANG']->label('make_choice', $languageDomain);
    $str = '<div><h2 class="uppercase" >' . htmlspecialchars($label)
        . '</h2>' . $text . '</div>';
    $this->code .= $str;
  }
}
