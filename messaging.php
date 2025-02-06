<?php
require_once 'db.php';
include 'includes/template/header.php';
include 'includes/template/navbar.php';
?>
<section class="contact-section section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-12 mx-auto">
                <form
                    class="custom-form contact-form"
                    action="#"
                    method="post"
                    role="form">
                    <h2 class="text-center mb-4">Project in mind? Let’s Talk</h2>

                    <div class="row">

                        <div class="col-lg-12 col-12">
                            <label for="message">Message</label>

                            <textarea
                                name="message"
                                rows="6"
                                class="form-control"
                                id="message"
                                placeholder="What can we help you?"></textarea>
                        </div>

                        <div class="col-lg-4 col-md-4 col-6 mx-auto">
                            <button type="submit" class="form-control">
                                Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php include 'includes/template/footerbanner.php'; ?>
<?php include 'includes/template/footer.php'; ?>
<!-- JAVASCRIPT FILES -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/counter.js"></script>
<script src="js/custom.js"></script>
</body>

</html>