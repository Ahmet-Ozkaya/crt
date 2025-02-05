<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include 'site-header.php'; ?>

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
                        <div class="row">
                            <?php foreach ($jobs as $job): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card job-card">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($job['title']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($job['company_name']) ?></p>
                                        <p class="card-text"><?= htmlspecialchars($job['location']) ?></p>
                                        <p class="card-text"><?= htmlspecialchars($job['job_type']) ?></p>
                                        <a href="job_details.php?id=<?= $job['id'] ?>" class="btn btn-primary">View Details</a>
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
    <?php include 'footerbanner.php'; ?>
    <?php include 'footer.php'; ?>
            <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/counter.js"></script>
        <script src="js/custom.js"></script>

</body>
</html>
