<?php
require_once 'db.php';

if(isset($_GET['id'])) {
    $employee_id = $_GET['id'];
    $query = "SELECT e.*, u.email
              FROM employees e
              JOIN users u ON e.user_id = u.id
              WHERE e.id = $employee_id";
    $result = mysqli_query($conn, $query);
    $employee = mysqli_fetch_assoc($result);

    if($employee) {
        include 'includes/template/header.php';
        include 'includes/template/navbar.php';
        include 'includes/template/site-headerjd.php';
        $employee_id = $employee['id'];
        include 'employee_profile.php';
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