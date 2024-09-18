<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit();
}

include 'dbconnection.php';

$user_id = $_SESSION['user_id'];

// Check if the request contains the necessary data
if (isset($_POST['note_id'], $_POST['status']) && !empty($_POST['note_id']) && !empty($_POST['status'])) {
    $note_id = filter_var($_POST['note_id'], FILTER_SANITIZE_NUMBER_INT);
    $status = $_POST['status'];

    // Check if the provided status is valid
    if ($status !== 'Favorites' && $status !== 'Added') {
        http_response_code(400);
        exit();
    }

    $pdo = connectDB();

    if ($pdo === null) {
        http_response_code(500);
        exit();
    }

    try {
        // Prepare and execute the update statement
        $stmt = $pdo->prepare("UPDATE notetable SET note_status = :status WHERE note_id = :note_id AND user_id = :user_id");
        $stmt->bindParam(':note_id', $note_id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':user_id', $user_id);

        if ($stmt->execute()) {
            // Return the updated status as JSON response
            echo json_encode(['status' => 'success', 'new_status' => $status]);
            exit();
        } else {
            // Return an error response
            http_response_code(500);
            exit();
        }
    } catch (PDOException $e) {
        // Return an error response
        http_response_code(500);
        exit();
    }
} else {
    // Return a bad request response if the required data is missing
    http_response_code(400);
    exit();
}
?>