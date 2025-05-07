<?php
namespace local_certhub;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/adminlib.php');

class admin_setting_encrypted extends \admin_setting_configtext {

    public function write_setting($data) {
        if (empty($data)) {
            return parent::write_setting('');
        }
        $encrypted = Secureconfig::encrypt($data);
        return parent::write_setting($encrypted);
    }

    public function get_setting() {
        $raw = parent::get_setting();
        if (empty($raw)) {
            return '';
        }
        return Secureconfig::decrypt($raw);
    }
}
