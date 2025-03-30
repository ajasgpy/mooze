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

    //$total_cursos = $DB->count_records_select('course', 'id > 1');
    $total_alunos = $DB->count_records_sql("
        SELECT COUNT(*)
        FROM {role_assignments} ra
        JOIN {user} u ON u.id = ra.userid
        WHERE ra.roleid = 5
    ");
    $total_cidades = $DB->count_records_sql("
        SELECT COUNT(DISTINCT(city))
        FROM {user} 
        WHERE city IS NOT NULL AND city <> ''
    ");
    $total_categorias_nivel1 = $DB->count_records('course_categories', ['parent' => 0]);

    return [
        //'total_cursos' => $total_cursos,
        'total_alunos' => $total_alunos,
        'total_cidades' => $total_cidades,
        'total_categorias_nivel1' => $total_categorias_nivel1
    ];
}

function theme_mooze_popular_courses() {
    global $DB, $OUTPUT;

    $courses = $DB->get_records_sql("
        SELECT c.id, c.fullname, c.summary, c.shortname
        FROM {course} c
        LEFT JOIN {logstore_standard_log} l ON c.id = l.courseid
        WHERE c.visible = 1 AND c.id <> 1
        GROUP BY c.id
        ORDER BY COUNT(l.id) DESC
        LIMIT 4
    ");

    $courses_data = [];
    foreach ($courses as $course) {
        $url = new moodle_url('/course/view.php', ['id' => $course->id]);

        // Obtendo a imagem correta do curso
        $context = context_course::instance($course->id);
        $fs = get_file_storage();
        $files = $fs->get_area_files($context->id, 'course', 'overviewfiles', false, '', false);

        $courseimage = '';
        foreach ($files as $file) {
            if (!$file->is_directory()) { // Evita pegar diretórios
                $courseimage = moodle_url::make_pluginfile_url(
                    $file->get_contextid(),
                    $file->get_component(),
                    $file->get_filearea(),
                    $file->get_itemid(),
                    $file->get_filepath(),
                    $file->get_filename()
                )->out(false);
                
                // Remover "/0/" se estiver na URL
                $courseimage = str_replace('/0/', '/', $courseimage);
                
                break; // Pega apenas o primeiro arquivo válido
            }
        }
        // Se não encontrou imagem, usa uma padrão
        if (empty($courseimage)) {
            $courseimage = new moodle_url('/theme/mooze/pix/default-course.jpg');
        }
        // Obtendo o professor principal do curso
        $teacher = $DB->get_record_sql("
            SELECT u.id, u.firstname, u.lastname
            FROM {user} u
            JOIN {role_assignments} ra ON u.id = ra.userid
            JOIN {context} ctx ON ra.contextid = ctx.id
            JOIN {role} r ON ra.roleid = r.id
            WHERE ctx.instanceid = ? AND ctx.contextlevel = 50 AND r.shortname = 'editingteacher'
            LIMIT 1
        ", [$course->id]);

        $teachername = $teacher ? fullname($teacher) : 'Não definido';
        $teacherurl = $teacher ? new moodle_url('/user/profile.php', ['id' => $teacher->id]) : '#';

        $courses_data[] = [
            'fullname' => format_string($course->fullname),
            'shortname' => format_string($course->shortname),
            'summary' => format_text($course->summary, FORMAT_HTML),
            'courseurl' => $url->out(false),
            'courseimage' => $courseimage,
            'teachername' => $teachername,
            'teacherurl' => $teacherurl->out(false),
        ];
    }
    return $courses_data;
}
