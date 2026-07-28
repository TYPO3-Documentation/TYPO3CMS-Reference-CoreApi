<?php

use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

class CommentRepository extends Repository
{
    public function findAllIgnoreEnableFields(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        return $query->execute();
    }
}
