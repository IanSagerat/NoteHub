<?php
include 'dbconnection.php';

if (isset($_POST['note_id']) && !empty($_POST['note_id'])) {
    $note_id = filter_var($_POST['note_id'], FILTER_SANITIZE_NUMBER_INT);

    $pdo = connectDB();

    if ($pdo === null) {
        echo json_encode(['error' => 'Failed to connect to the database.']);
        exit();
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM notetable WHERE note_id = :note_id");

        $stmt->bindParam(':note_id', $note_id);

        $stmt->execute();

        $note = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($note) {
            $note['note_title'] = htmlspecialchars_decode($note['note_title']);
            $note['note_desc'] = htmlspecialchars_decode($note['note_desc']);
            echo json_encode($note);
        } else {
            echo json_encode(['error' => 'Note not found.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Note ID not provided.']);
}
?>