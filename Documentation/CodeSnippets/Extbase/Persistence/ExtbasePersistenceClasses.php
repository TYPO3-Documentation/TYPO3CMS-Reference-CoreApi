<?php

declare(strict_types=1);

use T3docs\BlogExample\Domain\Model\Administrator;
use T3docs\BlogExample\Domain\Model\Blog;
use T3docs\BlogExample\Domain\Model\FrontendUserGroup;
use T3docs\BlogExample\Domain\Model\Post;

return [
    Administrator::class => [
        'tableName' => 'fe_users',
        'recordType' => Administrator::class,
        'properties' => [
            'administratorName' => [
                'fieldName' => 'username',
            ],
        ],
    ],
    FrontendUserGroup::class => [
        'tableName' => 'fe_groups',
    ],
    Blog::class => [
        'tableName' => 'tx_blogexample_domain_model_blog',
        'properties' => [
            'categories' => [
                'fieldName' => 'category',
            ],
        ],
    ],
    Post::class => [
        'tableName' => 'tx_blogexample_domain_model_post',
        'properties' => [
            'categories' => [
                'fieldName' => 'category',
            ],
        ],
    ],
];
