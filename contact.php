<?php
include 'header.php';
include 'site-headerjd.php';
?>


<section class="contact-section section-padding">
                <div class="container">
                    <div class="row justify-content-center">

                        <div class="col-lg-8 col-12 mx-auto">
                            <form class="custom-form contact-form" action="#" method="post" role="form">
                                <h2 class="text-center mb-4">Project in mind? Let’s Talk</h2>

                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-12">
                                        <label for="email">Email Address</label>

                                         <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Jackdoe@gmail.com" required>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-12">
                                        <label for="password">password</label>

                                         <input type="password" name="password" id="password" class="form-control" placeholder="Your Password" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <label for="password">password</label>

                                         <input type="confirmpassword" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Your Password" required>
                                    </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                <label class="form-label">User Type</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="user_type" id="employee" value="employee" required="">
                                        <label class="form-check-label" for="employee">Employee</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="user_type" id="employer" value="employer" required="">
                                        <label class="form-check-label" for="employer">Employer</label>
                                    </div>
                                </div>
                            </div>
                                    <div class="col-lg-4 col-md-4 col-6 mx-auto">
                                        <button type="submit" class="form-control">Submit</button>
                                    </div>
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
