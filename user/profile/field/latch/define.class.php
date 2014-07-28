<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 2.1 of the License, or
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
 * Latch profile field does not need any special configuration.
 *
 * @package   profilefield_latch
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v2.1 or later
 * @author     Latch Team - ElevenPaths <elevenpaths@elevenpaths.com>
 * @copyright 2014 onwards ElevenPaths (https://www.elevenpaths.com)
 */
class profile_define_latch extends profile_define_base{

      function define_form_specific($form) {}

      function define_validate_specific($data, $files) {
        return array();
      }

}
