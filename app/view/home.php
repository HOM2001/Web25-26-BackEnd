<?php

/**
 * build <body>
 * @param $user
 * @param $role
 */
function html_body()
{
	ob_start();
	?>

    <?php
	return ob_get_clean();
}


