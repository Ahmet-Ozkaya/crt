<?php
require_once 'db.php';
include 'includes/template/header.php';
include 'includes/template/navbar.php';
include 'includes/template/site-headerjd.php';

$query = "SELECT `jobs`.`id` AS `job_id`, `jobs`.`company_logo`, `jobs`.`category`, `jobs`.`title`, `jobs`.`description`, `jobs`.`posted_at`, `employees`.`full_name`, `employees`.`bio`, `jobs`.`start_date`, `jobs`.`end_date`, `employers`.`company_name`, `employers`.`phone`, `employers`.`website`, `employers`.`location`, `users`.`email`
FROM `jobs` 
	LEFT JOIN `employees` ON `jobs`.`employee_id` = `employees`.`id` 
	LEFT JOIN `employers` ON `jobs`.`employer_id` = `employers`.`id` 
	LEFT JOIN `users` ON `employees`.`user_id` = `users`.`id`;";
$result = mysqli_query($conn, $query);
?>

<section class="job-section job-featured-section section-padding" id="job-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12 text-center mx-auto mb-4">
                <h2>Featured Jobs</h2>
                <p>Browse through our featured Jobs.</p>
            </div>
            <div class="col-lg-12 col-12">
                <?php while($job = mysqli_fetch_assoc($result)): ?>
                <div class="job-thumb d-flex">
                    <div class="job-image-wrap bg-white shadow-lg">
                        <img src="<?= $job['logo'] ?>" class="job-image img-fluid" alt="<?= $job['job_id'] ?>">
                    </div>
                    <div class="job-body d-flex flex-wrap flex-auto align-items-center ms-4">
                        <div class="mb-3">
                            <h5 class="job-title mb-lg-0">
                                <span class="editable-field" data-field="job_title" data-id="<?= $job['job_id'] ?>">
                                    <?= $job['job_title'] ?>
                                </span>
                            </h5>
                            <h5 class="job-title mb-lg-0">
                                <span class="editable-field" data-field="employee_name" data-id="<?= $job['job_id'] ?>">
                                    <?= $job['employee_name'] ?>
                                </span>
                            </h5>
                            <div class="d-flex flex-wrap align-items-center">
                                <p class="job-location mb-0">
                                    <i class="custom-icon bi-geo-alt me-1"></i>
                                    <span class="editable-field" data-field="location" data-id="<?= $job['job_id'] ?>">
                                        <?= $job['location'] ?>
                                    </span>
                                </p>
                                <p class="job-date mb-0">
                                    <i class="custom-icon bi-clock me-1"></i>
                                    <span class="editable-field" data-field="phone" data-id="<?= $job['job_id'] ?>">
                                        <?= $job['phone'] ?>
                                    </span>
                                </p>
                                <p class="job-price mb-0">
                                    <i class="custom-icon bi-cash me-1"></i>
                                    $<span class="editable-field" data-field="company" data-id="<?= $job['job_id'] ?>">
                                        <?= $job['company'] ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="job-section-btn-wrap">
                            <a href="job_details.php?id=<?= $job['job_id'] ?>" class="custom-btn btn">View Profile</a>
                            <a href="edit_employee.php?id=<?= $job['job_id'] ?>" class="custom-btn btn ms-2">Edit Employee</a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>
<?php include '../../includes/template/footerbanner.php'; ?>
<?php include '../../includes/template/footer.php'; ?>

<script>
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('editable-field')) {
        const field = e.target;
        const currentValue = field.textContent.trim();
        const input = document.createElement('input');
        input.type = 'text';
        input.value = currentValue;
        input.classList.add('form-control', 'inline-edit-input');

        // Replace field content with input
        field.innerHTML = '';
        field.appendChild(input);
        input.focus();

        // Handle save on enter or blur
        const saveEdit = () => {
            const newValue = input.value.trim();
            if (newValue !== currentValue) {
                const employeeId = field.dataset.id;
                const fieldName = field.dataset.field;

                fetch('api/update_employee.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: employeeId,
                        field: fieldName,
                        value: newValue
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        field.textContent = newValue;
                    } else {
                        alert('Error updating field: ' + data.error);
                        field.textContent = currentValue;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    field.textContent = currentValue;
                });
            } else {
                field.textContent = currentValue;
            }
        };

        input.addEventListener('blur', saveEdit);
        input.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                saveEdit();
            }
        });
    }
});
</script>

</body>
</html>