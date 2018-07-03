<?php

return [
    "titles" => [
        "demo" => [
            "manage" => "Manage demo "
        ],
        "provine_city" => [
            "manage" => "Manage Provice City",
            "create" => "Create Provice City",
            "edit" => "Edit Provice City",
        ],
        "country_district" => [
            "manage" => "Manage Country District",
            "create" => "Create Country District",
            "edit" => "Edit Country District",
        ],
        "commune_guild" => [
            "manage" => "Manage Commune Guild",
            "create" => "Create Commune Guild",
            "edit" => "Edit Commune Guild",
        ],
    ],
    "table" => [
        "id" => "#",
        "created_at" => "Created at",
        "updated_at" => "Updated at",
        "action" => "Actions",
        "demo" => [
            "name" => "Name"
        ],
        "provine_city"=>[
            "name" => "Name",
            "type" => "Type",
            "name_with_type" => "Name With Type",
            "code" =>"Code"
        ],
        "country_district"=>[
            "name" => "Name",
            "provine_city" => "Provine City",
            "type" => "Type",
            "name_with_type" => "Name With Type",
            "path"=>"Path",
            "path_with_type"=>"Path with type",
            "code" =>"Code"
        ],
         "commune_guild"=>[
            "name" => "Name",
            "country_district" => "Country District",
            "type" => "Type",
            "name_with_type" => "Name With Type",
            "path"=>"Path",
            "path_with_type"=>"Path with type",
            "code" =>"Code"
        ]
    ],
    "buttons" => [
        "create" => "Create",
        "discard" => "Discard",
        "update" => "Update"
    ],
    "placeholder" => [
        "demo" => [
            "name_here" => "Name here..."
        ],
        "provine_city"=>[
            "name" => "Name here...",
            "type" => "Type here...",
            "name_with_type" => "Name with type here...",
            "code" =>"Code here..."
        ],
        "country_district"=>[
            "name" => "Name here...",
            "type" => "Type here...",
            "name_with_type" => "Name with type here...",
            "path"=> "Path here...",
            "path_with_type"=> "Path with type here...",
            "code" => "Code here..."
        ],
        "commune_guild"=>[
            "name" => "Name here...",
            "type" => "Type here...",
            "name_with_type" => "Name with type here...",
            "path"=> "Path here...",
            "path_with_type"=> "Path with type here...",
            "code" => "Code here..."
        ]
    ],
    "messages" => [
        "success" => [
            "create" => "Create successfully",
            "update" => "Update successfully",
            "delete" => "Delete successfully"
        ],
        "error" => [
            "permission" => "Permission lock",
            "create" => "Create failed",
            "update" => "Update failed",
            "delete" => "Delete failed"
        ]
    ]
];