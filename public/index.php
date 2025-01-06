<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../autoloader.php';



require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/views/inc/header.php';
require_once __DIR__ . '/../app/views/inc/sidebar.php';

// Default page load
$page = $_GET['page'] ?? 'dashboard';
?>

<div id="main-content" class="main-content">
    <section class="section">
        <!-- The content will be dynamically loaded here by JavaScript -->
    </section>
</div>

<?php
require_once __DIR__ . '/../app/views/inc/footer.php';
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function loadPage(page) {
            const mainContent = document.getElementById("main-content");

            // Display loading spinner (optional)
            mainContent.innerHTML = '<div>Loading...</div>';

            // Perform AJAX request to fetch page content
            fetch(`route.php?page=${page}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    // Replace the content dynamically
                    mainContent.innerHTML = html;
                })
                .catch(error => {
                    mainContent.innerHTML = `<div>Error: ${error.message}</div>`;
                });
        }

        // Trigger page load on navigation link click
        document.querySelectorAll(".nav-link").forEach(link => {
            link.addEventListener("click", function(e) {
                e.preventDefault(); // Prevent default link behavior
                const page = this.getAttribute("data-page"); // Get page name from data attribute
                loadPage(page);
            });
        });

        // Load the default page
        loadPage("<?php echo $page; ?>");
    });
</script>