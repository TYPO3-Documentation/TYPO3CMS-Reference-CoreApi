<?php

declare(strict_types=1);

use MyVendor\MyExtension\Bitmask\Permissions;

$permissions = new Permissions(Permissions::PAGE_SHOW | Permissions::PAGE_NEW);
$permissions->hasPermission(Permissions::PAGE_SHOW); // true
$permissions->hasPermission(Permissions::CONTENT_EDIT); // false
