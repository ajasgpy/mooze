<?php
// Arquivo de configuração do tema Mooze

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

$THEME->name = 'mooze'; // Nome do tema
$THEME->parents = ['boost']; // Herdamos do tema Boost
$THEME->sheets = ['settings/frontpage', 'settings/navbar', 'settings/footer', 'settings/login'];
$THEME->editor_sheets = [];
$THEME->scss = function(theme_config $theme) {
    return theme_mooze_get_main_scss_content($theme);
};

// Definição de layouts
$THEME->layouts = [
   'frontpage' => [
        'file' => 'frontpage.php',
        'regions' => ['side-pre'],
        'defaultregion' => 'side-pre',
        
    ],
    'login' => [
        'file' => 'login.php',
        'regions' => [],
        'options' => ['langmenu' => true],
    ],
    'forgotpassword' => [
        'file' => 'login.php',
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

// This is an old setting used to load specific CSS for some YUI JS. We don't need it in Boost based themes.
$THEME->yuicssmodules = array();

// Remove previous javascripts_footer setting if exists
// $THEME->javascripts_footer = ['navbar']; // Remover esta linha
$THEME->javascripts_footer = ['dropdown'];

// Additional theme options.
$THEME->supportscssoptimisation = false;

$THEME->javascripts_footer = array('custom');

// Configurações essenciais para JavaScript
$THEME->javascripts = array(); // JavaScript carregado no <head>

$THEME->usefallback = true; // Permite fallback para JavaScript não-AMD
$THEME->enable_jquery = true; // Habilita jQuery globalmente

$THEME->requiredblocks = '';
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;

$THEME->javascripts = [];
$THEME->javascripts_footer = [];
$THEME->enable_jquery = true;
$THEME->callbacks = ['page_init' => 'theme_mooze_page_init'];




