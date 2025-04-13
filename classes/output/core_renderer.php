<?php
namespace theme_mooze\output;

use moodle_page;
use html_writer;

class core_renderer extends \theme_boost\output\core_renderer {
    public function standard_head_html() {
        global $CFG, $PAGE;
        
        // Carregar scripts essenciais do Moodle
        $PAGE->requires->jquery();
        $PAGE->requires->js_call_amd('core/first');
        $PAGE->requires->js_call_amd('theme_mooze/dropdown', 'init');
        
        // Carregar o head HTML padrão do Boost
        $output = parent::standard_head_html();
        return $output;
    }

    /**
     * Get the HTML for the settings navigation.
     *
     * @return string HTML to display
     */
    public function navbar(): string {
        // Garantir que o JavaScript seja carregado para a navbar
        $this->page->requires->js_call_amd('theme_mooze/dropdown', 'init');
        
        return parent::navbar();
    }

    public function footer() {
        global $CFG, $PAGE;
        
        // Carregar o footer padrão do Boost
        $output = parent::footer();
        return $output;
    }
} 