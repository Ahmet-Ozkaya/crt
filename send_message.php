<?php
/*
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$sender_id = $_SESSION['user_id'];
$receiver_id = $_POST['receiver_id'];
*/
$sender_id = 1;
$receiver_id = 2;

$content = $_POST['content'];

if (!empty($content)) {
    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, content, sent_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$sender_id, $receiver_id, $content]);
}

header("Location: index.php?receiver_id=$receiver_id");
exit();
