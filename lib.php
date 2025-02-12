<?php
function theme_mooze_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : 'default.scss';
    $fs = get_file_storage();
    $context = \core\context\system::instance();

    if (in_array($filename, ['default.scss', 'plain.scss'])) {
        $scss .= file_get_contents($CFG->dirroot . "/theme/boost/scss/preset/$filename");
    } else {
        $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
    }

    $mooze_scss_files = [
        'settings/login.scss',
        'settings/typography.scss',
        'settings/forgot_password.scss', // <- Este precisa ser lido corretamente
        'main.scss',
    ];

    foreach ($mooze_scss_files as $file) {
        $path = $CFG->dirroot . "/theme/mooze/scss/$file";
        if (file_exists($path)) {
            $scss .= "\n" . file_get_contents($path);
        } else {
            echo "SCSS não encontrado: $file <br>"; // <- Isso mostra se ele não está lendo algum SCSS
        }
    }

    if ($filename && ($presetfile = $fs->get_file($context->id, 'theme_mooze', 'preset', 0, '/', $filename))) {
        $scss .= "\n" . $presetfile->get_content();
    }

    return $scss;
}
