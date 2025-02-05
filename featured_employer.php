<?php
require_once 'db.php';

//$query = "SELECT * FROM employers ORDER BY id DESC LIMIT 10";
$query = "SELECT u.id, e.company_name, e.company_logo, e.location, e.website, e.phone
          FROM employers e
          INNER JOIN users u ON e.user_id = u.id
          ORDER BY u.id DESC
          LIMIT 10";
$result = mysqli_query($conn, $query);
?>

<section class="job-section job-featured-section section-padding" id="job-section">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-12 text-center mx-auto mb-4">
                            <h2>Employers</h2>

                            <p>Browse through your next employer.</p>
                        </div>

                        <div class="col-lg-12 col-12">
                            <?php while($employer = mysqli_fetch_assoc($result)): ?>
                            <div class="job-thumb d-flex">
                                <div class="job-image-wrap bg-white shadow-lg">
                                    <img src="<?= $employer['company_logo'] ?>" class="job-image img-fluid" alt="<?= $employer['company_name'] ?>">
                                </div>

                                <div class="job-body d-flex flex-wrap flex-auto align-items-center ms-4">
                                    <div class="mb-3">
                                        <h4 class="job-title mb-lg-0">
                                            <a href="employee_details.php?id=<?= $employer['id'] ?>" class="job-title-link"><?= $employer['company_name'] ?></a>
                                        </h4>

                                        <div class="d-flex flex-wrap align-items-center">
                                            <p class="job-location mb-0">
                                                <i class="custom-icon bi-geo-alt me-1"></i>
                                                <?= $employer['location'] ?>
                                            </p>

                                            <p class="job-date mb-0">
                                                <i class="custom-icon bi-globe"></i>
                                                <?= $employer['website'] ?>
                                            </p>

                                            <p class="job-price mb-0">
                                                <i class="custom-icon bi-phone"></i>
                                                <?= $employer['phone'] ?>
                                            </p>

                                        </div>
                                    </div>

                                    <div class="job-section-btn-wrap">
                                        <a href="employer_details.php?id=<?= $employer['id'] ?>" class="custom-btn btn">View Profile</a>
                                    </div>
                                    <div class="job-section-btn-wrap">
                                        <a href="edit_employer.php?id=<?= $employer['id'] ?>" class="custom-btn btn">Edit Profile</a>
                                    </div>

                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>

                    </div>
                </div>
            </section>
