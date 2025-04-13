<?php
defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2024100801;        // Versão atual
$plugin->requires  = 2024100100;        // Versão mínima do Moodle requerida
$plugin->component = 'theme_mooze';     // Nome do componente
$plugin->maturity  = MATURITY_STABLE;
$plugin->release   = '1.0.0';
$plugin->dependencies = [
    'theme_boost' => 2024100700
];
