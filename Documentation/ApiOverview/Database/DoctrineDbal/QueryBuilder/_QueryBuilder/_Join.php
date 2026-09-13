<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use Doctrine\DBAL\Result;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

final readonly class MyDbalRepository
{
  public function __construct(
    private ConnectionPool $connectionPool,
  ) {}

  public function findLanguagesOfPage(): Result
  {
    // SELECT `sys_language`.`uid`, `sys_language`.`title`
    // FROM `sys_language`
    // INNER JOIN `pages` `p`
    //     ON `p`.`sys_language_uid` = `sys_language`.`uid`
    // WHERE
    //     (`p`.`uid` = 42)
    //     AND (
    //          (`p`.`deleted` = 0)
    //          AND (
    //              (`sys_language`.`hidden` = 0)
    //              AND (`overlay`.`hidden` = 0)
    //          )
    //          AND (`p`.`starttime` <= 1475591280)
    //          AND ((`p`.`endtime` = 0)
    //               OR (`overlay`.`endtime` > 1475591280))
    //     )
    $queryBuilder = $this->connectionPool
        ->getQueryBuilderForTable('sys_language');
    return $queryBuilder
        ->select('sys_language.uid', 'sys_language.title')
        ->from('sys_language')
        ->join(
          'sys_language',
          'pages',
          'p',
          $queryBuilder->expr()->eq(
            'p.sys_language_uid',
            $queryBuilder->quoteIdentifier('sys_language.uid'),
          ),
        )
        ->where(
          $queryBuilder->expr()->eq(
            'p.uid',
            $queryBuilder->createNamedParameter(
              42,
              Connection::PARAM_INT,
            ),
          ),
        )
        ->executeQuery();
  }
}
