<?php
session_start();
require 'db.php';

// Check if user is logged in (you need to implement login logic)
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php'); // Redirect to login page
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch all users (employees and employers)
$stmt = $pdo->prepare("SELECT id, email, user_type FROM users WHERE id != ?");
$stmt->execute([$user_id]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch messages between the logged-in user and the selected user
$receiver_id = $_GET['receiver_id'] ?? null;
$messages = [];
if ($receiver_id) {
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY sent_at ASC");
    $stmt->execute([$user_id, $receiver_id, $receiver_id, $user_id]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<?php include '../includes/template/header.php'; ?>
<?php include '../includes/template/navbar.php'; ?>
</br>
<div class="job-thumb d-flex">
    <div class="chat">
        <?php if ($receiver_id): ?>
            <h5>Chat with <?= $users[array_search($receiver_id, array_column($users, 'id'))]['email'] ?></h5>
            <div class="content">
                <?php foreach ($messages as $message): ?>
                    <div class="message <?= $message['sender_id'] == $user_id ? 'sent' : 'received' ?>">
                        <p><?= htmlspecialchars($message['content']) ?></p>
                        <small><?= $message['sent_at'] ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
            <form action="send_message.php" method="POST">
                <input type="hidden" name="receiver_id" value="<?= $receiver_id ?>">
                <textarea name="content" placeholder="Type your message..." required></textarea>
                <button type="submit">Send</button>
            </form>
        <?php else: ?>
            <p>Select a user to start chatting.</p>
        <?php endif; ?>
    </div>
</div>
<?php require '../includes/template/footer.php'; ?>
</body>

</html>