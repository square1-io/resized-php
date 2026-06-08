# Changelog

All notable changes to this project will be documented in this file.

## [2.0.1] - 2026-06-08

### Changed

- Made `$url` and `$title` parameters in `process()` accept null values.
- Made `$width` and `$height` parameters in `process()` accept `int`, `string`, or `null`. Passing `null` means no constraint on that dimension.
- Added `ext-iconv` as an explicit Composer requirement.

## [2.0.0] - 2026-06-04

### Changed

- Dropped support for PHP 7.x (EOL).
- Set minimum PHP requirement to 8.2.
- Updated PHPUnit dev dependency to support versions 11, 12, and 13.
- Updated phpunit.xml.dist to the PHPUnit 13.1 schema.

## [1.3.0]

- Added max slug length option.

## [1.2.0]

- Added support for image processing options (e.g. `quality`).

## [1.1.1]

- Bug fixes.

## [1.1.0]

- Added support for PHP 7.2.

## [1.0.2]

- Bug fixes.

## [1.0.1]

- Bug fixes.

## [1.0]

- Initial release.
