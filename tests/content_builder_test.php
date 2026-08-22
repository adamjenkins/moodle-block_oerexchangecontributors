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

namespace block_oerexchangecontributors;

use block_oerexchangecontributors\local\content_builder;
use local_oerexchange\local\contributor_list;

/**
 * Tests for content_builder: instance override beats site default beats the
 * shipped default, and both values are clamped or normalised.
 *
 * @package    block_oerexchangecontributors
 * @copyright  2026 Adam Jenkins <adam@wisecat.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
#[\PHPUnit\Framework\Attributes\CoversClass(content_builder::class)]
final class content_builder_test extends \advanced_testcase {
    public function test_shipped_default_when_nothing_configured(): void {
        $this->resetAfterTest();

        $this->assertSame(6, content_builder::resolve_count(null, 6));
        $this->assertSame(contributor_list::SORT_RESOURCES, content_builder::resolve_sort(null));
    }

    public function test_site_default_beats_shipped_default(): void {
        $this->resetAfterTest();
        set_config('defaultcount', 9, 'block_oerexchangecontributors');
        set_config('defaultsort', contributor_list::SORT_RECENT, 'block_oerexchangecontributors');

        $this->assertSame(9, content_builder::resolve_count(null, 6));
        $this->assertSame(contributor_list::SORT_RECENT, content_builder::resolve_sort(null));
    }

    public function test_instance_config_beats_site_default(): void {
        $this->resetAfterTest();
        set_config('defaultcount', 9, 'block_oerexchangecontributors');
        set_config('defaultsort', contributor_list::SORT_RECENT, 'block_oerexchangecontributors');

        $config = (object) ['count' => 3, 'sort' => contributor_list::SORT_COURSES];

        $this->assertSame(3, content_builder::resolve_count($config, 6));
        $this->assertSame(contributor_list::SORT_COURSES, content_builder::resolve_sort($config));
    }

    public function test_empty_instance_config_falls_through_to_site_default(): void {
        $this->resetAfterTest();
        set_config('defaultcount', 9, 'block_oerexchangecontributors');
        set_config('defaultsort', contributor_list::SORT_RECENT, 'block_oerexchangecontributors');

        // Choosing "use the site default" submits an empty string, which
        // must not be read as "zero cards" or "unknown sort".
        $config = (object) ['count' => '', 'sort' => ''];

        $this->assertSame(9, content_builder::resolve_count($config, 6));
        $this->assertSame(contributor_list::SORT_RECENT, content_builder::resolve_sort($config));
    }

    public function test_count_is_clamped(): void {
        $this->resetAfterTest();

        $this->assertSame(1, content_builder::resolve_count((object) ['count' => 0], 6));
        $this->assertSame(1, content_builder::resolve_count((object) ['count' => -5], 6));
        $this->assertSame(
            contributor_list::PERPAGE,
            content_builder::resolve_count((object) ['count' => 9999], 6),
            'a block must never be able to ask for the whole table'
        );
    }

    public function test_bad_sort_is_normalised(): void {
        $this->resetAfterTest();

        $this->assertSame(
            contributor_list::SORT_RESOURCES,
            content_builder::resolve_sort((object) ['sort' => 'nonsense'])
        );
    }

    public function test_unsaved_site_settings_do_not_collapse_the_count(): void {
        $this->resetAfterTest();
        // Config reads return false when the settings page was never saved.
        // Reading that as an int would show zero cards.
        $this->assertSame(6, content_builder::resolve_count(null, 6));
        $this->assertSame(contributor_list::SORT_RESOURCES, content_builder::resolve_sort(null));
    }

    public function test_layout_defaults_to_cards(): void {
        $this->resetAfterTest();

        $this->assertSame(contributor_list::LAYOUT_CARDS, content_builder::resolve_layout(null));
    }

    public function test_layout_site_default_then_instance_override(): void {
        $this->resetAfterTest();
        set_config('defaultlayout', contributor_list::LAYOUT_LIST, 'block_oerexchangecontributors');

        $this->assertSame(contributor_list::LAYOUT_LIST, content_builder::resolve_layout(null));
        $this->assertSame(
            contributor_list::LAYOUT_CARDS,
            content_builder::resolve_layout((object) ['layout' => contributor_list::LAYOUT_CARDS])
        );
        $this->assertSame(
            contributor_list::LAYOUT_LIST,
            content_builder::resolve_layout((object) ['layout' => '']),
            'an empty instance value means "use the site default"'
        );
    }

    public function test_bad_layout_is_normalised(): void {
        $this->resetAfterTest();

        $this->assertSame(
            contributor_list::LAYOUT_CARDS,
            content_builder::resolve_layout((object) ['layout' => 'nonsense'])
        );
    }
}
