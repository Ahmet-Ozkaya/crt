<?php
require 'db.php';

// Get employee ID from session or URL parameter 
$job_id = $_GET['id'] ?? 1; // Default to 1 if not provided

// Fetch work history
$work_history_query = "SELECT title, description, employer_id, start_date, end_date, description 
    FROM jobs 
    WHERE employee_id = $job_id 
    ORDER BY start_date DESC";
$work_history_result = mysqli_query($conn, $work_history_query);

if (!$work_history_result) {
    die('Database query failed: ' . mysqli_error($conn));
}

$full_name = htmlspecialchars($job['full_name'] ?? 'Full Name');
$job_title = htmlspecialchars($job['job_title'] ?? 'Job Title');
$job_location = htmlspecialchars($job['location'] ?? 'Location');
$salary_range = htmlspecialchars($job['salary_range'] ?? 'Salary not available');
$job_type_preference = htmlspecialchars($job['job_type_preference'] ?? 'Job type not available');
$work_history = htmlspecialchars($job['work_history'] ?? 'Work history not available');
$level = htmlspecialchars($job['level'] ?? 'Level not available');
$education = htmlspecialchars($job['education'] ?? 'Education not available');
$bio_photo = htmlspecialchars($job['bio_photo'] ?? 'images/logos/google.png');
$career_goals = htmlspecialchars($job['career_goals'] ?? 'Career goals not available');
$job_phone = htmlspecialchars($job['phone'] ?? 'Phone number not available');
$description = htmlspecialchars($job['description'] ?? 'Bio not available');
$email = htmlspecialchars($job['email'] ?? 'Email not available');
?>
<section class="job-section section-padding pb-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12">
                <h2 class="job-title mb-0"><?php echo $job_title; ?></h2>

                <div class="job-thumb job-thumb-detail">
                    <div class="d-flex flex-wrap align-items-center border-bottom pt-lg-3 pt-2 pb-3 mb-4">
                        <p class="job-location mb-0">
                            <i class="custom-icon bi-geo-alt me-1"></i>
                            <?php echo $job_location; ?>
                            </p>
                                    <p class="job-date mb-0">
                                        <i class="custom-icon bi-clock me-1"></i>
                                        10H ago
                                    </p>

                                    <p class="job-price mb-0">
                                        <i class="custom-icon bi-cash me-1"></i>
                                        <?php echo $salary_range; ?>
                                    </p>

                                    <div class="d-flex">
                                        <p class="mb-0">
                                            <a href="job-listings.html" class="badge badge-level"><?php echo $job_type_preference; ?></a>
                                        </p>

                                        <p class="mb-0">
                                            <a href="job-listings.html" class="badge"><?php echo $level; ?></a>
                                        </p>
                                    </div>
                                </div>

                                <h4 class="mt-4 mb-2"><?php echo $full_name; ?></h4>

                                <p><?php echo $description; ?></p>

                                <h5 class="mt-4 mb-3">Experience</h5>

                            <div class="work-history mt-4">
                                <h5 class="mb-3">Work History</h5>
                                <?php if (mysqli_num_rows($work_history_result) > 0) : ?>
                                    <div class="timeline">
                                        <?php while ($job = mysqli_fetch_assoc($work_history_result)) : ?>
                                            <div class="timeline-item mb-4">
                                                <div class="timeline-content">
                                                    <h6 class="mb-1"><?php echo htmlspecialchars($job['title']); ?></h6>
                                                    <p class="text-muted mb-1">
                                                        <?php 
                                                        //echo htmlspecialchars($job['employer_id']); 
                                                        ?> From 
                                                        <?php echo date('M Y', strtotime($job['start_date'])); ?> To  
                                                        <?php echo $job['end_date'] ? date('M Y', strtotime($job['end_date'])) : 'Present'; ?> - 
                                                        <?php echo htmlspecialchars($job['title']); ?>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                <?php else : ?>
                                    <p>No work history available</p>
                                <?php endif; ?>
                            </div>

                            <style>
                            .timeline {
                                position: relative;
                                padding-left: 40px;
                            }
                            .timeline::before {
                                content: '';
                                position: absolute;
                                left: 15px;
                                top: 0;
                                bottom: 0;
                                width: 2px;
                                background: #ddd;
                            }
                            .timeline-item {
                                position: relative;
                                margin-bottom: 20px;
                            }
                            .timeline-item::before {
                                content: '';
                                position: absolute;
                                left: -25px;
                                top: 5px;
                                width: 12px;
                                height: 12px;
                                border-radius: 50%;
                                background: #007bff;
                                border: 2px solid #fff;
                            }
</style>

                                <p><strong>Education: </strong><?php echo $education; ?></p>

                                <h5 class="mt-4 mb-3">Skills</h5>

                                <ul>
                                    <li>Strong knowledge in computing skill</li>

                                    <li>Minimum 5 years of working experiences consectetur omeg</li>

                                    <li>Excellent interpersonal skills</li>
                                </ul>

