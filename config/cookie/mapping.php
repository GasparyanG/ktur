<?php

/**
 * cookies configuration
 * 
 * by 'user' i mean casual user, who don't have any privileges!
 * 
 * @var mixed[]
 */
$COOKIE_CONFIG = [
    "user" => [
        // 30 days
        'expire'    => 60 * 60 * 24 * 30,
        // root: i.e. whole app can be traversed by this cookie
        'path'      => "/",
    ],
];