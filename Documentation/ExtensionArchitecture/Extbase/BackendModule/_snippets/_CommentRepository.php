<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use MyVendor\MyExtension\Domain\Model\Comment;
use TYPO3\CMS\Core\Context\LanguageAspect;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class CommentRepository extends Repository
{
  /**
   * @param LanguageAspect|null $languageAspect null lists all languages
   * @return QueryResultInterface<Comment>
   */
  public function findForModeration(
    ?LanguageAspect $languageAspect,
  ): QueryResultInterface {
    $query = $this->createQuery();
    $querySettings = $query->getQuerySettings();
    // Keep hidden comments in the list, so they can be shown again
    $querySettings->setIgnoreEnableFields(true);
    if ($languageAspect === null) {
      // Every comment once, in its own language
      $querySettings->setRespectSysLanguage(false);
    } else {
      $querySettings->setLanguageAspect($languageAspect);
    }
    // The model has no crdate property, the column is used directly
    $query->setOrderings(['crdate' => QueryInterface::ORDER_DESCENDING]);

    return $query->execute();
  }
}
