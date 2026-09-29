<?php

namespace MyVendor\MyExtension\Domain\Model;

final class ConferenceDemand
{
  public const STATUS_PUBLISHED = 'published';
  public const STATUS_UNPUBLISHED = 'unpublished';

  public function __construct(
    public readonly string $searchWord = '',
    public readonly string $status = '',
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
