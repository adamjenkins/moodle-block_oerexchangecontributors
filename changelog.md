# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Changed

- The Japanese language pack (lang/ja) is no longer included: releases ship the English strings
  only, as the Moodle Plugins directory expects. Japanese is provided through Moodle's language
  packs.

## [1.0.1] - 2026-10-04

### Changed

- Declare Moodle 5.3 support: `$plugin->supported` is now `[500, 503]` and
  composer.json's `moodle/moodle` constraint is `>=5.0 <5.4`.

## [1.0.0] - 2026-08-22

### Added

- Dashboard and front-page block listing OER Exchange contributors as cards:
  profile picture, name, badges, up to three expertise tags, resource and
  course counts, and time since the last share.
- Whole-card link to the contributor's public profile, implemented with a
  single stretched anchor so assistive technology announces the contributor's
  name rather than the card's entire contents.
- Sort control offering most resources shared, most courses shared and
  recently shared; re-sorts in place over AJAX and degrades to a plain form
  when JavaScript is unavailable.
- View control switching between cards and a compact list, so the same block
  suits both a narrow Dashboard column and a wide region.
- Site-wide settings for the number of cards, the view, and the initial sort,
  each overridable per block instance.
- Footer link to the full contributor listing.
