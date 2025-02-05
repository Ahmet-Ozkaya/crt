<?php
require_once 'db.php';

if(isset($_GET['id'])) {
    $job_id = $_GET['id'];
//    $query = "SELECT e.*, u.email FROM employees e JOIN users u ON e.user_id = u.id WHERE e.id = $job_id";
$query = "SELECT `jobs`.`id`, `jobs`.`employee_id`, `employees`.`user_id`, `employees`.`full_name`,
 `users`.`email`, `jobs`.`title`, `jobs`.`description`, `jobs`.`employer_id`, `jobs`.`start_date`, `jobs`.`end_date` FROM `jobs` LEFT JOIN `employees` ON `jobs`.`employee_id` = `employees`.`id` LEFT JOIN `users` ON `employees`.`user_id` = `users`.`id` WHERE `jobs`.`id` = $job_id";
    $result = mysqli_query($conn, $query);
    $job = mysqli_fetch_assoc($result);

    if($job) {
        include 'includes/template/header.php';
        include 'includes/template/navbar.php';
        include 'includes/template/site-headerjd.php';
        $job_id = $job['id'];
        include 'job_profile.php';
        include 'includes/template/footerbanner.php';
        include 'includes/template/footer.php';
    } else {
        include 'includes/template/header.php';
        include 'includes/template/navbar.php';
        echo '<div class="container my-5"><div class="alert alert-danger">Employee not found</div></div>';
        include 'includes/template/footer.php';
    }
} else {
    include 'includes/template/header.php';
    include 'includes/template/navbar.php';
    echo '<div class="container my-5"><div class="alert alert-danger">Invalid employee ID</div></div>';
    include 'includes/template/footer.php';
}
?>

<!-- JAVASCRIPT FILES -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/counter.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
