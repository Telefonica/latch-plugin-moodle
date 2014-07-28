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
 * Latch profile field. Allow moodle to store Latch account id,
 * and users to pair or unpair with Latch.
 *
 * @package   profilefield_latch
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v2.1 or later
 * @author     Latch Team - ElevenPaths <elevenpaths@elevenpaths.com>
 * @copyright 2014 onwards ElevenPaths (https://www.elevenpaths.com)
 */

require_once($CFG->libdir.'/latch-sdk/Latch.php');
require_once($CFG->libdir.'/latch-sdk/LatchResponse.php');
require_once($CFG->libdir.'/latch-sdk/Error.php');

class profile_field_latch extends profile_field_base {

    /**
     * Set a link in the user profile:
     *
     * {human readable date} ({unix time stamp}).
     *
     * @return string
     */
    function display_data()
    {
        return "<a href='editadvanced.php'>".get_string('profilefield_configure', 'profilefield_latch')."</a>";
    }

    /**
     * Build form for the Latch field.
     * If user is currently paired checkbox to unpair is shown, otherwise textbox for token.
     * @param object $mform form.
     */
    function edit_field_add($mform){
        if ($this->data == ''){
            // Create form for pairing
            $text = &$mform->addElement('text', $this->inputname, get_string('profilefield_token', 'profilefield_latch'));
        }else{
            // Create form for unpairing
            $checkbox = &$mform->addElement('advcheckbox', $this->inputname, get_string('profilefield_unpair', 'profilefield_latch', array(), array(0)));
        }
       $mform->setType($this->inputname, PARAM_TEXT);
    }

    /**
     * Validation for the Latch field.
     *
     * @param object $usernew The user with the new fielddata.
     */
    function edit_validate_field($usernew) {
        global $accountId;
        $errors = array();
        if ($usernew->{$this->inputname} != '') {
            $appid = get_config('auth_latch', 'appId');
            $secret = get_config('auth_latch', 'appSecret');
            $api = new Latch($appid, $secret);
            if ($this->data == ''){
                //API-PAIR
                $pairResponse = $api->pair($usernew->{$this->inputname});
                $responseData = $pairResponse->getData();
                $responseError = $pairResponse->getError();
                if (!empty($responseData)) {
                    $accountId = "latch_".$responseData->{"accountId"}; //Prefix added to avoid checkbox checked with accountIds starting with '1'
                }
                if (empty($accountId)) {
                    //NOK PAIRING
                    if ($responseError->getCode() == 206){
                      $errors[$this->inputname] = get_string('profilefield_tokeninvalid', 'profilefield_latch');
                    }else{
                      $errors[$this->inputname] = get_string('profilefield_invalidconfig', 'profilefield_latch');
                    }
                }
            }else{
                if ($usernew->{$this->inputname} == '1') {
                    //API-UNPAIR
                    $accountId = substr($this->data, 6); //Since accountIDs are stored like "latch_accIdHere" we need to remove "latch_" from the str
                    $unpairResponse = $api->unpair($accountId);
                }
            }
        }
        return $errors;
    }

    /**
     * Preprocess of the data form.
     *
     * @param object $data The data to store in the field. In this case the Account ID.
     */
    function edit_save_data_preprocess($data, $datarecord) {
        global $accountId;
        //Unpairing checkbox is activated > Previous Account ID deleted.
        if ($data == null || $data == '1'){
            $data = '';
        }else if ($data == '0'){ //Unpairing checkbox not activated > Previous Account ID re-stored.
            $data = $this->data;
        }else{ //Pairing
           $data = $accountId;
        }
        return $data;
    }

}
