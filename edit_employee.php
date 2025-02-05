<?php
require_once 'db.php';
include 'includes/template/header.php';
include 'includes/template/navbar.php';
include 'includes/template/site-headerjd.php';

// Get employee ID from query string
$employee_id = $_GET['id'] ?? 0;

// Fetch employee data
$query = "SELECT * FROM employees WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();

if (!$employee) {
    die("Employee not found");
}
?>

<br>
<div class="container">
    <h2>Edit Employee</h2>
    <form id="editEmployeeForm" class="custom-form" style="background-color: #f0f8ff; padding: 20px; border-radius: 5px;">
        <input type="hidden" name="id" value="<?= $employee['id'] ?>">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-person custom-icon"></i></span>
                        <input type="text" name="full_name" class="form-control form-control-sm" value="<?= htmlspecialchars($employee['full_name']) ?>">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Job Title</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-briefcase custom-icon"></i></span>
                        <input type="text" name="job_title" class="form-control form-control-sm" value="<?= htmlspecialchars($employee['job_title']) ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Phone</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-telephone custom-icon"></i></span>
                        <input type="text" name="phone" class="form-control form-control-sm" value="<?= htmlspecialchars($employee['phone']) ?>">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Location</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-geo-alt custom-icon"></i></span>
                        <input type="text" name="location" class="form-control form-control-sm" value="<?= htmlspecialchars($employee['location']) ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Job Type Preference</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-briefcase custom-icon"></i></span>
                        <select name="job_type_preference" class="form-control form-control-sm">
                            <option value="full-time" <?= $employee['job_type_preference'] == 'full-time' ? 'selected' : '' ?>>Full-Time</option>
                            <option value="part-time" <?= $employee['job_type_preference'] == 'part-time' ? 'selected' : '' ?>>Part-Time</option>
                            <option value="contract" <?= $employee['job_type_preference'] == 'contract' ? 'selected' : '' ?>>Contract</option>
                            <option value="internship" <?= $employee['job_type_preference'] == 'internship' ? 'selected' : '' ?>>Internship</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Salary Range</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-currency-dollar custom-icon"></i></span>
                        <input type="text" name="salary_range" class="form-control form-control-sm" value="<?= htmlspecialchars($employee['salary_range']) ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Remote Preference</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-house custom-icon"></i></span>
                        <select name="remote_preference" class="form-control form-control-sm">
                            <option value="yes" <?= $employee['remote_preference'] == 'yes' ? 'selected' : '' ?>>Yes</option>
                            <option value="no" <?= $employee['remote_preference'] == 'no' ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Level</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-ladder custom-icon"></i></span>
                        <select name="level" class="form-control form-control-sm">
                            <option value="Internship" <?= $employee['level'] == 'Internship' ? 'selected' : '' ?>>Internship</option>
                            <option value="Junior" <?= $employee['level'] == 'Junior' ? 'selected' : '' ?>>Junior</option>
                            <option value="Senior" <?= $employee['level'] == 'Senior' ? 'selected' : '' ?>>Senior</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Bio Photo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-image custom-icon"></i></span>
                        <input type="text" name="bio_photo" class="form-control form-control-sm" value="<?= htmlspecialchars($employee['bio_photo']) ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Bio</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-file-text custom-icon"></i></span>
                        <textarea name="bio" class="form-control form-control-sm" rows="4"><?= htmlspecialchars($employee['bio']) ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Skills</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-tools custom-icon"></i></span>
                        <textarea name="skills" class="form-control form-control-sm" rows="4"><?= htmlspecialchars($employee['skills']) ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Work History</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-briefcase custom-icon"></i></span>
                        <textarea name="work_history" class="form-control form-control-sm" rows="4"><?= htmlspecialchars($employee['work_history']) ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Education</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-mortarboard custom-icon"></i></span>
                        <textarea name="education" class="form-control form-control-sm" rows="4"><?= htmlspecialchars($employee['education']) ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
    <div id="responseMessage" class="mt-3"></div>
</div>

<script src="js/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#editEmployeeForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: 'update_employee.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                window.location.href = 'employees.php';
            },
            error: function() {
                $('#responseMessage').html('Error updating employee');
            }
        });
    });
});
</script>

<?php require_once 'includes/template/footer.php'; ?>