import json
import os

with open('routes.json', 'r') as f:
    routes = json.load(f)

collection = {
    "info": {
        "name": "WarnetGaming API",
        "description": "Auto-generated Postman collection for WarnetGaming",
        "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
    },
    "item": [],
    "variable": [
        {
            "key": "base_url",
            "value": "http://localhost:8000/api",
            "type": "string"
        },
        {
            "key": "token",
            "value": "",
            "type": "string"
        }
    ]
}

folders = {}

for route in routes:
    uri = route.get('uri', '')
    if not uri.startswith('api/'):
        continue
    
    methods = route.get('method', '').split('|')
    method = methods[0] if methods else 'GET'
    if method == 'HEAD':
        if len(methods) > 1:
            method = methods[1]
        else:
            continue
            
    name = route.get('name') or uri
    
    # Simple grouping
    parts = uri.split('/')
    folder_name = parts[1] if len(parts) > 1 else 'general'
    
    if folder_name not in folders:
        folders[folder_name] = {
            "name": folder_name.capitalize(),
            "item": []
        }
    
    # URL parsing
    url_parts = uri.replace('api/', '').split('/')
    path = ["{{base_url}}"] + url_parts
    
    # Auth
    auth = None
    if 'middleware' in route and isinstance(route['middleware'], list):
        if any('sanctum' in m for m in route['middleware']):
            auth = {
                "type": "bearer",
                "bearer": [
                    {
                        "key": "token",
                        "value": "{{token}}",
                        "type": "string"
                    }
                ]
            }

    item = {
        "name": f"[{method}] {uri}",
        "request": {
            "method": method,
            "header": [
                {
                    "key": "Accept",
                    "value": "application/json"
                }
            ],
            "url": {
                "raw": "{{base_url}}/" + uri.replace('api/', ''),
                "host": ["{{base_url}}"],
                "path": url_parts
            }
        },
        "response": []
    }
    
    if auth:
        item["request"]["auth"] = auth
        
    if method in ['POST', 'PUT', 'PATCH']:
        item["request"]["body"] = {
            "mode": "raw",
            "raw": "{\n    \n}",
            "options": {
                "raw": {
                    "language": "json"
                }
            }
        }
        
    folders[folder_name]["item"].append(item)

for folder in folders.values():
    collection["item"].append(folder)

os.makedirs('postman', exist_ok=True)
with open('postman/WarnetGaming.postman_collection.json', 'w') as f:
    json.dump(collection, f, indent=4)

print("Collection generated at postman/WarnetGaming.postman_collection.json")
