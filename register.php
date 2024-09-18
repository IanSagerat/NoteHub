<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register to Notehub</title>
    <link rel="stylesheet" href="Css/register.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .input-container {
            position: relative;
        }

        .input-container input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .error-label {
            position: absolute;
            top: calc(65%);
            left: 0;
            width: 100%;
            padding: 5px;
            background-color: #ffcccc;
            border: 1px solid #000;
            border-radius: 5px;
            font-size: 12px;
            color: #ff0000;
            display: none;
        }

        .input-container.error input {
            border-color: red;
        }

        .input-container.error .error-label {
            display: block;
        }
    </style>
</head>
<body>
<div class="register">
    <div class="Logo">
        <a href="Landingpage.php"><i class='bx bx-arrow-back'></i></a>
        <h2>Register to Note<span class="hub">hub</span></h2>
    </div>
    <div class="form-register">
        <form id="registrationForm" action="addinguser.php" method="post" onsubmit="return validateForm()">
            <div class="form">
                <div class="col1">
                    <label for="firstname">First Name</label>
                    <div class="input-container">
                        <input type="text" id="firstname" name="firstname">
                        <span id="firstnameError" class="error-label">First Name is required</span>
                    </div>
                </div>
                <div class="col1">
                    <label for="lastname">Last Name</label>
                    <div class="input-container">
                        <input type="text" id="lastname" name="lastname">
                        <span id="lastnameError" class="error-label">Last Name is required</span>
                    </div>
                </div>
                <div class="col2">
                    <label for="dob">Date of Birth</label>
                    <div class="input-container">
                        <input type="date" id="dob" name="dob" onchange="calculateAge()">
                        <span id="dobError" class="error-label">Date of Birth is required</span>
                    </div>
                </div>
                <div class="col2">
                    <label for="age">Age</label>
                    <div class="input-container">
                        <input type="number" id="age" name="age" readonly>
                        <!-- Error label for age, if needed -->
                    </div>
                </div>
                <div class="col4">
                    <label for="username">Username</label>
                    <div class="input-container">
                        <input type="text" id="username" name="username">
                        <span id="usernameError" class="error-label">Username is required</span>
                    </div>
                </div>
                <div class="col4">
                    <label for="email">Email</label>
                    <div class="input-container">
                        <input type="email" id="email" name="email">
                        <span id="emailError" class="error-label">Email must contain '@'</span>
                    </div>
                </div>
                <div class="col4">
                    <label for="password">Password</label>
                    <div class="input-container">
                        <input type="password" id="password" name="password">
                        <span id="passwordError" class="error-label">Password is required</span>
                    </div>
                </div>
                <button class="submitreg" type="submit">Register</button>
            </div>
        </form>
    </div>
</div>
<script src="Jsscript/register.js"></script>
</body>
</html>