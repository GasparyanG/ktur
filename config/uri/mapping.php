<?php

$URI_CONFIG = [
    "redirection" => [
        "client_redirection" => "redirection",
    ],

    "photos" => [
        "user" => [
            "default" => "/public/photos/app-supporting-photos/user-default-photos/",
        ],

        "statement_photos" => [
            "directory" => "/public/photos/business-logic-photos/statement-photos/",
        ],
    ],

    "uri_pathes" => [
        "sign-up" => "/sign-up",
        "log-in"  => "/log-in",
        "ind-house-statement" => "/statements/ind-houses",
    ],

    "actions"   => [
        "get-actions" => [
            "statements" => "statements/",
            "basket"    => "basket/",
            "stars"     => "stars/",
        
        ],
    
        
        "post-actions"  => [
            "add-statement" => "statement-addition/",
        ],
    ],
        
    "actions_over_statements" => [
            "see-stars" => "/see-stars",
    ],
];