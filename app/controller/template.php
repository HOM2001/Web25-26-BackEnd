<?php


/*
 * get the user information
 */
function ctrl_head()
{

    if (!isset($_SESSION['text_color'])) {
        $_SESSION['text_color'] = 'black';
    }
    if(!isset($_SESSION['border'])) {
        $_SESSION['border'] = 'none';
    }

    if (isset($_POST['set_color'])) {
        $_SESSION['text_color'] = $_POST['text_color'];
    }

    if (isset($_POST['set_border'])) {
        $_SESSION['border'] = $_POST['border'];
    }
    $font_color = $_SESSION['text_color'] ?? DEFAULT_FONT_COLOR;
    $border = $_SESSION['border'] ?? DEFAULT_BORDER;


    $menu = get_menu();
    return join("\n", [

        html_head($menu),
        html_settings_button(),
        form_start(),
        form_border($border),
        form_font_color($font_color),
        form_end()
    ]);



}