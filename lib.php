<?php
function theme_mooze_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : null;
    $fs = get_file_storage();

    $context = \core\context\system::instance();
    if ($filename == 'default.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    } else if ($filename == 'plain.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/plain.scss');
    } else {
        // Safety fallback - maybe new installs etc.
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    }

    // mooze scss.
    $moozevariables = file_get_contents($CFG->dirroot . '/theme/mooze/scss/login.scss');
    $mooze = file_get_contents($CFG->dirroot . '/theme/mooze/scss/main.scss');
    $security = file_get_contents($CFG->dirroot . '/theme/mooze/scss/typography.scss');

    $lastpreset = '';
    if ($filename && ($presetfile = $fs->get_file($context->id, 'theme_mooze', 'preset', 0, '/', $filename))) {
        $lastpreset = $presetfile->get_content();
    }

    // Combine them together.
    $allscss = $moozevariables . "\n" . $scss . "\n" . $mooze . "\n" . $lastpreset .    "\n" . $security;

    return $allscss;
}


