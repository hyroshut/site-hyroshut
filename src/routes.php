<?php
/** @var $app Slim\App */
// Routes

$app->get('/', controller("Pages", "index"));
$app->get('/download.html', controller("Pages", "index"));