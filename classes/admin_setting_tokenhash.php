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
