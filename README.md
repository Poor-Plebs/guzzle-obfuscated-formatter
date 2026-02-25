# poor-plebs/guzzle-obfuscated-formatter

[![CI](https://github.com/Poor-Plebs/guzzle-obfuscated-formatter/actions/workflows/ci.yml/badge.svg)](https://github.com/Poor-Plebs/guzzle-obfuscated-formatter/actions/workflows/ci.yml)
[![codecov](https://codecov.io/gh/Poor-Plebs/guzzle-obfuscated-formatter/branch/main/graph/badge.svg)](https://codecov.io/gh/Poor-Plebs/guzzle-obfuscated-formatter)

**[What is it for?](#what-is-it-for)** |
**[What are the requirements?](#what-are-the-requirements)** |
**[How to install it?](#how-to-install-it)** |
**[How to use it?](#how-to-use-it)** |
**[How to contribute?](#how-to-contribute)**

Guzzle HTTP message formatter with configurable obfuscation for safe logging
of sensitive data.

## What is it for?

This package provides a Guzzle `MessageFormatterInterface` implementation that
can selectively obfuscate sensitive data in HTTP messages before logging. It
supports obfuscating:

- **URI path segments** via regex patterns
- **Query parameters** by name
- **Request and response headers** by name
- **JSON body fields** (request and response) by key, including nested fields
- **User info** (password part) in URIs

It also includes utilities for PSR-7 message stringification with large payload
compression, and a wrapped PSR-3 logger that supports runtime logger swapping.

## What are the requirements?

- PHP 8.4 or above
- Guzzle HTTP 7.10+

## How to install it?

```bash
composer require poor-plebs/guzzle-obfuscated-formatter
```

## How to use it?

### Basic usage

```php
use PoorPlebs\GuzzleObfuscatedFormatter\GuzzleHttp\ObfuscatedMessageFormatter;
use PoorPlebs\GuzzleObfuscatedFormatter\Obfuscator\StringObfuscator;

$formatter = (new ObfuscatedMessageFormatter(ObfuscatedMessageFormatter::DEBUG))
    ->setQueryParameters(['api_key', 'token'])
    ->setRequestHeaders(['Authorization'])
    ->setResponseHeaders(['Set-Cookie'])
    ->setRequestBodyParameters(['password', 'secret'])
    ->setResponseBodyParameters(['access_token']);
```

### URI path obfuscation with regex

```php
$formatter->setUriParameters([
    '/\/api\/v1\/users\/\d+/' => new StringObfuscator('*', 5),
]);
```

### Custom obfuscator per parameter

```php
$formatter->setRequestHeaders([
    'Authorization' => new StringObfuscator('X', 3),  // Replaces with "XXX"
]);
```

### Wrapped logger

```php
use PoorPlebs\GuzzleObfuscatedFormatter\Psr\Log\WrappedLogger;

$logger = new WrappedLogger($psrLogger);
// Swap the underlying logger at runtime:
$logger->setLogger($anotherPsrLogger);
```

## How to contribute?

`poor-plebs/guzzle-obfuscated-formatter` follows semantic versioning. Read more
on [semver.org][1].

Create issues to report problems or requests. Fork and create pull requests to
propose solutions and ideas.

### Development Setup

This package uses modern PHP tooling with strict quality standards:

- **Testing**: [Pest PHP](https://pestphp.com/) v4 with parallel execution
- **Static Analysis**: PHPStan at level `max` with strict and deprecation rules
- **Code Style**: PHP-CS-Fixer (PSR-12)
- **Coverage Requirements**: Minimum 80% code coverage and 80% type coverage

### Available Commands

```bash
composer test          # Run tests (parallel, no coverage)
composer coverage      # Run tests with coverage (min 80%)
composer type-coverage # Check type coverage (min 80%)
composer static        # Run PHPStan analysis
composer cs            # Check code style
composer csf           # Fix code style
composer ci            # Run full CI pipeline
```

### Docker

```bash
bin/dc install         # Install dependencies via Docker
bin/dc test            # Run tests via Docker
bin/dc ci              # Run full CI pipeline via Docker
```

### Versioning and Releases

This project uses [Semantic Versioning][1] with tags in `MAJOR.MINOR.PATCH`
format (no `v` prefix). Releases are automated via GitHub Actions when a tag is
pushed.

```bash
bin/release-tag 1.0.0 notes.md --push
```

[1]: https://semver.org
