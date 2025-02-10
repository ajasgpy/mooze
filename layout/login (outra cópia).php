<?php
// Garante que este arquivo só pode ser acessado dentro do Moodle.
defined('MOODLE_INTERNAL') || die();

// Exibe o doctype HTML5.
echo $OUTPUT->doctype();
?>
<html <?php echo $OUTPUT->htmlattributes(); ?>> 
<head>
    <title><?php echo format_string($SITE->fullname); ?></title> 
    <?php echo $OUTPUT->standard_head_html(); // Inclui estilos e scripts padrão do Moodle ?>
</head>
<body class="login-page">
    <?php echo $OUTPUT->standard_top_of_body_html(); // Adiciona hooks do Moodle no início do body ?>

    <div class="container-login">
        <div class="login-box">
            <h2>Acessar Plataforma</h2>
            <?php echo $OUTPUT->main_content(); // Renderiza o formulário de login padrão do Moodle ?>
        </div>
    </div>

    <?php echo $OUTPUT->standard_end_of_body_html(); // Adiciona scripts e rodapé padrão do Moodle ?>
</body>
</html>

