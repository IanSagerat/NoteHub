<?php
session_start();

include 'dbconnection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['formTitle']) && !empty($_POST['description'])) {
        $title = $_POST['formTitle'];
        $description = $_POST['description'];

        try {
            $pdo = connectToDatabase();
            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }

            $stmt = $pdo->prepare("INSERT INTO notetable (user_id, note_title, note_desc, note_date, note_status) VALUES (:user_id, :note_title, :note_desc, NOW(), 'Added')");

            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':note_title', $title);
            $stmt->bindParam(':note_desc', $description);

            $stmt->execute();
            header("Location: dashboard.php");
            exit();
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
}
}
?>
