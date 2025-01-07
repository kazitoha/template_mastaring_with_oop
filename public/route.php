<?php

// Include common layout parts
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/views/layout/header.php';
require_once __DIR__ . '/../app/views/layout/sidebar.php';
require_once __DIR__ . '/../config/Database.php';


// Default page to load
$page = $_GET['page'] ?? 'dashboard';

if (isset($_GET['page'])) {
    $page = $_GET['page'];

    switch ($page) {
        case 'dashboard':
            include __DIR__ . '/../app/views/dashboard.php';
            break;
        case 'user':
            include __DIR__ . '/../app/views/user.php';
            break;
        case 'testing':
            include __DIR__ . '/../app/views/trsting.php';
            break;
        case 'editUser':
            include __DIR__ . '/../app/views/editUser.php';
            break;
        default:
            include __DIR__ . '/../app/views/404.php';
            break;
    }
    exit;
}


// Include footer
require_once __DIR__ . '/../app/views/layout/footer.php';
