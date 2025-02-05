<?php
include 'header.php';
include 'site-headerjd.php';
include 'db.php';

// Verify token from URL
if (!isset($_GET['token'])) {
    header('Location: passwordreset.php');
    exit();
}

$token = mysqli_real_escape_string($conn, $_GET['token']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match";
    }
    // Check password strength
    elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters";
    }
    else {
        // Verify token is valid and not expired
        $sql = "SELECT id, reset_expires FROM users WHERE reset_token = '$token'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // Check if token is expired
            if (strtotime($user['reset_expires']) < time()) {
                $error = "Password reset link has expired";
            }
            else {
                // Hash new password
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                
                // Update password and clear reset token
                $update_sql = "UPDATE users SET 
                              password_hash = '$password_hash',
                              reset_token = NULL,
                              reset_expires = NULL
                              WHERE id = {$user['id']}";
                mysqli_query($conn, $update_sql);
                
                $success = "Password updated successfully. You can now <a href='login.php'>login</a>.";
            }
        } else {
            $error = "Invalid password reset token";
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
                                <h2 class="text-center mb-4">Update Password</h2>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="password">New Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password" required minlength="8">
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="confirm_password">Confirm New Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm new password" required minlength="8">
                                    </div>

                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-primary">Update Password</button>
                                    </div>
                                    <div class="col-12 text-center mt-3">
                                        <a href="login.php" class="text-muted">Back to Login</a>
                                    </div>
                            </form>
                        </div>

                    </div>
                </div>
            </section>
        </main>
<?php include 'footerbanner.php'; ?>
<?php include 'footer.php'; ?>
        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/counter.js"></script>
        <script src="js/custom.js"></script>

    </body>
</html>
