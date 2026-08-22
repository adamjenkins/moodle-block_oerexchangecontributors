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

use block_oerexchangecontributors\local\content_builder;
use local_oerexchange\local\contributor_list;

/**
 * "OER Exchange: contributors" block: cards for the people publishing to this
 * Exchange, sorted by contribution, each linking to their profile.
 *
 * @package    block_oerexchangecontributors
 * @copyright  2026 Adam Jenkins <adam@wisecat.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_oerexchangecontributors extends block_base {
    /** @var int cards shown when neither the instance nor the site says otherwise */
    const DEFAULT_COUNT = 6;

    /**
     * Initialize class member variables.
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_oerexchangecontributors');
    }

    /**
     * Locations where block can be displayed.
     *
     * 'site' is included because the listing is public — but note that when
     * local_oerexchange's publiclanding setting is on, anonymous visitors are
     * served the catalogue at the site root and never reach the front page at
     * all (hook_callbacks::after_config()). On such a site this block reaches
     * logged-in front-page visitors only; it is not a route to anonymous ones.
     *
     * @return array
     */
    public function applicable_formats() {
        return ['my' => true, 'site' => true];
    }

    /**
     * This block cannot be added more than once to the same page.
     *
     * @return bool
     */
    public function instance_allow_multiple() {
        return false;
    }

    /**
     * This block has site-wide settings (settings.php) as well as per-instance
     * configuration (edit_form.php).
     *
     * @return bool
     */
    public function has_config() {
        return true;
    }

    /**
     * Build the block content. Kept thin: settings precedence lives in
     * content_builder, and the cards are rendered by contributor_list so this
     * block and the /contributors page always look the same.
     *
     * @return stdClass
     */
    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->footer = html_writer::link(
            \moodle_url::routed_path('/local_oerexchange/contributors'),
            get_string('contributors_seeall', 'local_oerexchange'),
            ['class' => 'btn btn-sm btn-outline-primary']
        );

        $config = isset($this->config) ? $this->config : null;
        $count = content_builder::resolve_count($config, self::DEFAULT_COUNT);

        // A sort in the URL wins over the configured default, so the no-JS
        // form still works: it submits back to this same page with the param.
        $sort = contributor_list::normalise_sort(
            optional_param(
                contributor_list::PARAM_SORT,
                content_builder::resolve_sort($config),
                PARAM_ALPHA
            )
        );

        $layout = contributor_list::normalise_layout(
            optional_param(
                contributor_list::PARAM_LAYOUT,
                content_builder::resolve_layout($config),
                PARAM_ALPHA
            )
        );

        $regionid = 'oerexchange-contributors-block-' . (int) $this->instance->id;
        $cards = contributor_list::get_cards($sort, $count, 0);

        $this->page->requires->js_call_amd('local_oerexchange/contributorsort', 'init', [
            $regionid,
            $count,
            $layout,
        ]);

        $this->content->text = contributor_list::render_sort_form($this->page->url, $sort, $regionid, $layout)
            . html_writer::div(
                contributor_list::render($cards, $layout),
                '',
                ['id' => $regionid, 'data-region' => 'oerexchange-contributors']
            );

        return $this->content;
    }
}
