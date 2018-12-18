<?php

/**
 * @var mixed[] nested array meant for DRY principle
 */
$DATABASE_CONFIG = [
    // first db of 'ktur'
    "DB1" => [
        "userName"   => "root",
        "password"   => "gg1122!!@@",
        "dbName"     => "KturStorage",
        "serverName" => "localhost",
        "tables"     => [
            'users' => 'users',
            'user_components' => 'user_components',
            'ind_house_statements' => 'ind_house_statements',
            'Independent_house_photos' => 'Independent_house_photos',
        ],
    ],
];