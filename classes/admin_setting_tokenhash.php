<?php
namespace local_certhub;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/adminlib.php');
class admin_setting_tokenhash extends \admin_setting_configtext {
    public function write_setting($data) {
        if ($data === '') {
            // Skip updating if no new token was provided
            return '';
        }
        $hashed = password_hash($data, PASSWORD_BCRYPT);
        return parent::write_setting($hashed);
    }

    public function get_setting() {
        // Do not expose hashed value in the UI
        return '';
    }
}
