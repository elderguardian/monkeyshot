<?php

$routes = [

    '/upload' => [UploadController::class, 'index', [TokenMiddleware::class]],
    '/' => [ViewController::class, 'index'],

    '/error' => function () {
        return 'Could not find this page.';
    },

];