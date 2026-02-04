<?php
function html_search_form()
{
    return <<< HTML
    <form method="get" action="?page=search">
        <div style="margin-bottom:10px">
            <label>Mot-clé :</label><br>
            <input name="keyword" type="text" placeholder="Ex: Informatique...">
        </div>
        
     
        <div style="margin-bottom:10px">
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