<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace block_oerexchangecontributors\local;

use local_oerexchange\local\contributor_list;

/**
 * Settings resolution for the contributors block: instance override, else site
 * default, else the shipped default.
 *
 * No HTML here — the cards themselves are rendered by
 * local_oerexchange\local\contributor_list, which the /contributors page uses
 * too, so the two surfaces cannot drift apart. This class exists so the
 * precedence rules can be unit-tested without rendering anything.
 *
 * @package    block_oerexchangecontributors
 * @copyright  2026 Adam Jenkins <adam@wisecat.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class content_builder {
    /**
     * How many cards this instance should show.
     *
     * @param \stdClass|null $config the block instance config, or null when unconfigured
     * @param int $shippeddefault fallback when neither the instance nor the site says
     * @return int clamped to 1..contributor_list::PERPAGE
     */
    public static function resolve_count(?\stdClass $config, int $shippeddefault): int {
        $value = $config->count ?? '';

        if ($value === '' || $value === null) {
            $sitevalue = get_config('block_oerexchangecontributors', 'defaultcount');
            // Config reads return false, not the declared default, when the
            // settings page has never been saved — fall back explicitly rather
            // than letting (int) false collapse the count to zero.
            $value = $sitevalue === false ? $shippeddefault : $sitevalue;
        }

        return max(1, min((int) $value, contributor_list::PERPAGE));
    }

    /**
     * Which sort this instance should open with.
     *
     * @param \stdClass|null $config the block instance config, or null when unconfigured
     * @return string one of contributor_list's SORT_* constants
     */
    public static function resolve_sort(?\stdClass $config): string {
        $value = $config->sort ?? '';

        if ($value === '' || $value === null) {
            $sitevalue = get_config('block_oerexchangecontributors', 'defaultsort');
            $value = $sitevalue === false ? contributor_list::SORT_RESOURCES : $sitevalue;
        }

        return contributor_list::normalise_sort((string) $value);
    }
}
