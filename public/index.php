<?php

use Jamkrindo\Lib\ConfigRouter;
use Jamkrindo\Lib\ServerApp;

$container = require __DIR__ . '/../bootstrap/app.php';
$configRouter  = $container->get(ConfigRouter::class);
if(env("APP_RUN","async") === 'async'){
    ServerApp::async();
} else {
    ServerApp::sync();
}
