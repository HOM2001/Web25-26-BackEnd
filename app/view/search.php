<?php
function html_search_form()
{
    return <<< HTML
    <form method="post" action="?page=search">
        <div>
            <label>Mot-clé :</label><br>
            <input name="keyword" type="text" placeholder="Ex: Informatique...">
        </div>
        
     
        <div>
            <label>Nombre de résultats :</label>
            <select name="limit">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
        </div>

        <button type="submit">Lancer la recherche</button>    
    </form>
HTML;
}

function html_result_search($press_a)
{
    if(empty($press_a))
    {
        return '<p>Aucun article disponible.</p>';
    }


    $out = "<h2>Les articles disponibles</h2>";
    $out .= "<ul>";

    foreach($press_a as $item)
    {

        $visual = $item['title_art'] ?? $item['title'] ?? 'Sans titre';


        $ident_art = $item['ident_art'] ?? $item['id'] ?? 0;

        $out .= <<< HTML
            <li>
                <a href="?page=article&ident_art=$ident_art">$visual</a>
            </li>
HTML;
    }

    $out .= "</ul>";

    return $out;
}
