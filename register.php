<?php
include 'includes\template\header.php';
include 'includes\template\navbar.php';
include 'includes\template\site-headerjd.php';
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmpassword'];
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    }
    // Validate password match
    elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    }
    // Validate password strength
    elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters";
    }
    // Validate user type
    elseif (!in_array($user_type, ['employee', 'employer'])) {
        $error = "Invalid user type";
    }
    else {
        // Check if email exists
        $check_email = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
        if (mysqli_num_rows($check_email) > 0) {
            $error = "Email already registered";
        }
        else {
            // Hash password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user
            $sql = "INSERT INTO users (email, password_hash, user_type) 
                    VALUES ('$email', '$password_hash', '$user_type')";
            
            if (mysqli_query($conn, $sql)) {
                $user_id = mysqli_insert_id($conn);
                $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
                
                if ($user_type === 'employee') {
                    // Insert into employees table
                    $sql = "INSERT INTO employees (user_id, full_name) 
                            VALUES ('$user_id', '$fullname')";
                } else {
                    // Insert into employers table
                    $sql = "INSERT INTO employers (user_id, company_name) 
                            VALUES ('$user_id', '$fullname')";
                }
                
                if (mysqli_query($conn, $sql)) {
                    $success = "Registration successful!";
                    // Store user ID in session
                    session_start();
                    $_SESSION['user_id'] = $user_id;
                    // Clear form
                    $_POST = array();
                    // Redirect to login page
                    header('Location: login.php');
                    exit;
                } else {
                    $error = "Registration failed: " . mysqli_error($conn);
                }
            } else {
                $error = "Registration failed: " . mysqli_error($conn);
            }
        }
    }
}
?>

<section class="contact-section section-padding">
                <div class="container">
                    <div class="row justify-content-center">

                        <div class="col-lg-8 col-12 mx-auto">
                            <form class="custom-form contact-form" action="" method="post" role="form">
                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php endif; ?>
                                <?php if (isset($success)): ?>
                                    <div class="alert alert-success"><?php echo $success; ?></div>
                                <?php endif; ?>
                                <h2 class="text-center mb-4">Login / Register</h2>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                <label class="form-label">User Type</label>
                                <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="user_type" id="employee" value="employee" required="" checked>
                                    <label class="form-check-label" for="employee">Employee</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="user_type" id="employer" value="employer" required="">
                                    <label class="form-check-label" for="employer">Employer</label>
                                </div>
                            </div>
                            </div>

<div class="col-12 mb-3">
    <label for="email">Email Address</label>
    <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Jackdoe@gmail.com" required>
</div>

<div class="col-12 mb-3">
    <label for="fullname">Full Name</label>
    <input type="text" name="fullname" id="fullname" class="form-control" placeholder="John Doe" required>
</div>

<div class="col-12 mb-3">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" class="form-control" placeholder="Your Password" required>
</div>

<div class="col-12 mb-3">
    <label for="confirmpassword">Confirm Password</label>
    <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Confirm Your Password" required>
</div>

<div class="col-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </section>
        </main>
<?php include 'includes\template\footerbanner.php'; ?>
<?php include 'includes\template\footer.php'; ?>
        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/counter.js"></script>
        <script src="js/custom.js"></script>

    </body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fullnameLabel = document.querySelector('label[for="fullname"]');
            const fullnameInput = document.getElementById('fullname');
            const employeeRadio = document.getElementById('employee');
            const employerRadio = document.getElementById('employer');

            function updateLabel() {
                if (employerRadio.checked) {
                    fullnameLabel.textContent = 'Company Name';
                    fullnameInput.placeholder = 'Your Company Name';
                } else {
                    fullnameLabel.textContent = 'Full Name';
                    fullnameInput.placeholder = 'John Doe';
                }
            }

            employeeRadio.addEventListener('change', updateLabel);
            employerRadio.addEventListener('change', updateLabel);
        });
    </script>
</html>
