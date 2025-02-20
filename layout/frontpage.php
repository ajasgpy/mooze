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
    'loggedin' => $loggedin
];

// Renderiza o template Mustache corrigido.
echo $OUTPUT->render_from_template('theme_mooze/frontpage', $frontpagecontext);
