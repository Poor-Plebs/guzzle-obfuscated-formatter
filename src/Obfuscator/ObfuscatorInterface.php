<?php

declare(strict_types=1);

namespace PoorPlebs\GuzzleObfuscatedFormatter\Obfuscator;

interface ObfuscatorInterface
{
    public function __invoke(mixed $value): mixed;
}
