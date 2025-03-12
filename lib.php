<?php
defined('MOODLE_INTERNAL') || die();

/**
 * Load the JavaScript for the theme
 *
 * @param moodle_page $page The page object
 */

 // AMD carregado em todas as páginas
 function theme_mooze_page_init(moodle_page $page) {
    global $PAGE;

    error_log('theme_mooze_page_init() foi chamada na página: ' . $page->pagelayout);

    // Garante que jQuery e os plugins necessários sejam carregados
    $PAGE->requires->jquery();
    $PAGE->requires->jquery_plugin('ui');
    $PAGE->requires->jquery_plugin('ui-css');

    // Só carrega o script dropdown se a página não for a de login
    if ($page->pagelayout !== 'login') {
        $PAGE->requires->js_call_amd('theme_mooze/dropdown', 'init');
    }
}

/**
 * Get SCSS content.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
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
        'settings/frontpage.scss',
        'settings/navbar.scss',
        'settings/login.scss',
        'settings/typography.scss',
        'settings/forgot_password.scss', 
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


