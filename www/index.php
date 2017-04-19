<?php

session_start();

define("ROOT", realpath(__dir__."/.."));
define("WEB_ROOT", 'http://'.$_SERVER['SERVER_NAME'].str_replace('index.php','',$_SERVER["PHP_SELF"]));
define("DIR_IMG", 'http://'.$_SERVER['SERVER_NAME'].str_replace('index.php','',$_SERVER["PHP_SELF"])."images/");
define("DIR_STYLES", 'http://'.$_SERVER['SERVER_NAME'].str_replace('index.php','',$_SERVER["PHP_SELF"])."styles/");

require_once(ROOT."/app/noyau/Noyau.php");
Noyau::lancer();
 ?>
