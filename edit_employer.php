<?php
require_once 'db.php';
include 'includes/template/header.php';
include 'includes/template/navbar.php';
include 'includes/template/site-headerjd.php';

// Get employer ID from query string
$employer_id = $_GET['id'] ?? 0;

// Fetch employer data
$query = "SELECT u.id, e.company_name, e.company_logo, e.location, e.website, e.phone, e.description, e.map, e.address
          FROM employers e
          INNER JOIN users u ON e.user_id = u.id
          WHERE u.id = ?";

$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Error preparing the SQL statement: " . $conn->error);
}

$stmt->bind_param("i", $employer_id);

if ($stmt->execute() === false) {
    die("Error executing the SQL statement: " . $stmt->error);
}

$result = $stmt->get_result();
$employer = $result->fetch_assoc();

if (!$employer) {
    die("Employer not found");
}
?>

<br>
<div class="container">
    <h2>Edit Employer</h2>
    <form id="editEmployerForm" class="custom-form" style="background-color: #f0f8ff; padding: 20px; border-radius: 5px;">
        <input type="hidden" name="id" value="<?= $employer['id'] ?>">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Employer Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-person custom-icon"></i></span>
                        <input type="text" name="company_name" class="form-control form-control-sm" value="<?= htmlspecialchars($employer['company_name']) ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Website</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-globe custom-icon"></i></span>
                        <input type="text" name="website" class="form-control form-control-sm" value="<?= htmlspecialchars($employer['website']) ?>">
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
                        <input type="text" name="phone" class="form-control form-control-sm" value="<?= htmlspecialchars($employer['phone']) ?>">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Location</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-geo-alt custom-icon"></i></span>
                        <input type="text" name="location" class="form-control form-control-sm" value="<?= htmlspecialchars($employer['location']) ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Description</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-file-text custom-icon"></i></span>
                        <textarea name="description" class="form-control form-control-sm"><?= htmlspecialchars($employer['description']) ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Map</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-tools custom-icon"></i></span>
                        <textarea name="map" class="form-control form-control-sm"><?= htmlspecialchars($employer['map']) ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi-briefcase custom-icon"></i></span>
                        <textarea name="address" class="form-control form-control-sm"><?= htmlspecialchars($employer['address']) ?></textarea>
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
    $('#editEmployerForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: 'update_employer.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                console.log(response); // Debugging statement
                window.location.href = 'employers.php';
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText); // Debugging statement
                $('#responseMessage').html('Error updating employer: ' + error);
            }
        });
    });
});
</script>

<?php require_once 'includes/template/footer.php'; ?>