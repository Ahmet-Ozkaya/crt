<?php
include 'header.php';
include 'site-headerjd.php';
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    }
    else {
        // Check if user exists
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            // Generate password reset token
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', time() + 3600); // 1 hour expiration
            
            // Store token in database
            $update_sql = "UPDATE users SET 
                          reset_token = '$token',
                          reset_expires = '$expires'
                          WHERE email = '$email'";
            mysqli_query($conn, $update_sql);
            
            // Send password reset email
            $reset_link = "https://yourdomain.com/reset_password.php?token=$token";
            $subject = "Password Reset Request";
            $message = "Click the following link to reset your password: $reset_link";
            $headers = "From: no-reply@yourdomain.com";
            
            if (mail($email, $subject, $message, $headers)) {
                $success = "Password reset link has been sent to your email";
            } else {
                $error = "Failed to send password reset email";
            }
        } else {
            $error = "If an account exists with this email, a password reset link will be sent";
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
                                <h2 class="text-center mb-4">Reset Password</h2>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="email">Email Address</label>
                                        <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Jackdoe@gmail.com" required>
                                    </div>

                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-primary">Send Reset Link</button>
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
