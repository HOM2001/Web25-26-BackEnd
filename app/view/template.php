<?php

function html_head($menu_a=[])
{
    $debug = false;

    $menu_s = <<< HTML
        <ul class="menu">
HTML;
    if(MENU_TYPE == "csv"){
        foreach( $menu_a as $menu_item)
        {
            $visual = $menu_item[0];
            $comp = $menu_item[1];
            $subcomp = $menu_item[2] ?? '';
            $menu_s .= <<< HTML
            <li>
                <a href="?page=$comp&subpage=$subcomp">
                    $visual
                </a>            
            </li>
HTML;
        }
    }   else if(MENU_TYPE == "database"){
        foreach ($menu_a as $item) {
            $link = str_replace('?page=', '', $item[1]);
            $menu_s .= "<li><a href='?page={$link}'>{$item[0]}</a></li>";
        }
    }
    $options_s = "";
    $times = get_reading_times() ?: [] ;
    $current_time = $_GET['time'] ?? null;
    foreach ($times as $t) {
        $m = $t['readtime_art'];
        $selected = ($current_time == $m) ? "selected" : "";
        $options_s .= "<option value='$m' $selected>$m min</option>";
    }


    $show_articles = $_SESSION['show_main_articles'] ?? true;
    $btn_text = $show_articles ? "Masquer la Une" : "Afficher la Une";


    $menu_s .= <<< HTML
    <li class="menu-tools">
        <form action="index.php" method="get" class="menu-reading-form" style="display:inline;">
            <input type="hidden" name="page" value="readtime">
            <select name="time" onchange="this.form.submit()">
                <option value="" >Temps de lecture</option>
                $options_s
            </select>
        </form>
        </li> 
       <li> 
       <a href="?action=toggle_display" class="btn-toggle-view">$btn_text</a>
       </li>
HTML;

    $menu_s .= "</ul>";

    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <title>AWebWiz Template (MVC)</title>
        <link rel="stylesheet" href="./css/bootstrap/bootstrap.min.css" />
        <link rel="stylesheet" href="./css/internal/main.css" />
        <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
        <script src="./js/quirks/QuirksMode.js"></script>
        <script src="./js/internal/favorite.js"></script>
        <script src="./js/internal/counter.js"></script>
    </head>
    <body>
    <header>
        <h1>
            France 24 (MVC)
            <img src="./icon/icon3.png">
        </h1>
        <?=$menu_s?>

    </header>
    <?php
    echo style_sheet_font_color($_SESSION['text_color']);
    echo style_sheet_border($_SESSION['border']);
    if($debug)
    {
        var_dump($_GET);
        var_dump($_SESSION);
    }
    return ob_get_clean();
}
function form_start(){
    $html = <<< HTML
        <div>
            <br>
    HTML;
    return $html;
}

function form_end(){
    $html = <<< HTML
        </div>
    HTML;
    return $html;
}
function html_foot()
{
	ob_start();
	?>
        <hr />
        <footer>
            Made with the amazing AWebWiz framework
<footer>
	</body>
	</html>
	<?php
	return ob_get_clean();
}
function form_font_color($font_color)
{
    $html = <<< HTML
    <div class="container-fluid mb-3">
        <form method="POST">
            <label>Sélectionnez la taille du texte :</label>
            <select id="text_color" name="text_color">
                <option value="black" " . ($font_color === 'black' ? 'selected' : '') . ">Noir</option>
                <option value="blue" " . ($font_color === 'blue' ? 'selected' : '') . ">Blue</option>
                <option value="red" " . ($font_color === 'red' ? 'selected' : '') . ">Rouge</option>
            </select>
            <button name="set_color" type="submit">Changer</button>
        </form>
    </div>
HTML;

    return $html;
}
function form_border($border):string
{
    $html = <<< HTML
    <div class="container-fluid mb-3">
        <form method="POST">
            <label>Sélectionnez le type de bordure :</label>
            <select id="border" name="border">
                <option value="none" " . ($border === 'none' ? 'selected' : '') . ">Sans bordure</option>
                <option value="thin" " . ($border === 'thin' ? 'selected' : '') . ">Fine bordure</option>
                <option value="thick" " . ($border === 'thick' ? 'selected' : '') . ">Epaisse bordure</option>
            </select>
            <button name="set_border" type="submit">Changer</button>
        </form>
    </div>
HTML;

    return $html;
}
function style_sheet_font_color($font_color = 'black') {

    $val = (in_array($font_color, ['black', 'blue', 'red'])) ? $font_color : 'black';

    return <<<HTML
    <style>
        body{
            color: $val !important;
        } 
    </style>
HTML;
}
function style_sheet_border($border = DEFAULT_BORDER)
{
    $border_style = ($border === 'none') ? 'none' : "$border solid black";

    $html = <<< HTML
<style>
body{
    border: $border_style !important;
}
</style>
HTML;

    return $html;
}


