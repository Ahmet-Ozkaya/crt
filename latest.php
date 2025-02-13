<?php
require_once 'db.php';

// Define the number of rows per page
$rowsPerPage = 5;

// Get the current page number from the URL, default to 1 if not set
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset
$offset = ($currentPage - 1) * $rowsPerPage;

// Query to fetch employees with pagination
$query = "SELECT * FROM employees ORDER BY id DESC LIMIT $offset, $rowsPerPage";
$result = mysqli_query($conn, $query);

// Query to get the total number of employees
$totalQuery = "SELECT COUNT(*) as total FROM employees";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalEmployees = $totalRow['total'];

// Calculate the total number of pages
$totalPages = ceil($totalEmployees / $rowsPerPage);
?>

<section class="job-section job-featured-section section-padding" id="job-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12 text-center mx-auto mb-4">
                <h2>Latest CRTs</h2>
                <p>Browse through our featured CRTs and find your next team member.</p>
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
                                        <?= $employee['level'] ?>
                                    </p>

                                    <p class="job-price mb-0">
                                        <i class="custom-icon bi-cash me-1"></i>
                                        $<?= $employee['salary_range'] ?>
                                    </p>

                                    <div class="d-flex">
                                        <p class="mb-0">
                                            <a href="#" class="badge badge-level"><?= $employee['level'] ?></a>
                                        </p>

                                        <p class="mb-0">
                                            <a href="#" class="badge"><?= $employee['job_type_preference'] ?></a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="job-section-btn-wrap">
                                <a href="employee_details.php?id=<?= $employee['user_id'] ?>" class="custom-btn btn">View Profile</a>
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
                <a class="page-link" href="?page=<?= $currentPage - 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">Prev</span>
                </a>
            </li>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php if ($i == $currentPage) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?php if ($currentPage == $totalPages) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?= $currentPage + 1 ?>" aria-label="Next">
                    <span aria-hidden="true">Next</span>
                </a>
            </li>
        </ul>
    </nav>
</section>