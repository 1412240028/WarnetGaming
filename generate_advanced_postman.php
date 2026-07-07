<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$routes = app('router')->getRoutes();

$collection = [
    "info" => [
        "name" => "WarnetGaming API (Advanced)",
        "description" => "Advanced Postman collection with auto-token script, path variables, and sample payloads.",
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

function getSampleBody($uri, $method) {
    if ($method !== 'POST' && $method !== 'PUT' && $method !== 'PATCH') return "{\n    \n}";
    
    if ($uri === 'api/login') {
        return json_encode(["email" => "admin@example.com", "password" => "password"], JSON_PRETTY_PRINT);
    }
    if ($uri === 'api/register') {
        return json_encode(["name" => "John Doe", "email" => "john@example.com", "password" => "password", "password_confirmation" => "password"], JSON_PRETTY_PRINT);
    }
    if ($uri === 'api/pelanggans') {
        return json_encode(["user_id" => 1, "membership_id" => 1, "status" => "active"], JSON_PRETTY_PRINT);
    }
    if ($uri === 'api/booking-sessions') {
        return json_encode(["pelanggan_id" => 1, "room_id" => 1, "pc_id" => 1, "operator_id" => 1], JSON_PRETTY_PRINT);
    }
    if ($uri === 'api/food-orders') {
        return json_encode(["gaming_session_id" => 1, "pelanggan_id" => 1, "items" => [["food_beverage_id" => 1, "quantity" => 2]]], JSON_PRETTY_PRINT);
    }
    if (str_contains($uri, 'food-orders') && str_contains($uri, 'status')) {
        return json_encode(["status" => "paid"], JSON_PRETTY_PRINT);
    }
    if ($uri === 'api/payments') {
        return json_encode(["gaming_session_id" => 1, "nominal" => 50000, "method" => "cash"], JSON_PRETTY_PRINT);
    }
    if (str_contains($uri, 'games') && str_contains($uri, 'gaming-sessions')) {
        return json_encode(["game_id" => 1, "notes" => "Ranked match"], JSON_PRETTY_PRINT);
    }

    return "{\n    \n}";
}

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
    
    // Prepare URL path and variables
    $rawUriParts = explode('/', str_replace('api/', '', $uri));
    $postmanPath = [];
    $urlVariables = [];
    $rawPathStr = [];
    
    foreach ($rawUriParts as $p) {
        if (preg_match('/^{(.*?)}$/', $p, $matches)) {
            $varName = str_replace('?', '', $matches[1]);
            $postmanPath[] = ":" . $varName;
            $rawPathStr[] = ":" . $varName;
            $urlVariables[] = [
                "key" => $varName,
                "value" => "1" // default ID
            ];
        } else {
            $postmanPath[] = $p;
            $rawPathStr[] = $p;
        }
    }
    
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
                "raw" => "{{base_url}}/" . implode('/', $rawPathStr),
                "host" => ["{{base_url}}"],
                "path" => $postmanPath
            ]
        ],
        "response" => []
    ];
    
    if (count($urlVariables) > 0) {
        $item['request']['url']['variable'] = $urlVariables;
    }
    
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
    
    // Payload Body
    if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
        $item['request']['body'] = [
            "mode" => "raw",
            "raw" => getSampleBody($uri, $method),
            "options" => [
                "raw" => [
                    "language" => "json"
                ]
            ]
        ];
    }
    
    // Auto token script for Login
    if ($uri === 'api/login' && $method === 'POST') {
        $item['event'] = [
            [
                "listen" => "test",
                "script" => [
                    "type" => "text/javascript",
                    "exec" => [
                        "var jsonData = pm.response.json();",
                        "if (jsonData.token) {",
                        "    pm.collectionVariables.set(\"token\", jsonData.token);",
                        "    console.log(\"Token automatically set!\");",
                        "}"
                    ]
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

file_put_contents(__DIR__.'/postman/WarnetGaming_Advanced.postman_collection.json', json_encode($collection, JSON_PRETTY_PRINT));
echo "Advanced Collection generated successfully.\n";
