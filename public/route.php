<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// require_once '../autoloader.php';    
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../app/helpers.php';

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $controller = new HomeController();

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
