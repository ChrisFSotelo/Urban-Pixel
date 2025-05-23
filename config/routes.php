<?php
return [
    '/' => [
        'view' => 'src/features/users/views/landing_page.php',
        'allowed_roles' => [],
        'requires_session' => false,
    ],
    '/login' => [
        'view' => 'src/features/login/views/login.php',
        'allowed_roles' => [],
        'requires_session' => false,
    ],
];
