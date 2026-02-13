<?php

function html_head($menu_a=[])
{
    $debug = false;

    // on génère le code html du menu, à partir de $menu_a
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
    $times = get_reading_times() ?? 0 ;
    $current_time = $_GET['time'] ?? null;
    foreach ($times as $t) {
        $m = $t['readtime_art'];
        $selected = ($current_time == $m) ? "selected" : "";

        $options_s .= "<option value='$m' $selected>$m min</option>";
    }

    $menu_s .= <<< HTML
    <form action="index.php" method="get" class="menu-reading-form">
        <input type="hidden" name="page" value="readtime">
        <select name="time" onchange="this.form.submit()">
            <option value="" disabled selected>Temps de lecture</option>
            $options_s
        </select>
    </form>
HTML;
    $menu_s .= "</ul>";
	ob_start();
	?>
	<html lang="fr">
	<head>
		<title>AWebWiz Template (MVC)</title>
        <link rel="stylesheet" href="./css/bootstrap/bootstrap.min.css" />  <!-- lib externe -->
        <link rel="stylesheet" href="./css/internal/main.css" /> <!-- lib interne / perso -->
        <script
                src="https://code.jquery.com/jquery-3.4.1.js"
                integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
                crossorigin="anonymous"></script>
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
        var_dump($_COOKIE);
		var_dump($_SESSION);
        var_dump($_GET);
        var_dump($_POST);
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


