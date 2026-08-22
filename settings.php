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

/**
 * Site-wide defaults for block_oerexchangecontributors. Every block instance
 * may override these on its own configuration form.
 *
 * @package    block_oerexchangecontributors
 * @copyright  2026 Adam Jenkins <adam@wisecat.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configtext(
        'block_oerexchangecontributors/defaultcount',
        get_string('defaultcount', 'block_oerexchangecontributors'),
        get_string('defaultcount_desc', 'block_oerexchangecontributors'),
        // Literal 6, NOT block_oerexchangecontributors::DEFAULT_COUNT: the
        // block class file is not autoloaded while the admin tree is built, so
        // referencing the constant here fatals on the settings page. Keep this
        // in step with DEFAULT_COUNT in block_oerexchangecontributors.php.
        6,
        PARAM_INT
    ));

    $sortoptions = [];
    foreach (\local_oerexchange\local\contributor_list::sort_keys() as $key) {
        $sortoptions[$key] = get_string('contributors_sort_' . $key, 'local_oerexchange');
    }

    $viewoptions = [];
    foreach (\local_oerexchange\local\contributor_list::layout_keys() as $key) {
        $viewoptions[$key] = get_string('contributors_view_' . $key, 'local_oerexchange');
    }

    $settings->add(new admin_setting_configselect(
        'block_oerexchangecontributors/defaultlayout',
        get_string('defaultlayout', 'block_oerexchangecontributors'),
        get_string('defaultlayout_desc', 'block_oerexchangecontributors'),
        \local_oerexchange\local\contributor_list::LAYOUT_CARDS,
        $viewoptions
    ));

    $settings->add(new admin_setting_configselect(
        'block_oerexchangecontributors/defaultsort',
        get_string('defaultsort', 'block_oerexchangecontributors'),
        get_string('defaultsort_desc', 'block_oerexchangecontributors'),
        \local_oerexchange\local\contributor_list::SORT_RESOURCES,
        $sortoptions
    ));
}
