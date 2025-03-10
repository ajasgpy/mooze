<?php
defined('MOODLE_INTERNAL') || die();

// Obtém os atributos do body.
$frontpageattributes = $OUTPUT->body_attributes();

// Verifica se o usuário está logado.
$loggedin = isloggedin();

// Obtém a navegação primária.
$primary = new core\navigation\output\primary($PAGE);
$renderer = $PAGE->get_renderer('core');
$primarymenu = $primary->export_for_template($renderer);

// Obtém a navegação secundária, se existir.
$secondarynavigation = false;
if ($PAGE->has_secondary_navigation()) {
    $secondary = $PAGE->secondarynav;
    if ($secondary->get_children_key_list()) {
        $moremenu = new \core\navigation\output\more_menu($secondary, 'nav-tabs', true);
        $secondarynavigation = $moremenu->export_for_template($OUTPUT);
    }
}

// Obtém as informações do usuário, se estiver logado.
$usercontext = [];
if ($loggedin) {
    global $USER;
    
    $usercontext = [
        'username' => fullname($USER), // Nome completo do usuário
        'profileimage' => $OUTPUT->user_picture($USER, ['size' => 35, 'link' => false]), // Imagem de perfil do usuário
        'profileurl' => new moodle_url('/user/profile.php'), // Link para o perfil do usuário
        'messagesurl' => new moodle_url('/message/index.php'), // Link para mensagens
        'logouturl' => new moodle_url('/login/logout.php') // Link para logout
    ];
}

// Criar o contexto para o Mustache.
$frontpagecontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => \core\context\course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'frontpageattributes' => $frontpageattributes,
    'primarymenu' => $primarymenu['moremenu'],
    'mobileprimarynav' => $primarymenu['mobileprimarynav'],
    'secondarymoremenu' => $secondarynavigation ?: false,
    'usermenu' => $primarymenu['user'],
    'langmenu' => $primarymenu['lang'],
    'loggedin' => $loggedin,
    'user' => $usercontext // Adiciona as informações do usuário ao contexto
];

// Renderiza o template Mustache corrigido.
echo $OUTPUT->render_from_template('theme_mooze/frontpage', $frontpagecontext);
