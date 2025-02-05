<?php
require_once 'db.php';
?>

<section class="job-section section-padding">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6 col-12 mb-lg-4">
                <h3>Latest jobs</h3>
            </div>

            <div class="col-lg-4 col-12 d-flex align-items-center ms-auto mb-5 mb-lg-4">
                <p class="mb-0 ms-lg-auto">Sort by:</p>

                <div class="dropdown dropdown-sorting ms-3 me-4">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownSortingButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Newest Jobs
                    </button>

                    <ul class="dropdown-menu" aria-labelledby="dropdownSortingButton">
                        <li><a class="dropdown-item" href="#">Latest Jobs</a></li>
                        <li><a class="dropdown-item" href="#">Highest Salary Jobs</a></li>
                        <li><a class="dropdown-item" href="#">Internship Jobs</a></li>
                    </ul>
                </div>

                <div class="d-flex">
                    <a href="#" class="sorting-icon active bi-list me-2"></a>
                    <a href="#" class="sorting-icon bi-grid"></a>
                </div>
            </div>

            <?php
            $query = "SELECT id, title, location, job_type, experience_level, salary, posted_at, 
                     job_image, company_logo, company_name 
                      FROM jobs 
                      ORDER BY posted_at DESC 
                      LIMIT 6";
            $result = mysqli_query($conn, $query);
            
            if (!$result) {
                die("Database query failed: " . mysqli_error($conn));
            }

            while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="job-thumb job-thumb-box">
                    <div class="job-image-box-wrap">
                        <a href="job-details.php?id=<?php echo $row['id']; ?>">
                            <img src="<?php echo $row['job_image']; ?>" class="job-image img-fluid" alt="">
                        </a>

                        <div class="job-image-box-wrap-info d-flex align-items-center">
                            <p class="mb-0">
                                <a href="#" class="badge badge-level"><?php echo ucfirst($row['experience_level']); ?></a>
                            </p>
                            <p class="mb-0">
                                <a href="#" class="badge"><?php echo ucfirst($row['job_type']); ?></a>
                            </p>
                        </div>
                    </div>

                    <div class="job-body">
                        <h4 class="job-title">
                            <a href="job-details.php?id=<?php echo $row['id']; ?>" class="job-title-link">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </a>
                        </h4>

                        <div class="d-flex align-items-center">
                            <div class="job-image-wrap d-flex align-items-center bg-white shadow-lg mt-2 mb-4">
                                <img src="<?php echo $row['company_logo']; ?>" class="job-image me-3 img-fluid" alt="">
                                <p class="mb-0"><?php echo htmlspecialchars($row['company_name']); ?></p>
                            </div>

                            <a href="#" class="bi-bookmark ms-auto me-2"></a>
                            <a href="#" class="bi-heart"></a>
                        </div>

                        <div class="d-flex align-items-center">
                            <p class="job-location">
                                <i class="custom-icon bi-geo-alt me-1"></i>
                                <?php echo htmlspecialchars($row['location']); ?>
                            </p>
                            <p class="job-date">
                                <i class="custom-icon bi-clock me-1"></i>
                                <?php // disabled echo $time_ago; ?>
                            </p>
                        </div>

                        <div class="d-flex align-items-center border-top pt-3">
                            <p class="job-price mb-0">
                                <i class="custom-icon bi-cash me-1"></i>
                                $<?php echo number_format($row['salary'], 0, '', ','); ?>
                            </p>
                            <a href="job-details.php?id=<?php echo $row['id']; ?>" class="custom-btn btn ms-auto">Apply now</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <div class="col-lg-12 col-12">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center mt-5">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">Prev</span>
                            </a>
                        </li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">4</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">5</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>
