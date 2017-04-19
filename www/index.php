<?php

define("ROOT", realpath(__dir__."/.."));
define("DIR_IMG", 'http://'.$_SERVER['SERVER_NAME'].str_replace('index.php','',$_SERVER["PHP_SELF"])."images/");

require_once(ROOT."/app/noyau/Noyau.php");
Noyau::lancer();

 ?>
