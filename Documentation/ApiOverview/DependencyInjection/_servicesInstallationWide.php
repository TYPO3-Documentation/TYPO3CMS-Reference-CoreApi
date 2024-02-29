<?php

declare(strict_types=1);

use Lcobucci\Clock\SystemClock;
use Psr\Clock\ClockInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (
    ContainerConfigurator $containerConfigurator,
    ContainerBuilder $containerBuilder,
): void {
    $services = $containerConfigurator->services();
    $services->set(ClockInterface::class)
        ->factory([SystemClock::class, 'fromUTC']);
};
