<?php
defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings = new theme_boost_admin_settingspage_tabs('themesettingmooze', get_string('configtitle', 'theme_mooze'));

    /*
    * ----------------------
    * General settings tab
    * ----------------------
    */
    $page = new admin_settingpage('theme_mooze_general', get_string('generalsettings', 'theme_mooze'));

    // JavaScript settings
    $name = 'theme_mooze/enablejs';
    $title = get_string('enablejs', 'theme_mooze');
    $description = get_string('enablejsdesc', 'theme_mooze');
    $default = 1;
    $choices = array(0 => get_string('no'), 1 => get_string('yes'));
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    // Must add the page after defining all the settings!
    $settings->add($page);

    /*
    * ----------------------
    * Advanced settings tab
    * ----------------------
    */
    $page = new admin_settingpage('theme_mooze_advanced', get_string('advancedsettings', 'theme_mooze'));

    // Raw SCSS to include before the content.
    $setting = new admin_setting_scsscode('theme_mooze/scsspre',
        get_string('rawscsspre', 'theme_mooze'), get_string('rawscsspre_desc', 'theme_mooze'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_scsscode('theme_mooze/scss', get_string('rawscss', 'theme_mooze'),
        get_string('rawscss_desc', 'theme_mooze'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
} 