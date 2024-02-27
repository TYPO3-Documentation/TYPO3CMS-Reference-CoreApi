<?php

use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Directive;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Policy;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\SourceKeyword;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\SourceScheme;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\UriValue;
use TYPO3\CMS\Core\Security\Nonce;

$nonce = Nonce::create();
$policy = (new Policy())
    // Results in `default-src 'self'`
    ->default(SourceKeyword::self)

    // Extends the ancestor directive ('default-src'),
    // thus reuses 'self' and adds additional sources
    // Results in `img-src 'self' data: https://*.typo3.org`
    ->extend(Directive::ImgSrc, SourceScheme::data, new UriValue('https://*.typo3.org'))

    // Extends the ancestor directive ('default-src'),
    // thus reuses 'self' and adds additional sources
    // Results in `script-src 'self' 'nonce-[random]'`
    // ('nonce-proxy' is substituted when compiling the policy)
    ->extend(Directive::ScriptSrc, SourceKeyword::nonceProxy)

    // Sets (overrides) the directive,
    // thus ignores 'self' of the 'default-src' directive
    // Results in `worker-src blob:`
    ->set(Directive::WorkerSrc, SourceScheme::blob);

header('Content-Security-Policy: ' . $policy->compile($nonce));
