
function enableInputs() {
    document.getElementById('firstname').disabled = false;
    document.getElementById('lastname').disabled = false;
    document.getElementById('dob').disabled = false;
    document.getElementById('age').disabled = false;
    document.getElementById('username').disabled = false;
    document.getElementById('email').disabled = false;
    document.getElementById('password').disabled = false;
    document.getElementById('confirmpassword').disabled = false;

    const showPasswordToggle = document.getElementById('showPasswordToggle');
    const showConfirmPasswordToggle = document.getElementById('showConfirmPasswordToggle');
    showPasswordToggle.classList.add('active');
    showConfirmPasswordToggle.classList.add('active');

    document.getElementById('saveBtn').style.display = 'inline-block';
    document.getElementById('cancelBtn').style.display = 'inline-block';

    document.getElementById('editBtn').style.display = 'none';
}

function cancelEdit() {
    document.getElementById('firstname').value = "<?php echo $user['user_fname']; ?>";
    document.getElementById('lastname').value = "<?php echo $user['user_lname']; ?>";
    document.getElementById('dob').value = "<?php echo $user['user_bdate']; ?>";
    document.getElementById('age').value = "<?php echo $user['user_age']; ?>";
    document.getElementById('username').value = "<?php echo $user['user_username']; ?>";
    document.getElementById('email').value = "<?php echo $user['user_email']; ?>";
    document.getElementById('password').value = "<?php echo $user['user_password']; ?>";

    const showPasswordToggle = document.getElementById('showPasswordToggle');
    const showConfirmPasswordToggle = document.getElementById('showConfirmPasswordToggle');
    showPasswordToggle.classList.remove('active');
    showConfirmPasswordToggle.classList.remove('active');

    const passwordInput = document.getElementById('password');
    passwordInput.setAttribute('type', 'password');

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