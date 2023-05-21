<?php

$routes = [

    '/upload' => [UploadController::class, 'index', [TokenMiddleware::class]],

    '/error' => function () {
        return 'Could not find this page.';
    },

];