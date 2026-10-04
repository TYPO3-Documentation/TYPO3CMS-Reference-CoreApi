<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Preview;

use TYPO3\CMS\Backend\Preview\PreviewRendererInterface;
use TYPO3\CMS\Backend\Preview\RecordFieldPreviewProcessor;
use TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumnItem;

final readonly class ConferenceRenderer implements PreviewRendererInterface
{
  public function __construct(
    private RecordFieldPreviewProcessor $fieldProcessor,
  ) {}

  public function renderPageModulePreviewHeader(
    GridColumnItem $item,
  ): string {
    $record = $item->getRecord();
    $request = $item->getContext()->getCurrentRequest();
    $header = $this->fieldProcessor->prepareField($record, 'header');
    if ($header === null) {
      return '';
    }

    // The header links to the edit form of the record
    return $this->fieldProcessor->linkToEditForm(
      '<strong>' . $header . '</strong>',
      $record,
      $request,
    );
  }

  public function renderPageModulePreviewContent(
    GridColumnItem $item,
  ): string {
    $record = $item->getRecord();
    $parts = [
      $this->fieldProcessor->prepareFieldWithLabel($record, 'location'),
      $this->fieldProcessor->prepareText($record, 'bodytext', 500),
      $this->fieldProcessor->prepareFiles($record->get('media')),
    ];

    return implode('<br />', array_filter($parts));
  }

  public function renderPageModulePreviewFooter(
    GridColumnItem $item,
  ): string {
    return '';
  }

  public function wrapPageModulePreview(
    string $previewHeader,
    string $previewContent,
    GridColumnItem $item,
  ): string {
    return $previewHeader . $previewContent;
  }
}
