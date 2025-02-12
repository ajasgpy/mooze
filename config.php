<?php
// Arquivo de configuração do tema Mooze

defined('MOODLE_INTERNAL') || die(); // Impede acesso direto ao arquivo

$THEME->name = 'mooze'; // Nome do tema
$THEME->parents = ['boost']; // Herdamos do tema Boost
$THEME->sheets = [];
$THEME->scss = function(theme_config $theme) {
    return theme_mooze_get_main_scss_content($theme);
};

// Definição de layouts
$THEME->layouts = [
    'login' => [
        'file' => 'login.php',
        'regions' => [],
        'options' => ['langmenu' => true],
    ],
    'forgotpassword' => [
        'file' => 'login.php', // Garante que a página de recuperação de senha use o mesmo template
        'regions' => [],
        'options' => ['langmenu' => true],
    ],
];


// Ativa o sistema de ícones FontAwesome
$THEME->iconsystem = 'fontawesome';

// Define a fábrica de renderização para sobrescrita de renderers do Moodle
$THEME->rendererfactory = 'theme_overridden_renderer_factory';

// Remove a funcionalidade de docking (painel lateral antigo do Moodle)
$THEME->enable_dock = false;

