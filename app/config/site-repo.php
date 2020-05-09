<?php
return [
    // Where our data lives in file system
    'database' => __DIR__ . '/../../database',
    'database_data' => __DIR__ . '/../../database/html',
    // Name of the xml file with site meta info
    'site_inf' => 'site-inf.xml',
    // Name of the xml file with menu definition
    'menu_inf' => 'menu-inf.xml',
    // Name of the xml file with directory meta info
    'meta_inf' => 'meta-inf.xml',
    // Name of the xml file with user definition
    'user_inf' => 'user-inf.xml',
    // Content mime to show
    'contentMime' => [
        'text/plain',
        'text/html',
    ],
    // Content mime to view
    'fileViewable' => [
        'image/png',
        'image/jpeg',
        'application/pdf',
    ],
    // This names are for internal purposes
    'reservedNames' => [
        'meta-inf',
        'footer',
        'header',
        'files',
        'site-inf.xml',
        'menu-inf.xml',
        'meta-inf.xml',
        'user-inf.xml',
    ],
];
