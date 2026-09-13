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

    public function findByDistance(): Result
    {
        // SELECT `uid`,
        //    6371.41 * ACOS(COS(RADIANS(:dcValue1))
        //    * COS(RADIANS(tx_geosearch_lat))
        //    * COS(RADIANS(tx_geosearch_lng) - RADIANS(:dcValue2))
        //    + SIN(RADIANS(:dcValue3))
        //    * SIN(RADIANS(tx_geosearch_lat))) AS distance
        //    FROM `tt_address`
        $lat = '51.2442656';
        $lng = '6.7374966';
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('tt_address');
        $latParameter = $queryBuilder
            ->createNamedParameter($lat, Connection::PARAM_STR);
        $lngParameter = $queryBuilder
            ->createNamedParameter($lng, Connection::PARAM_STR);
        return $queryBuilder
            ->select('uid')
            ->addSelectLiteral('
                6371.41 * ACOS(
                    COS(
                        RADIANS(' . $latParameter . ')
                    ) * COS(
                        RADIANS(tx_geosearch_lat)
                    ) * COS(
                        RADIANS(tx_geosearch_lng)
                        - RADIANS(' . $lngParameter . ')
                    ) + SIN(
                        RADIANS(' . $latParameter . ')
                    ) * SIN(
                        RADIANS(tx_geosearch_lat)
                    )
                ) AS distance
            ')
            ->from('tt_address')
            ->executeQuery();
    }
}
