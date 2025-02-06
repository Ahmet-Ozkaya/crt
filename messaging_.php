<?php
require_once 'db.php';
include 'includes/template/header.php';
include 'includes/template/navbar.php';

//$user_id = $_SESSION['user_id'];
$user_id = 1;

// Fetch all users (employees and employers)
/*
$stmt = $pdo->prepare("");
$stmt->execute([$user_id]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
*/
$query = "SELECT id, email, user_type FROM users WHERE id != ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_assoc();


// Fetch messages between the logged-in user and the selected user
//$receiver_id = $_GET['receiver_id'] ?? null;
$receiver_id = 2;
$messages = [];
if ($receiver_id) {
    $query = "SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY sent_at ASC";
    //    $stmt = $conn->prepare();
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiii", $user_id, $receiver_id, $receiver_id, $user_id);
    $stmt->execute();
    $messages = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }

        .container {
            display: flex;
            width: 100%;
        }

        .sidebar {
            width: 20%;
            background: #f4f4f4;
            padding: 10px;
        }

        .chat {
            width: 80%;
            padding: 10px;
            display: flex;
            flex-direction: column;
        }

        .messages {
            flex: 1;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }

        .message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            max-width: 70%;
        }

        .message.sent {
            background: #dcf8c6;
            margin-left: auto;
        }

        .message.received {
            background: #ececec;
            margin-right: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <h2>Users</h2>
            <ul>
                <?php foreach ($users as $user): ?>
                    <li><a href="?receiver_id=<?= $user['id'] ?>"><?= $user['email'] ?> (<?= $user['user_type'] ?>)</a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="chat">
            <?php if ($receiver_id): ?>
                <h2>Chat with <?= $users[array_search($receiver_id, array_column($users, 'id'))]['email'] ?></h2>
                <div class="messages">
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $message): ?>
                            <div class="message <?= $message['sender_id'] == $user_id ? 'sent' : 'received' ?>">
                                <p><?= htmlspecialchars($message['content']) ?></p>
                                <small><?= $message['sent_at'] ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
</body>

</html>