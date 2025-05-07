<?php
// settings.php
defined('MOODLE_INTERNAL') || die();

use local_certhub\admin_setting_encrypted;

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_certhub', get_string('pluginname', 'local_certhub'));

    $settings->add(new admin_setting_configtext(
        'local_certhub/baseurl',
        get_string('baseurl', 'local_certhub'),
        get_string('baseurl_desc', 'local_certhub'),
        '',
        PARAM_URL
    ));

    $settings->add(new admin_setting_configtext(
        'local_certhub/clientid',
        get_string('clientid', 'local_certhub'),
        get_string('clientid_desc', 'local_certhub'),
        '',
        PARAM_ALPHANUMEXT
    ));

    $settings->add(new admin_setting_encrypted(
        'local_certhub/clientsecret',
        get_string('clientsecret', 'local_certhub'),
        get_string('clientsecret_desc', 'local_certhub'),
        ''
    ));

    $settings->add(new admin_setting_encrypted(
        'local_certhub/accesstoken',
        get_string('accesstoken', 'local_certhub'),
        get_string('accesstoken_desc', 'local_certhub'),
        ''
    ));

    $ADMIN->add('localplugins', $settings);
}