<div class="container d-flex justify-content-center flex-wrap mt-5 border-top pt-4">
    <a href="#" class="custom-btn btn mt-2">Hire now</a>
    <a href="#" class="custom-btn custom-border-btn btn mt-2 ms-lg-4 ms-3">Save this talent</a>
    <a href="#" class="custom-btn custom-border-btn btn mt-2 ms-lg-4 ms-3" data-bs-toggle="collapse" data-bs-target="#editForm">Edit</a>

    <div class="job-detail-share d-flex align-items-center">
        <p class="mb-0 me-lg-4 me-3">Share:</p>
        <a href="#" class="bi-facebook"></a>
        <a href="#" class="bi-twitter mx-3"></a>
        <a href="#" class="bi-share"></a>
    </div>

                    <div class="collapse mt-4" id="editForm">
                        <div class="card card-body bg-light">
                            <h5 class="mb-4 text-primary">Edit Profile</h5>
                            <form action="update_profile.php" method="POST" class="needs-validation" novalidate>
                                <input type="hidden" name="id" value="<?php echo $job_id; ?>">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="full_name" class="form-control" id="fullName" value="<?php echo $full_name; ?>" required>
                                            <label for="fullName">Full Name</label>
                                            <div class="invalid-feedback">
                                                Please enter your full name
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="job_title" class="form-control" id="jobTitle" value="<?php echo $job_title; ?>" required>
                                            <label for="jobTitle">Job Title</label>
                                            <div class="invalid-feedback">
                                                Please enter your job title
                                            </div>
                                        </div>
                                    </div>
                                            </div>

                                <div class="row g-3 mt-2">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="location" class="form-control" id="location" value="<?php echo $job_location; ?>" required>
                                            <label for="location">Location</label>
                                            <div class="invalid-feedback">
                                                Please enter your location
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" name="salary_range" class="form-control" id="salary" value="<?php echo $salary_range; ?>" required>
                                            <label for="salary">Salary Range</label>
                                            <div class="invalid-feedback">
                                                Please enter your salary expectation range
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-floating mt-3">
                                    <textarea name="work_history" class="form-control" id="workHistory" style="height: 100px" required><?php echo $work_history; ?></textarea>
                                    <label for="workHistory">Experience</label>
                                    <div class="invalid-feedback">
                                        Please enter your experience
                                    </div>
                                </div>

                                <div class="form-floating mt-3">
                                    <textarea name="education" class="form-control" id="education" style="height: 100px" required><?php echo $education; ?></textarea>
                                    <label for="education">Education</label>
                                    <div class="invalid-feedback">
                                        Please enter your education details
                                    </div>
                                </div>

                                <div class="form-floating mt-3">
                                    <textarea name="career_goals" class="form-control" id="careerGoals" style="height: 100px" required><?php echo $career_goals; ?></textarea>
                                    <label for="careerGoals">Career Goals</label>
                                    <div class="invalid-feedback">
                                        Please enter your career goals
                                    </div>
                                </div>

                                <div class="row g-3 mt-2">
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="email" name="email" class="form-control" id="email" value="<?php echo htmlspecialchars($job['email'] ?? ''); ?>" required>
                                            <label for="email">Email Address</label>
                                            <div class="invalid-feedback">
                                                Please enter a valid email address
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="tel" name="phone" class="form-control" id="phone" value="<?php echo htmlspecialchars($job['phone'] ?? ''); ?>" required>
                                            <label for="phone">Phone Number</label>
                                            <div class="invalid-feedback">
                                                Please enter a valid phone number
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                            <div class="d-grid mt-4">
                                                <button type="submit" class="btn btn-primary btn-lg">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12 mt-5 mt-lg-0">
    <div class="job-thumb job-thumb-detail-box bg-white shadow-lg">
        <div class="d-flex align-items-center">
            <div class="job-image-wrap d-flex align-items-center bg-white shadow-lg mb-3">
                <img src="<?php echo $bio_photo; ?>" class="job-image me-3 img-fluid" alt="">
                <p class="mb-0">Google</p>
            </div>
            <a href="#" class="bi-bookmark ms-auto me-2"></a>
            <a href="#" class="bi-heart"></a>
        </div>

                                <h6 class="mt-3 mb-2">Career Goals</h6>

                                <p><?php echo $career_goals; ?></p>

                                <h6 class="mt-4 mb-3">Contact Information</h6>

                        <p class="mb-2">
                            <i class="custom-icon bi-globe me-1"></i>
                            <a href="#" class="site-footer-link">www.jobbportal.com</a>
                        </p>

                        <p class="mb-2">
                            <i class="custom-icon bi-telephone me-1"></i>
                            <a class="site-footer-link"><?php echo htmlspecialchars($job['phone'] ?? ''); ?></a>
                        </p>

                        <p>
                            <i class="custom-icon bi-envelope me-1"></i>
                            <a href="mailto:<?php echo htmlspecialchars($job['email']); ?>" class="site-footer-link">
                                <?php echo htmlspecialchars($job['email']); ?>
                            </a>
                        </p>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
