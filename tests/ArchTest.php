<?php

declare(strict_types=1);

arch('all source files use strict types')
    ->expect('PoorPlebs\GuzzleObfuscatedFormatter')
    ->toUseStrictTypes();

arch('all test files use strict types')
    ->expect('PoorPlebs\GuzzleObfuscatedFormatter\Tests')
    ->toUseStrictTypes();

arch('no debugging functions in source code')
    ->expect(['dd', 'dump', 'var_dump', 'print_r', 'ray'])
    ->not->toBeUsed();

arch('interfaces use the interface suffix')
    ->expect('PoorPlebs\GuzzleObfuscatedFormatter')
    ->interfaces()
    ->toHaveSuffix('Interface');
