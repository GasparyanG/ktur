<?php

$envVars = require __DIR__ . '/../env.php';

$host = $envVars['credentials']['db']['mysql']['host'] ?? null;
$name = $envVars['credentials']['db']['mysql']['name'] ?? null;
$user = $envVars['credentials']['db']['mysql']['user'] ?? null;
$pass = $envVars['credentials']['db']['mysql']['pass'] ?? null;

// TODO: Update with proper error handling
if ($host === null || $name === null || $user === null || $pass === null) {
    throw new RuntimeException('Environment Variables Not Properly Given!');
}


/**
 * @var mixed[] nested array meant for DRY principle
 */
$DATABASE_CONFIG = [
    // first db of 'ktur'
    "DB1" => [
        "userName"   => $user,
        "password"   => $pass,
        "dbName"     => $name,
        "serverName" => $host,
        "tables"     => [
            'users' => 'users',
            'user_components' => 'user_components',
            'ind_house_statements' => 'ind_house_statements',
            'Independent_house_photos' => 'Independent_house_photos',
        ],
    ],
];
