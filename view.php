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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>;.
/**
 * superframe view page
 *
 * @package    block_superframe
 * @copyright  Daniel Neis <danielneis@gmail.com>
 * Modified for use in MoodleBites for Developers Level 1 by Richard Jones & Justin Hunt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require('../../config.php');
$blockid = required_param('blockid', PARAM_INT);
$def_config = get_config('block_superframe');
$PAGE->set_course($COURSE);
$PAGE->set_url('/blocks/superframe/view.php');
$PAGE->set_heading($SITE->fullname);
// $PAGE->set_pagelayout('course');
$PAGE->set_pagelayout($def_config->pagelayout);
$PAGE->set_title(get_string('pluginname', 'block_superframe'));
$PAGE->navbar->add(get_string('pluginname', 'block_superframe'));
require_login();
// Check the users permissions to see the view page.
$context = context_block::instance($blockid);
require_capability('block/superframe:seeviewpage', $context);
// Get the instance configuration data from the database.
// It's stored as a base 64 encoded serialized string.
$configdata = $DB->get_field('block_instances', 'configdata', ['id' => $blockid]);

// If an entry exists, convert to an object.
if ($configdata) {
    $config = unserialize(base64_decode($configdata));
} else {
    // No instance data, use admin settings.
    // However, that only specifies height and width, not size.
   $config = $def_config;
   $config->size = 'custom';
}

// URL - comes either from instance or admin.
$url = $config->url;
// Let's set up the iframe attributes.
switch ($config->size) {
    case 'custom':
        $width = $def_config->width;
        $height = $def_config->height;
        break;
    case 'small' :
        $width = 360;
        $height = 240;
        break;
    case 'medium' :
        $width = 600;
        $height = 400;
        break;
    case 'large' :
        $width = 1024;
        $height = 720;
        break;
}

// Start output to browser.
/* This will go in the renderer
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'block_superframe'), 5);
echo '<br>'.fullname($USER).'<br>';
*/
// echo '<div>';
// echo '<script src="https://cdn.htmlgames.com/embed.js?game=TetrisFun&amp;bgcolor=white"></script>';
// echo '</div>';

//<embed width="550" height="400" base="https://external.kongregate-games.com/gamez/0000/6057/live/" src="https://external.kongregate-games.com/gamez/0000/6057/live/embeddable_6057.swf" type="application/x-shockwave-flash"></embed><br/>Play free games at <a href="https://www.kongregate.com/">Kongregate</a>
$url = 'https://quizlet.com/132695231/scatter/embed';
$width = '600px';
$height = '400px';
/* this will go in the renderer
$attribute = ['src'=>$url,
                'width'=>$width,
                'height'=>$height];
echo html_writer::start_tag('iframe',$attribute);
echo html_writer::end_tag('iframe');
//send footer out to browser
echo $OUTPUT->footer();
*/
$renderer = $PAGE->get_renderer('block_superframe');
$renderer->display_view_page($url, $width, $height);
