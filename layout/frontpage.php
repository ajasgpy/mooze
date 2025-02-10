<?php
defined('MOODLE_INTERNAL') || die(); 
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $PAGE->title; ?></title>
    <?php echo $OUTPUT->standard_head_html(); ?>
</head>
<body <?php echo $OUTPUT->body_attributes(); ?>>

    <?php echo $OUTPUT->standard_top_of_body_html(); ?>

    <div id="page">
        <div id="page-header">
            <h1><?php echo format_string($SITE->fullname); ?></h1>
        </div>

        <div id="page-content">
            <?php echo $OUTPUT->main_content(); ?> <!-- Esse é obrigatório -->
        </div>

        <div id="page-footer">
            <?php echo $OUTPUT->standard_footer_html(); ?>
        </div>
    </div>

    <?php echo $OUTPUT->standard_end_of_body_html(); ?>
</body>
</html>

