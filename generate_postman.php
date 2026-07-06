<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$routes = app('router')->getRoutes();

$collection = [
    "info" => [
        "name" => "WarnetGaming API",
        "description" => "Auto-generated Postman collection for WarnetGaming",
        "schema" => "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
    ],
    "item" => [],
    "variable" => [
        [
            "key" => "base_url",
            "value" => "http://localhost:8000/api",
            "type" => "string"
        ],
        [
            "key" => "token",
            "value" => "",
            "type" => "string"
        ]
    ]
];

$folders = [];

foreach ($routes as $route) {
    $uri = $route->uri();
    
    // Only API routes
    if (!str_starts_with($uri, 'api/')) {
        continue;
    }
    
    $methods = $route->methods();
    $method = $methods[0] === 'HEAD' ? ($methods[1] ?? 'GET') : $methods[0];
    
    $parts = explode('/', $uri);
    $folderName = isset($parts[1]) ? ucfirst($parts[1]) : 'General';
    
    if (!isset($folders[$folderName])) {
        $folders[$folderName] = [
            "name" => $folderName,
            "item" => []
        ];
    }
    
    $urlParts = explode('/', str_replace('api/', '', $uri));
    
    $item = [
        "name" => "[$method] $uri",
        "request" => [
            "method" => $method,
            "header" => [
                [
                    "key" => "Accept",
                    "value" => "application/json"
                ]
            ],
            "url" => [
                "raw" => "{{base_url}}/" . str_replace('api/', '', $uri),
                "host" => ["{{base_url}}"],
                "path" => $urlParts
            ]
        ],
        "response" => []
    ];
    
    // Check auth middleware
    $middlewares = $route->middleware();
    if (in_array('auth:sanctum', $middlewares) || in_array('Illuminate\Auth\Middleware\Authenticate:sanctum', $middlewares)) {
        $item['request']['auth'] = [
            "type" => "bearer",
            "bearer" => [
                [
                    "key" => "token",
                    "value" => "{{token}}",
                    "type" => "string"
                ]
            ]
        ];
    }
    
    if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
        $item['request']['body'] = [
            "mode" => "raw",
            "raw" => "{\n    \n}",
            "options" => [
                "raw" => [
                    "language" => "json"
                ]
            ]
        ];
    }
    
    $folders[$folderName]['item'][] = $item;
}

foreach ($folders as $folder) {
    $collection['item'][] = $folder;
}

if (!is_dir(__DIR__.'/postman')) {
    mkdir(__DIR__.'/postman');
}

file_put_contents(__DIR__.'/postman/WarnetGaming.postman_collection.json', json_encode($collection, JSON_PRETTY_PRINT));
echo "Collection generated successfully.\n";
