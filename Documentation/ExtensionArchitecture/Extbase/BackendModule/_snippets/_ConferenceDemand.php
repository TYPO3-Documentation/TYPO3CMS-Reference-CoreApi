<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

final readonly class ConferenceDemand
{
  public const STATUS_PUBLISHED = 'published';
  public const STATUS_UNPUBLISHED = 'unpublished';

  public function __construct(
    public string $searchWord = '',
    public string $status = '',
  ) {}

  public static function fromArray(array $data): self
  {
    return new self(
      (string)($data['searchWord'] ?? ''),
      (string)($data['status'] ?? ''),
    );
  }

  public function toArray(): array
  {
    return [
      'searchWord' => $this->searchWord,
      'status' => $this->status,
    ];
  }
}
