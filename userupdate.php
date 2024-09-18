<?php
session_start();

// Include the database connection file
include 'dbconnection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Retrieve user_id from the session
$user_id = $_SESSION['user_id'];

// Connect to the database using the connectDB() function
$pdo = connectDB();

if ($pdo === null) {
    // Handle database connection error
    echo "Failed to connect to the database.";
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password before updating
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute SQL statement to update user information
    $stmt = $pdo->prepare("UPDATE usertable SET user_fname = :firstname, user_lname = :lastname, user_bdate = :dob, user_age = :age, user_username = :username, user_email = :email, user_password = :password WHERE user_id = :user_id");
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':user_id', $user_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the account page with a success message
        header("Location: account.php?update=success");
        exit();
    } else {
        // Redirect to the account page with an error message
        header("Location: account.php?update=error");
        exit();
    }
} else {
    // If the form is not submitted, redirect back to the account page
    header("Location: account.php");
    exit();
}
?>