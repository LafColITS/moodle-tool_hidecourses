Hide courses
============

[![Build Status](https://api.travis-ci.org/LafColITS/moodle-tool_hidecourses.png)](https://api.travis-ci.org/LafColITS/moodle-tool_hidecourses)

This admin tool allows managers to set all courses in a category (including subcategories) to either hidden from, or visible to, students. The intended use case is installations where all categories are already hidden by default and course visibility is the prime method for restricting access. At Lafayette, we combine this with overrides to `moodle/course:viewhiddencourses` at the category level to restict access by _teachers_ to old courses.

Requirements
------------
- Moodle 3.0 (build 2015111600 or later)

Installation
------------
Copy the hidecourses folder into your /admin/tool directory and visit your Admin Notification page to complete the installation.

Usage
-----
The tool adds two links to the category navigation block, "Hide all courses" and "Show all courses." Each will take the user to a page describing what will happen and requesting confirmation. On confirmation, Moodle will create an "[adhoc task](https://docs.moodle.org/dev/Task_API#Adhoc_tasks)" to change all the settings in the background. This requires the cron be enabled. Each setting change will be logged in the standard Moodle log store.

Configuration
-------------
The tool has no options but does require, as mentioned above, that cron be running.

Author
------
Charles Fulton (fultonc@lafayette.edu)
