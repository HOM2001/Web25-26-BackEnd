<?php

const MACHINE = "MAMP"; // MAMP , WAMP

const DATABASE_TYPE =  "MySql"; // "MySql";  // "csv" // "json"
const DATABASE_NAME = "press_2025_v05";

switch(MACHINE) {

	case "WAMP":
		define( "DATABASE_PORT", 3306 );
		define( "DATABASE_USERNAME", "root" );
		define( "DATABASE_PASSWORD", "" );
		break;
	case "MAMP":
		define( "DATABASE_PORT", 3306 );
		define( "DATABASE_USERNAME", "root" );
		define( "DATABASE_PASSWORD", "root" );
		break;
}

const DATABASE_DSN =  "mysql:host=localhost;dbname=".DATABASE_NAME.";port=".DATABASE_PORT.";charset=utf8mb4;";

// var_dump(DSN);
