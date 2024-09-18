function calculateAge() {
    var dobInput = document.getElementById("dob").value;
    if (!dobInput) {
        document.getElementById("age").value = "";
        return; // Stop further execution
    }
    var dob = new Date(dobInput);
    var today = new Date();
    if (dob >= today) {
        alert("Please enter a valid date of birth!");
        document.getElementById("dob").value = ""; // Clear invalid date
        document.getElementById("age").value = "";
        return; // Stop further execution
    }
    var age = today.getFullYear() - dob.getFullYear();
    var monthDiff = today.getMonth() - dob.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
        age--;
    }
    document.getElementById("age").value = age;
}

function validateForm() {
    var firstname = document.getElementById("firstname");
    var lastname = document.getElementById("lastname");
    var dob = document.getElementById("dob");
    var email = document.getElementById("email");
    var username = document.getElementById("username");
    var password = document.getElementById("password");

    var isValid = true;

    if (firstname.value.trim() === "") {
        document.getElementById("firstnameError").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("firstnameError").style.display = "none";
    }

    if (lastname.value.trim() === "") {
        document.getElementById("lastnameError").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("lastnameError").style.display = "none";
    }

    if (dob.value.trim() === "") {
        document.getElementById("dobError").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("dobError").style.display = "none";
    }

    // Check if email contains '@'
    if (!email.value.includes("@")) {
        document.getElementById("emailError").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("emailError").style.display = "none";
    }

    if (username.value.trim() === "") {
        document.getElementById("usernameError").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("usernameError").style.display = "none";
    }

    if (password.value.trim() === "") {
        document.getElementById("passwordError").style.display = "block";
        isValid = false;
    } else {
        document.getElementById("passwordError").style.display = "none";
    }

    return isValid;
}