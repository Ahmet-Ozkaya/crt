<?php
require_once 'db.php';

// Define the number of rows per page
$rowsPerPage = 5;

// Get the current page number from the URL, default to 1 if not set
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Get search parameters from the URL
$jobTitle = isset($_GET['job-title']) ? $_GET['job-title'] : '';
$jobLocation = isset($_GET['job-location']) ? $_GET['job-location'] : '';
$JobDate = isset($_GET['job-date']) ? $_GET['job-date'] : '';

// Calculate the offset
$offset = ($currentPage - 1) * $rowsPerPage;

// Build the query based on search parameters
/* $query = "SELECT * FROM employees WHERE 1=1";
if (!empty($jobTitle)) {
    $query .= " AND job_title LIKE '%$jobTitle%'";
}
if (!empty($jobLocation)) {
    $query .= " AND location LIKE '%$jobLocation%'";
}
 */

//New Query to get the employees who have not been booked
$query = "SELECT `employees`.`id`, `employees`.`user_id`, `employees`.`full_name`, `employees`.`bio_photo`, `employees`.`location`, `employees`.`job_title`, `employees`.`job_type_preference`, `bookings`.`booking_id`, `bookings`.`employee_id`, `bookings`.`booking_date`, `bookings`.`status`, `bookings`.`start_time`, `bookings`.`end_time` FROM `employees` 
LEFT JOIN `bookings` ON `bookings`.`employee_id` = `employees`.`user_id` 
WHERE `bookings`.`status` IS NULL";

if (!empty($jobTitle)) {
    $query .= " AND job_title LIKE '%$jobTitle%'";
}
if (!empty($jobLocation)) {
    $query .= " AND location LIKE '%$jobLocation%'";
}
if (!empty($JobDate)) {
    $query .= " AND booking_date = '$JobDate'";
}


$query .= " ORDER BY id DESC LIMIT $offset, $rowsPerPage";

$result = mysqli_query($conn, $query);

// Query to get the total number of employees based on search parameters
$totalQuery = "SELECT COUNT(*) as total FROM employees WHERE 1=1";
if (!empty($jobTitle)) {
    $totalQuery .= " AND job_title LIKE '%$jobTitle%'";
}
if (!empty($jobLocation)) {
    $totalQuery .= " AND location LIKE '%$jobLocation%'";
}
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalEmployees = $totalRow['total'];

// Calculate the total number of pages
$totalPages = ceil($totalEmployees / $rowsPerPage);
?>
<?php include 'includes\template\header.php'; ?>
<?php include 'includes\template\navbar.php'; ?>

<section class="job-section job-featured-section section-padding" id="job-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12 text-center mx-auto mb-4">
                <h2>Search Results</h2>
            </div>

            <div class="col-lg-12 col-12">
                <?php while ($employee = mysqli_fetch_assoc($result)): ?>
                    <div class="job-thumb d-flex">
                        <div class="job-image-wrap bg-white shadow-lg">
                            <img src="<?= $employee['bio_photo'] ?>" class="job-image img-fluid" alt="<?= $employee['full_name'] ?>">
                        </div>

                        <div class="job-body d-flex flex-wrap flex-auto align-items-center ms-4">
                            <div class="mb-3">
                                <h5 class="job-title mb-lg-0">
                                    <a href="employee_details.php?id=<?= $employee['id'] ?>" class="job-title-link"><?= $employee['full_name'] ?></a>
                                </h5>
                                <h6 class="job-title mb-lg-0">
                                    <a href="employee_details.php?id=<?= $employee['id'] ?>" class="job-title-link">[<?= $employee['job_title'] ?>]</a>
                                </h6>

                                <div class="d-flex flex-wrap align-items-center">
                                    <p class="job-location mb-0">
                                        <i class="custom-icon bi-geo-alt me-1"></i>
                                        <?= $employee['location'] ?>
                                    </p>

                                    <p class="job-date mb-0">
                                        <i class="custom-icon bi-clock me-1"></i>
                                        <?= $employee['booking_date'] ?>
                                    </p>

                                    <div class="d-flex align-items-start">
                                        <p class="mb-0">
                                            <a href="#" class="badge badge-level"><?= $employee['status'] ? $employee['status'] : 'Available' ?></a>
                                        </p>

                                        <p class="job-price mb-0">
                                            <i class="custom-icon bi-cash me-1"></i>
                                            400
                                        </p>

                                        <p class="mb-0">
                                            <a href="#" class="badge"><?= $employee['job_type_preference'] ?></a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="job-section-btn-wrap">
                                <a href="employee_details.php?id=<?= $employee['id'] ?>" class="custom-btn btn">Message</a>
                            </div>

                            <div class="job-section-btn-wrap">
                                <a href="employee_details.php?id=<?= $employee['id'] ?>" class="custom-btn btn">Book CRT</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center mt-5">
            <li class="page-item <?php if ($currentPage == 1) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?= $currentPage - 1 ?>&job-title=<?= urlencode($jobTitle) ?>&job-location=<?= urlencode($jobLocation) ?>" aria-label="Previous">
                    <span aria-hidden="true">Prev</span>
                </a>
            </li>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php if ($i == $currentPage) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?= $i ?>&job-title=<?= urlencode($jobTitle) ?>&job-location=<?= urlencode($jobLocation) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?php if ($currentPage == $totalPages) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?= $currentPage + 1 ?>&job-title=<?= urlencode($jobTitle) ?>&job-location=<?= urlencode($jobLocation) ?>" aria-label="Next">
                    <span aria-hidden="true">Next</span>
                </a>
            </li>
        </ul>
    </nav>
</section>
<?php include 'includes\template\footerbanner.php'; ?>
<?php include 'includes\template\footer.php'; ?>
<!-- JAVASCRIPT FILES -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/counter.js"></script>
<script src="js/custom.js"></script>

</body>

</html>