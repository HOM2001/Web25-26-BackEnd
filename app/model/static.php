<?php

function get_static_contents($static_name)
{
    if(MENU_TYPE=="csv"){
        $content_s = file_get_contents("../asset/static_content/$static_name.html");
        return $content_s;
    }elseif(MENU_TYPE=="database"){

            $sql = "SELECT title_static, content_static FROM t_static_page WHERE name_static = :static_name";
            $params = ['static_name' => $static_name];

            $res = db_select_prepare($sql, $params);


            return $res[0] ?? false;

    }

}

