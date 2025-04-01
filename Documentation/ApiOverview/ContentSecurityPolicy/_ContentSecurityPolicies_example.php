<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Directive;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Mutation;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationCollection;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationMode;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Scope;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\UriValue;
use TYPO3\CMS\Core\Type\Map;

return Map::fromEntries([
    // Provide declarations for the backend only
    Scope::backend(),
    new MutationCollection(
        new Mutation(
            MutationMode::Extend,
            // Note: it's "FrameSrc" not "IFrameSrc"
            Directive::FrameSrc,
            new UriValue('https://cdn.example.com'),
        ),
        new Mutation(
            MutationMode::Extend,
            Directive::ImgSrc,
            new UriValue('https://cdn.example.com'),
        ),
        new Mutation(
            MutationMode::Extend,
            Directive::ScriptSrc,
            new UriValue('https://cdn.example.com'),
        ),
    ),
]);
