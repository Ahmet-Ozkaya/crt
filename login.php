<?php
session_start();
include 'includes\template\header.php';
include 'includes\template\site-headerjd.php';
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    }
    else {
        // Check if user exists
        $sql = "SELECT id, password_hash, user_type FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // Verify password
            if (password_verify($password, $user['password_hash'])) {
                // Start session and store user data
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_type'] = $user['user_type'];
                
                // Redirect based on user type with ID parameter
                if ($user['user_type'] === 'employee') {
                    header('Location: employee.php?id=' . urlencode($user['id']));
                } else {
                    header('Location: employer.php?id=' . urlencode($user['id']));
                }
                exit();
            } else {
                $error = "Invalid email or password";
            }
        } else {
            $error = "Invalid email or password";
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
                                <h2 class="text-center mb-4">Login</h2>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="email">Email Address</label>
                                        <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Jackdoe@gmail.com" required>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Your Password" required>
                                    </div>
                            <div class="col-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary">Login</button>
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
</html>
