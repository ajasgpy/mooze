<?php
namespace theme_mooze\util;

class theme_settings {
    public static function init() {
        global $PAGE;
        
        // Configurações básicas
        $PAGE->requires->jquery();
        $PAGE->requires->js_call_amd('core/first');
        
        // Scripts específicos do tema
        if ($PAGE->pagelayout !== 'login') {
            $PAGE->requires->js_call_amd('theme_mooze/dropdown', 'init');
        }
    }
} 