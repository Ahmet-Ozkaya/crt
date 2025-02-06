<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senderEmail = $_POST['sender'];
    $receiverEmail = $_POST['receiver'];
    $messageContent = $_POST['message'];

    // Retrieve sender and receiver IDs from the users table
    $senderQuery = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $senderQuery->bind_param("s", $senderEmail);
    $senderQuery->execute();
    $senderResult = $senderQuery->get_result();
    $senderData = $senderResult->fetch_assoc();
    $senderId = $senderData['id'];

    $receiverQuery = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $receiverQuery->bind_param("s", $receiverEmail);
    $receiverQuery->execute();
    $receiverResult = $receiverQuery->get_result();
    $receiverData = $receiverResult->fetch_assoc();
    $receiverId = $receiverData['id'];

    // Insert the message into the messages table
    $insertQuery = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, content, sent_at, is_read) VALUES (?, ?, ?, NOW(), 0)");
    $insertQuery->bind_param("iis", $senderId, $receiverId, $messageContent);
    $insertQuery->execute();

    // Redirect back to the messaging page
    header("Location: messaging.php");
    exit();
}
