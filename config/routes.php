<?php
return [
    '/' => [
        'view' => 'src/features/users/views/landing_page.php',
        'requires_session' => false,
        'allowed_roles' => [],  
    ],

    '/login' => [
        'view' => 'src/features/login/views/login.php',
        'requires_session' => false,
        'allowed_roles' => [],
    ],

    '/control_panel' => [
        'view' => 'src/features/users/views/control_panel.php',
        'requires_session' => true,
        'allowed_roles' => ['admin'],
    ],
];
