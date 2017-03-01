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
 * Unit tests for tasks.
 *
 * @package    tool_hidecourses
 * @category   test
 * @copyright  2017 Lafayette College ITS
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot.'/admin/tool/hidecourses/locallib.php');

class tool_hidecourses_hidecourses_testcase extends advanced_testcase {
    public function test_hide_course() {
        global $DB;

        $this->setAdminUser();
        $this->resetAfterTest(true);

        $user = $this->getDataGenerator()->create_user();
        $category = $this->getDataGenerator()->create_category();
        $course1 = $this->getDataGenerator()->create_course(array('category' => $category->id));
        $course2 = $this->getDataGenerator()->create_course(array('category' => $category->id));

        // Sanity check.
        $visiblecourses = $DB->count_records('course', array('category' => $category->id, 'visible' => 1));
        $this->assertEquals(2, $visiblecourses);

        // Set courses to hidden.
        $task = new \tool_hidecourses\task\hide_courses_task();
        $task->set_custom_data(
            array(
                'category' => $category->id,
                'action' => CHC_ACTION_HIDE
            )
        );
        \core\task\manager::queue_adhoc_task($task);
        $task = \core\task\manager::get_next_adhoc_task(time());
        $this->assertInstanceOf('\\tool_hidecourses\\task\\hide_courses_task', $task);
        $task->execute();
        \core\task\manager::adhoc_task_complete($task);

        $visiblecourses = $DB->count_records('course', array('category' => $category->id, 'visible' => 1));
        $this->assertEquals(0, $visiblecourses);
    }
}
