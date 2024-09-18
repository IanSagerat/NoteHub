<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit();
}

include 'dbconnection.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['note_id']) && !empty($_POST['note_id'])) {
    $note_id = filter_var($_POST['note_id'], FILTER_SANITIZE_NUMBER_INT);

    $pdo = connectDB();

    if ($pdo === null) {
        http_response_code(500);
        exit();
    }

    try {
        $stmt = $pdo->prepare("UPDATE notetable SET note_status = 'Favorites' WHERE note_id = :note_id AND user_id = :user_id AND note_status != 'Favorites'");

        $stmt->bindParam(':note_id', $note_id);
        $stmt->bindParam(':user_id', $user_id);

        if ($stmt->execute()) {
            http_response_code(200);
            exit();
        } else {
            http_response_code(500);
            exit();
        }
    } catch (PDOException $e) {
        http_response_code(500);
        exit();
    }
} else {
    http_response_code(400);
    exit();
}
?>