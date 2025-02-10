<?php
// Garante que este arquivo só pode ser acessado dentro do Moodle.
defined('MOODLE_INTERNAL') || die();



// Adiciona atributos ao <body>, como classes do tema.
$loginattributes = $OUTPUT->body_attributes();

// Cria o contexto para passar ao template Mustache.
$logincontext = [
    'sitename' => format_string($SITE->shortname, true, ['context' => \core\context\course::instance(SITEID), "escape" => false]),
    'output' => $OUTPUT,
    'loginattributes' => $loginattributes,
];

// Renderiza o template Mustache do login.
echo $OUTPUT->render_from_template('theme_mooze/login', $logincontext);

