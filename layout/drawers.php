<?php
defined('MOODLE_INTERNAL') || die();

// Define o tipo de documento HTML.
echo $OUTPUT->doctype();

// Obtém os atributos do body.
$bodyattributes = $OUTPUT->body_attributes();

// Verifica se o usuário está logado.
$loggedin = isloggedin();

// Obtém a navegação primária.
$primary = new core\navigation\output\primary($PAGE);
$renderer = $PAGE->get_renderer('core');
$primarymenu = $primary->export_for_template($renderer);

// Obtém as informações do usuário, se estiver logado.
$usercontext = [];
if ($loggedin) {
    global $USER;
    
    $usercontext = [
        'username' => fullname($USER),
        'profileimage' => $OUTPUT->user_picture($USER, ['size' => 35, 'link' => false]),
        'profileurl' => new moodle_url('/user/profile.php'),
        'messagesurl' => new moodle_url('/message/index.php'),
        'logouturl' => new moodle_url('/login/logout.php'),
        'isadmin' => is_siteadmin() // Adicione esta linha para verificar se é admin
    ];
}

// Criar o contexto para o Mustache.
$drawerscontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => \core\context\course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'bodyattributes' => $bodyattributes,
    'primarymenu' => $primarymenu['moremenu'],
    'mobileprimarynav' => $primarymenu['mobileprimarynav'],
    'usermenu' => $primarymenu['user'],
    'langmenu' => $primarymenu['lang'],
    'loggedin' => $loggedin,
    'user' => $usercontext,
    'config' => [
        'wwwroot' => $CFG->wwwroot
    ]
];

// Renderiza o template Mustache.
echo $OUTPUT->render_from_template('theme_mooze/drawers', $drawerscontext); 