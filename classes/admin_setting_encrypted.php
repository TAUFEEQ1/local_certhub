<?php
namespace local_certhub;
use local_certhub\SecureConfig;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/adminlib.php');

class admin_setting_encrypted extends \admin_setting_configtext {

    public function write_setting($data) {
        if (empty($data)) {
            return parent::write_setting('');
        }
        $encrypted = SecureConfig::encrypt($data);
        return parent::write_setting($encrypted);
    }

    public function get_setting() {
        $raw = parent::get_setting();
        if (empty($raw)) {
            return '';
        }
        return SecureConfig::decrypt($raw);
    }
    public function output_html($data, $query = '') {
        global $OUTPUT;

        $elementname = $this->get_full_name();
        $id = \html_writer::random_id($elementname);
        $input = \html_writer::empty_tag('input', [
            'type' => 'password',
            'name' => $elementname,
            'id' => $id,
            'value' => '',
            'class' => 'form-control'
        ]);

        return format_admin_setting($this, $this->visiblename, $input, $this->description, true, '', '', $query);
    }
}
