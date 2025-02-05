<?php
require_once 'db.php';
include 'includes\template\header.php';
include 'includes\template\navbar.php';
include 'includes\template\site-headerjd.php';

// Get employer ID from URL
$employer_id = $_GET['id'] ?? 0;

// Fetch employer website from database
$website = '#';
$address = '';
$phone = '';
$email= '';
$map = '';  // Google Map embed URL
if ($employer_id > 0) {
    $query = "SELECT e.website, e.address, e.map, e.phone, u.email 
              FROM employers e
              INNER JOIN users u ON e.user_id = u.id
              WHERE u.id = $employer_id";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $employer = mysqli_fetch_assoc($result);
        $website = htmlspecialchars($employer['website'] ?? '#');
        $address = htmlspecialchars($employer['address'] ?? '');
        $map = htmlspecialchars($employer['map'] ?? '');
        $phone = htmlspecialchars($employer['phone'] ?? '');
        $email = htmlspecialchars($employer['email'] ?? 'info@jobportal.co');
    }
}
?>
            <section class="contact-section section-padding">
                <div class="container">
                    <div class="row justify-content-center">

                        <div class="col-lg-6 col-12 mb-lg-5 mb-3">
                            <iframe class="google-map" src="<?php echo $map; ?>"></iframe>
                        </div>

                        <div class="col-lg-5 col-12 mb-3 mx-auto">
                            <div class="contact-info-wrap">
                                <div class="contact-info d-flex align-items-center mb-3">
                                    <i class="custom-icon bi-building"></i>

                                    <p class="mb-0">
                                        <span class="contact-info-small-title">Location</span>
                                        <?php echo $address; ?>
                                    </p>
                                </div>

                                <div class="contact-info d-flex align-items-center">
                                    <i class="custom-icon bi-globe"></i>

                                    <p class="mb-0">
                                        <span class="contact-info-small-title">Website</span>

                                        <a href="<?php echo $website; ?>" class="site-footer-link" target="_blank">
                                            <?php echo $website; ?>
                                        </a>
                                    </p>
                                </div>

                                <div class="contact-info d-flex align-items-center">
                                    <i class="custom-icon bi-telephone"></i>

                                    <p class="mb-0">
                                        <span class="contact-info-small-title">Phone</span>

                                        <a href="tel: <?php echo $phone; ?>" class="site-footer-link">
                                            <?php echo $phone; ?>
                                        </a>
                                    </p>
                                </div>

                                <div class="contact-info d-flex align-items-center">
                                    <i class="custom-icon bi-envelope"></i>

                                    <p class="mb-0">
                                        <span class="contact-info-small-title">Email</span>

                                        <a href="mailto:<?php echo $email; ?>" class="site-footer-link">
                                            <?php echo $email; ?>
                                        </a>
                                    </p>
                                </div>
                            </div>
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
