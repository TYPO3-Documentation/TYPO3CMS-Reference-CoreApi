<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\Attribute\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Comment extends AbstractEntity
{
  protected string $author = '';

  #[Validate(validator: 'NotEmpty')]
  protected string $text = '';

  // No setter: Core's visibility toggle writes it
  protected bool $hidden = false;

  protected ?Comment $replyTo = null;

  public function getAuthor(): string
  {
    return $this->author;
  }

  public function setAuthor(string $author): void
  {
    $this->author = $author;
  }

  public function getText(): string
  {
    return $this->text;
  }

  public function setText(string $text): void
  {
    $this->text = $text;
  }

  public function isHidden(): bool
  {
    return $this->hidden;
  }

  public function getReplyTo(): ?Comment
  {
    return $this->replyTo;
  }

  public function setReplyTo(?Comment $replyTo): void
  {
    $this->replyTo = $replyTo;
  }
}
