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

// Fetch user data from the database
$stmt = $pdo->prepare("SELECT * FROM usertable WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="Css/account.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container">
        <div class="coverpage">
            <a href="dashboard.php"><i class='bx bx-arrow-back'></i></a>
            <h1>My Account</h1>
        </div>
        <form id="accountForm" action="userupdate.php" method="post"> <!-- Form element -->
            <div class="accounts">
                <div class="img">
                    <img src="Image/Bg.avif" alt="Profile Picture" class="image"> 
                    <!-- <?php echo $user['user_image']; ?> -->
                </div>
                <div class="col1">
                    <div class="acc1">
                        <label for="firstname">First name</label>
                        <input type="text" id="firstname" name="firstname" value="<?php echo $user['user_fname']; ?>" disabled>
                        <label for="lastname">Last name</label>
                        <input type="text" id="lastname" name="lastname" value="<?php echo $user['user_lname']; ?>" disabled>
                    </div>
                    <div class="acc2">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" value="<?php echo $user['user_bdate']; ?>" onchange="calculateAge()" disabled>
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" value="<?php echo $user['user_age']; ?>"disabled>
                </div>
                </div>
                <div class="col2">
                    <div class="acc3">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" class="mail" value="<?php echo $user['user_email']; ?>" disabled>
                    <div class="acc3">
                        <label for="password">Password</label>
                        <div class="password-input">
                            <input type="password" id="password" name="password" class="pass" value="<?php echo $user['user_password']; ?>" disabled>
                            <i class='bx bxs-show' id="showPasswordToggle"></i>
                        </div>
                    </div>
                    </div>
                    <div class="acc4">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo $user['user_username']; ?>" disabled>
                    <label for="confirm password">Confirm Password</label>
                    <input type="password" id="confirmpassword" name="confirmpassword" disabled>
                    <div class="password-input">
                            <i class='bx bxs-show passin' id="showConfirmPasswordToggle"></i>
                    </div>
                    <div class="insert">
                    <label for="file-upload" class="custom-file-upload"><i class='bx bx-upload'></i>Choose File</label>
                    <input id="file-upload" type="file">
                    </div>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <button type="button" id="editBtn" onclick="enableInputs()">Edit</button>
                <button type="submit" id="saveBtn" style="display: none;">Save</button>
                <button type="button" id="cancelBtn" style="display: none;" onclick="cancelEdit()">Cancel</button>
            </div>
        </form> <!-- End of form element -->
    </div>
    <script>
      // Store initial values from the database
        const initialDobValue = "<?php echo $user['user_bdate']; ?>";
        const initialAgeValue = "<?php echo $user['user_age']; ?>";

        function enableInputs() {
            // Clear date of birth and age fields
            document.getElementById('dob').value = '';
            document.getElementById('age').value = '';

            // Other enable input fields code
        }

        function cancelEdit() {
            // Reset input fields to their original values
            document.getElementById('dob').value = initialDobValue;
            document.getElementById('age').value = initialAgeValue;

            // Other reset input fields code
        }

        function calculateAge() {
            // Get the selected date of birth
            const dobInput = document.getElementById('dob');
            const dob = new Date(dobInput.value);

            // Get today's date
            const today = new Date();

            // Calculate the age
            let age = today.getFullYear() - dob.getFullYear();
            const monthDifference = today.getMonth() - dob.getMonth();
            if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            // Update the age input field
            document.getElementById('age').value = age;
        }

function enableInputs() {
    document.getElementById('firstname').disabled = false;
    document.getElementById('lastname').disabled = false;
    document.getElementById('dob').disabled = false;
    document.getElementById('age').disabled = false;
    document.getElementById('username').disabled = false;
    document.getElementById('email').disabled = false;
    document.getElementById('password').disabled = false;
    document.getElementById('confirmpassword').disabled = false;

    document.getElementById('saveBtn').style.display = 'inline-block';
    document.getElementById('cancelBtn').style.display = 'inline-block';

    document.getElementById('editBtn').style.display = 'none';
}

function cancelEdit() {
    // Reset input fields to their original values
    document.getElementById('firstname').value = "<?php echo $user['user_fname']; ?>";
    document.getElementById('lastname').value = "<?php echo $user['user_lname']; ?>";
    document.getElementById('dob').value = "<?php echo $user['user_bdate']; ?>";
    document.getElementById('age').value = "<?php echo $user['user_age']; ?>";
    document.getElementById('username').value = "<?php echo $user['user_username']; ?>";
    document.getElementById('email').value = "<?php echo $user['user_email']; ?>";
    document.getElementById('password').value = "<?php echo $user['user_password']; ?>";

    // Hide the password
    const passwordInput = document.getElementById('password');
    passwordInput.setAttribute('type', 'password');

    // Clear the confirm password input field
    document.getElementById('confirmpassword').value = "";

    // Disable input fields
    document.getElementById('firstname').disabled = true;
    document.getElementById('lastname').disabled = true;
    document.getElementById('dob').disabled = true;
    document.getElementById('age').disabled = true;
    document.getElementById('username').disabled = true;
    document.getElementById('email').disabled = true;
    document.getElementById('password').disabled = true;
    document.getElementById('confirmpassword').disabled = true;

    document.getElementById('saveBtn').style.display = 'none';
    document.getElementById('cancelBtn').style.display = 'none';

    document.getElementById('editBtn').style.display = 'inline-block';
}

document.addEventListener("DOMContentLoaded", function() {
    const showPasswordToggle = document.getElementById('showPasswordToggle');
    const passwordInput = document.getElementById('password');
    const showConfirmPasswordToggle = document.getElementById('showConfirmPasswordToggle');
    const confirmPasswordInput = document.getElementById('confirmpassword');

    showPasswordToggle.addEventListener('click', function() {
        if (!document.getElementById('firstname').disabled) {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('bx-show-hide');
            this.classList.toggle('bx-hide-hide');
        }
    });

    showConfirmPasswordToggle.addEventListener('click', function() {
        if (!document.getElementById('firstname').disabled) {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            this.classList.toggle('bx-show-hide');
            this.classList.toggle('bx-hide-hide');
        }
    });
});
</script>