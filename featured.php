<?php
require_once 'db.php';

$query = "SELECT * FROM employees ORDER BY RAND() LIMIT 5";
$result = mysqli_query($conn, $query);
?>

<section class="job-section job-featured-section section-padding" id="job-section">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-12 text-center mx-auto mb-4">
                            <h2>Featured CRTs</h2>

                            <p>Browse through our featured CRTs and find your next team member.</p>
                        </div>

                        <div class="col-lg-12 col-12">
                            <?php while($employee = mysqli_fetch_assoc($result)): ?>
                            <div class="job-thumb d-flex">
                                <div class="job-image-wrap bg-white shadow-lg">
                                    <img src="<?= $employee['bio_photo'] ?>" class="job-image img-fluid" alt="<?= $employee['full_name'] ?>">
                                </div>

                                <div class="job-body d-flex flex-wrap flex-auto align-items-center ms-4">
                                    <div class="mb-3">
                                        <h4 class="job-title mb-lg-0">
                                            <a href="employee_details.php?id=<?= $employee['id'] ?>" class="job-title-link"><?= $employee['job_title'] ?></a>
                                        </h4>

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
                                        <a href="employee_details.php?id=<?= $employee['id'] ?>" class="custom-btn btn">View Profile</a>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>

                    </div>
                </div>
            </section>
