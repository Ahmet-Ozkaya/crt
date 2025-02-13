    <?php
    require_once 'includes/header.php';
    require_once 'includes/database.php';

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode('/', $uri);

    if ($uri[1] === 'home' || 'index' || empty($uri[1])) {
        require 'home.php';
    } elseif ($uri[1] === 'employees') {
        require 'employees.php';
    } elseif ($uri[1] === 'employers') {
        require 'employers.php';
    } elseif ($uri[1] === 'jobs') {
        require 'jobs.php';
    } else {
        require '404.php';
    }

    require_once 'includes/footer.php';
    ?>

    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/counter.js"></script>
    <script src="js/custom.js"></script>

    </body>

    </html>