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
                    action="handle_message.php"
                    method="post"
                    role="form">
                    <h2 class="text-center mb-4">Send a Message</h2>

                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <label for="sender">Sender Email</label>
                            <input type="email" name="sender" class="form-control" id="sender" placeholder="Your email" required>
                        </div>

                        <div class="col-lg-6 col-12">
                            <label for="receiver">Receiver Email</label>
                            <input type="email" name="receiver" class="form-control" id="receiver" placeholder="Receiver's email" required>
                        </div>

                        <div class="col-lg-12 col-12">
                            <label for="message">Message</label>
                            <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your message" required></textarea>
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
<?php
// Retrieve messages
$messagesQuery = $conn->prepare("SELECT m.*, u1.email as sender_email, u2.email as receiver_email FROM messages m
    JOIN users u1 ON m.sender_id = u1.id
    JOIN users u2 ON m.receiver_id = u2.id
    ORDER BY m.sent_at DESC");
$messagesQuery->execute();
$messagesResult = $messagesQuery->get_result();
?>

<section class="messages-section section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-12 mx-auto">
                <h2 class="text-center mb-4">Messages</h2>
                <div class="messages-list">
                    <?php while ($message = $messagesResult->fetch_assoc()): ?>
                        <div class="message">
                            <p><strong>From:</strong> <?php echo htmlspecialchars($message['sender_email']); ?></p>
                            <p><strong>To:</strong> <?php echo htmlspecialchars($message['receiver_email']); ?></p>
                            <p><strong>Sent At:</strong> <?php echo htmlspecialchars($message['sent_at']); ?></p>
                            <p><strong>Message:</strong> <?php echo htmlspecialchars($message['content']); ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
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