<?php

// Load configuration and helpers
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/helpers.php';

require_once __DIR__ . '/../app/views/inc/header.php';
require_once __DIR__ . '/../app/views/inc/sidebar.php';


$controller = new HomeController();

// Determine the requested page (default is 'home')
$page = $_GET['page'] ?? 'home';

?>

<div class="main-content">
    <section class="section">
        <?php
        // Output the correct template
        switch ($page) {
            case 'dashboard':
                $controller->dashboard();
                break;
            case 'about':
                include __DIR__ . '/../app/views/about.php';
                break;
            case 'contact':
                include __DIR__ . '/../app/views/contact.php';
                break;
            default:
                include __DIR__ . '/../app/views/404.php';
                break;
        }
        ?>


    </section>
</div>

<?php

require_once __DIR__ . '/../app/views/inc/footer.php';

?>