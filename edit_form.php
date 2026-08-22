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

use local_oerexchange\local\contributor_list;

/**
 * Per-instance configuration for block_oerexchangecontributors. Each field
 * offers "use the site default" so an instance only ever overrides
 * deliberately — leaving both alone keeps the block following the admin.
 *
 * @package    block_oerexchangecontributors
 * @copyright  2026 Adam Jenkins <adam@wisecat.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_oerexchangecontributors_edit_form extends block_edit_form {
    /**
     * Add this block's own settings to the instance configuration form.
     *
     * @param MoodleQuickForm $mform
     * @return void
     */
    protected function specific_definition($mform) {
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $counts = ['' => get_string('usesitedefault', 'block_oerexchangecontributors')];
        for ($i = 1; $i <= contributor_list::PERPAGE; $i++) {
            $counts[$i] = $i;
        }
        $mform->addElement(
            'select',
            'config_count',
            get_string('config_count', 'block_oerexchangecontributors'),
            $counts
        );
        $mform->setDefault('config_count', '');

        $sorts = ['' => get_string('usesitedefault', 'block_oerexchangecontributors')];
        foreach (contributor_list::sort_keys() as $key) {
            $sorts[$key] = get_string('contributors_sort_' . $key, 'local_oerexchange');
        }
        $mform->addElement(
            'select',
            'config_sort',
            get_string('config_sort', 'block_oerexchangecontributors'),
            $sorts
        );
        $mform->setDefault('config_sort', '');
    }
}
