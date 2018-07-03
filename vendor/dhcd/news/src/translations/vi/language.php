<?php

return [
    "titles" => [
        "demo" => [
            "manage" => "Manage demo"
        ],
        "news"=>[
            "add" => "Add news",
            "list"=> "List news",
            "edit"=> "Edit news"
        ],
        "news_cat"=>[
            "add" => "Add news category ",
            "list"=> "List news category",
            "edit"=> "Edit news category"
        ]
    ],
    "table" => [
        "id" => "Stt",
        "created_at" => "Created at",
        "updated_at" => "Updated at",
        "action" => "Actions",
        "list_news" => [
            "title"=>"Title",
            "author"=>"Author",
            "category"=>"Category",
            "status"=>"Status",
            'is_hot'=>"News hot",
            'priority'=> "Sort",
            'image'=> "Image",
        ],
        "list_news_cat"=>[
            "title_cat_paren"=>"Category Parent"
        ]
    ],
    "form"=>[
        "tags_placeholder"=>"Enter tags here",
        "desc_placeholder"=>"Enter descipton here",
        "title_placeholder"=>"Enter title here",
        "seo_key_word_placeholder"=>"Enter seo keywords here",
        "desc_seo_placeholder"=>"Enter seo keywords here",
        "priority_placeholder"=>"Enter priority here",
        "content_placeholder"=>"Enter content here",
        "text"=>[
            "title" => "Title",
            "desc" => "Decription",
            "content" => "Content",
            "cat" => "Category",
            "tag" => "Tag",
            "image" => "Images Display",
            "news_hot" => "News hot",
            "news_normal" => "News normal",
            "priority" => "priority",
            "key_seo" => "List key seo",
            "desc_seo" => "Decription seo"
        ],
    ],
    "label_cat"=>[
        "name_category" => "Name category",
        "checkbox" => "Child Category",   
    ],
    "form_cat"=>[
        "category_placeholder" => "Enter name category here",   
    ],
    "buttons" => [
        "create" => "Create",
        "update"=> "Update",
        "discard" => "Discard",
        "select_image"=> "Select Image",
        "change_image"=>"Change Image",
        "remove_image"=>"Remove Image",
        "search"=>"Search"
    ],
    "placeholder" => [
        "demo" => [
            "name_here" => "Name here..."
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