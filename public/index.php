<?php

use App\Router;
use Tracy\Debugger;

/* Call Required of the Composer Autoload to load Classes */
require_once '../vendor/autoload.php';

/* Start Sessions Feature */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/* Create the Router */
$router = new Router();

Debugger::enable();

/* Run Application */
$router->run();
