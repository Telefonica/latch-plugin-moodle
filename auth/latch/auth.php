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
 * latch.php - Latch authentication plugin.
 *
 * This plugin allows Latch integration with moodle auth.
 *
 * @package    auth_latch
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v2.1 or later
 * @author     Latch Team - ElevenPaths <elevenpaths@elevenpaths.com>
 * @copyright 2014 onwards ElevenPaths (https://www.elevenpaths.com)
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/authlib.php');
require_once($CFG->libdir.'/latch-sdk/Latch.php');
require_once($CFG->libdir.'/latch-sdk/LatchResponse.php');
require_once($CFG->libdir.'/latch-sdk/Error.php');
/**
 * Auth plugin to allow Latch integration with moodle auth.
 */
class auth_plugin_latch extends auth_plugin_base {

    /**
     * Constructor.
     */
    function auth_plugin_latch() {
        $this->authtype = 'latch';
        $this->config = get_config('auth/latch');
    }

    /**
     * This method must be always override by auth plugins like Latch.
     * We are not going to authenticate users so always return false.
     *
     * @param string $username username
     * @param string $password password
     * @return false - User creation not allowed.
     */
    function user_login($username, $password) {
        return false;
    }

    /**
     * This is the authentication hook. After every successfull login this method is called.
     *
     * @param $user user object
     * @param $username username
     * @param $username password
     */
    function user_authenticated_hook(&$user, $username, $password) {
        global $DB, $SESSION;
        $latch_field = $DB->get_record_sql('SELECT id FROM {user_info_field} WHERE datatype = ?', array('latch'));
        $latch_accountid = $DB->get_record_sql('SELECT data FROM {user_info_data} WHERE fieldid = ? AND userid= ?', array($latch_field->id, $user->id));

        $appid = get_config('auth_latch', 'appId');
        $secret = get_config('auth_latch', 'appSecret');
        $api = new Latch($appid, $secret);


        if (!empty($appid) && !empty($secret)){
            if (isset($latch_accountid->data) && !empty($latch_accountid->data)){
                $accountId = substr($latch_accountid->data, 6); //Since accountIDs are stored like "latch_accIdHere" we need to remove "latch_" from the str
                $statusResponse = $api->status($accountId);
                $status = $statusResponse->getData()->{"operations"}->{$appid}->{"status"};
                if ($status == 'on'){
                    //TODO: OTP
                }else if ($status == 'off'){
                    $redirect = get_login_url();
                    $errormsg = get_string("invalidlogin");
                    $SESSION->loginerrormsg = $errormsg;
                    redirect($redirect);
                }else{
                    //Error while connecting with Latch.
                    //To avoid DoS we let the user in.
                }
            }
        }
    }


    /**
     * Returns true if this authentication plugin is 'internal'.
     *
     * @return bool
     */
    function is_internal() {
        return false;
    }

    /**
     * Returns true if this authentication plugin can change the user's
     * password.
     *
     * @return bool
     */
    function can_change_password() {
        return false;
    }

    /**
     * Returns the URL for changing the user's pw, or empty if the default can
     * be used.
     *
     * @return string
     */
    function change_password_url() {
        return '';
    }

    /**
     * Returns true if plugin allows resetting of internal password.
     *
     * @return bool
     */
    function can_reset_password() {
        return false;
    }

    /**
     * Prints a form for configuring this authentication plugin.
     *
     * This function is called from admin/auth.php, and outputs a full page with
     * a form for configuring this plugin.
     *
     * @param array $page An object containing all the data for this page.
     */
    function config_form($config, $err, $user_fields) {
        include "config.html";
    }

    /**
     * Updates the Application ID and the Application Secret.
     *
     * @param object $config configuration settings
     * @return boolean always true.
     */
    function process_config($config) {

        //Set to defaults if undefined
        if (!isset ($config->appId)) {
            $config->appId = '';
        }

        if (!isset ($config->appSecret)) {
            $config->appSecret = '';
        }

        //Configuration for Latch API
        set_config('appId', str_replace(' ', '', $config->appId), 'auth_latch');
        set_config('appSecret', str_replace(' ', '', $config->appSecret), 'auth_latch');

        return true;
    }


}
