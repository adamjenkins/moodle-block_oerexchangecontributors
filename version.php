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
 * Version information for block_oerexchangecontributors.
 *
 * @package    block_oerexchangecontributors
 * @copyright  2026 Adam Jenkins <adam@wisecat.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'block_oerexchangecontributors';
$plugin->version   = 2026082201;
// 2025041400 = the Moodle 5.0 branching version — matches $supported's floor
// (and composer.json's ">=5.0 <5.3").
$plugin->requires  = 2025041400;
$plugin->supported = [500, 502];
$plugin->release   = '1.0.0';
$plugin->maturity  = MATURITY_STABLE;

// This block renders local_oerexchange\local\contributor_list and reads that
// plugin's tables through it; there is no subplugin relationship available for
// block types, so the installer dependency check is the real enforcement
// mechanism (see dev-docs/oer-platform/BLOCKS-DESIGN.md, "Why not subplugins").
// The contributor listing arrived in local_oerexchange 2026082200, so this
// pins that rather than ANY_VERSION — an older parent has no such class and
// the block would fatal on first render.
$plugin->dependencies = ['local_oerexchange' => 2026082200];
