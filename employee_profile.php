<div class="container my-5">
    <h2 class="highlight">Employee Details</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Full Name</label>
                <p class="form-value"><?= htmlspecialchars($employee['full_name']) ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Job Title</label>
                <p class="form-value"><?= htmlspecialchars($employee['job_title']) ?></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Phone</label>
                <p class="form-value"><?= htmlspecialchars($employee['phone']) ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Location</label>
                <p class="form-value"><?= htmlspecialchars($employee['location']) ?></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Job Type Preference</label>
                <p class="form-value"><?= htmlspecialchars($employee['job_type_preference']) ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Salary Range</label>
                <p class="form-value"><?= htmlspecialchars($employee['salary_range']) ?></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Remote Preference</label>
                <p class="form-value"><?= htmlspecialchars($employee['remote_preference']) ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Level</label>
                <p class="form-value"><?= htmlspecialchars($employee['level']) ?></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Bio</label>
                <p class="form-value"><?= htmlspecialchars($employee['bio']) ?></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Skills</label>
                <ul class="form-value">
                    <?php
                    $skills = explode(',', $employee['skills']);
                    foreach ($skills as $skill) {
                        echo '<li>' . htmlspecialchars(trim($skill)) . '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>work_history</label>
                <ul class="form-value">
                    <?php
                    $work_history = explode(',', $employee['work_history']);
                    foreach ($work_history as $work_history) {
                        echo '<li>' . htmlspecialchars(trim($work_history)) . '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>education</label>
                <ul class="form-value">
                    <?php
                    $education = explode(',', $employee['education']);
                    foreach ($education as $education) {
                        echo '<li>' . htmlspecialchars(trim($education)) . '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="job-section-btn-wrap">
        <a href="edit_employee.php?id=<?= $employee['id'] ?>" class="custom-btn btn ms-2">Edit Employee</a>
    </div>
</div>