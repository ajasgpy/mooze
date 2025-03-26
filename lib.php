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

    $PAGE->requires->jquery();
    $PAGE->requires->jquery_plugin('ui');
    $PAGE->requires->jquery_plugin('ui-css');

    // Só carrega o dropdown se NÃO for página de login ou recuperação de senha
    if ($page->pagetype !== 'login-index' && $page->pagetype !== 'login-forgotpassword') {
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

    // 🔥 Carregar automaticamente TODOS os SCSS em settings/ e subpastas
    $scss_folder = $CFG->dirroot . "/theme/mooze/scss/settings/";
    $scss_files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($scss_folder));
    
    foreach ($scss_files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'scss') {
            $scss .= "\n" . file_get_contents($file);
        }
    }

    // Carregar o main.scss no final para garantir que os @import sejam lidos corretamente
    $main_scss_path = $CFG->dirroot . "/theme/mooze/scss/main.scss";
    if (file_exists($main_scss_path)) {
        $scss .= "\n" . file_get_contents($main_scss_path);
    } else {
        debugging("main.scss não encontrado", DEBUG_DEVELOPER);
    }

    if ($filename && ($presetfile = $fs->get_file($context->id, 'theme_mooze', 'preset', 0, '/', $filename))) {
        $scss .= "\n" . $presetfile->get_content();
    }

    return $scss;
}

function theme_mooze_numbers() {
    global $DB;

    // Conta a quantidade total de cursos no Moodle (ignorando o curso 'site' ID = 1)
    $total_cursos = $DB->count_records('course', ['category' => 1]); 

    // Retorna os números como um array associativo
    return [
        'total_cursos' => $total_cursos
    ];
}

