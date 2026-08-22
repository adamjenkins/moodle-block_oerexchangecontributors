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

namespace block_oerexchangecontributors\privacy;

/**
 * Privacy provider for block_oerexchangecontributors. This block stores no
 * data of its own: it renders local_oerexchange\local\contributor_list, whose
 * data local_oerexchange already owns and reports on. The sort control is
 * transient (a URL parameter and an AJAX call), never a stored preference —
 * which is what keeps this a null_provider.
 *
 * @package    block_oerexchangecontributors
 * @copyright  2026 Adam Jenkins <adam@wisecat.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements \core_privacy\local\metadata\null_provider {
    #[\Override]
    public static function get_reason(): string {
        return 'privacy:metadata';
    }
}
