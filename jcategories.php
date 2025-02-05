<?php include 'includes\template\header.php'; ?>
<?php include 'includes\template\navbar.php'; ?>
<?php include 'includes\template\site-header.php'; ?>

<?php
require_once 'db.php';

// Get category from URL parameter
$category = isset($_GET['category']) ? urldecode($_GET['category']) : '';

// Get jobs for the selected category
$query = "SELECT * FROM jobs WHERE category = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $category);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$jobs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $jobs[] = $row;
}
?>
    <section class="job-list-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="mb-4">Jobs in <?= htmlspecialchars($category) ?></h2>
                    
                    <?php if (count($jobs) > 0): ?>
                        <div class="col-lg-12 col-12">
                            <?php foreach ($jobs as $job): ?>
                            <div class="job-thumb d-flex">
                                <div class="job-body d-flex flex-wrap flex-auto align-items-center">
                                    <div class="mb-3">
                                        <h4 class="job-title mb-lg-0">
                                            <a href="job_details.php?id=<?= $job['id'] ?>" class="job-title-link"><?= htmlspecialchars($job['title']) ?></a>
                                        </h4>

                                        <div class="d-flex flex-wrap align-items-center">
                                            <p class="job-location mb-0">
                                                <i class="custom-icon bi-geo-alt me-1"></i>
                                                <?= htmlspecialchars($job['location']) ?>
                                            </p>

                                            <p class="job-date mb-0">
                                                <i class="custom-icon bi-clock me-1"></i>
                                                <?= htmlspecialchars($job['job_type']) ?>
                                            </p>

                                            <p class="job-company mb-0">
                                                <i class="custom-icon bi-building me-1"></i>
                                                <?= htmlspecialchars($job['company_name']) ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="job-section-btn-wrap">
                                        <a href="job_details.php?id=<?= $job['id'] ?>" class="custom-btn btn">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">No jobs found in this category.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
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
