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

    if($debug)
    {
        var_dump($_GET);
        var_dump($_SESSION);
    }
    return ob_get_clean();
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


