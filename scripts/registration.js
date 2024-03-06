document.getElementById("name").addEventListener("keyup", validateName);
document.getElementById("email").addEventListener("keyup", validateEmail);
document.getElementById("password").addEventListener("keyup", validatePassword);
document.getElementById("cpassword").addEventListener("keyup", validateConfirmPassword);

function validateForm() {
    var isValid = true;
    isValid = isValid && validateName();
    isValid = isValid && validateEmail();
    isValid = isValid && validatePassword();
    isValid = isValid && validateConfirmPassword();
    return isValid;
}

function validateName() {
    var name = document.getElementById("name").value.trim();
    var nameError = document.getElementById("nameError");

    if (/[^a-zA-Z0-9]/.test(name)) {
        nameError.textContent = "Username should only contain letters";
        nameError.style.display = "block";
    } else {
        nameError.style.display = "none";
    }
}

function validateEmail() {
    var email = document.getElementById("email").value.trim();
    var emailError = document.getElementById("emailError");
    if (email === '') {
        emailError.textContent = "Email is required";
        emailError.style.display = "block";
        return false;
    } else if (!isValidEmail(email)) {
        emailError.textContent = "Invalid email format";
        emailError.style.display = "block";
        return false;
    } else {
        emailError.style.display = "none";
        return true;
    }
}

function validatePassword() {
    var password = document.getElementById("password").value.trim();
    var passwordError = document.getElementById("passwordError");
    if (password === '') {
        passwordError.textContent = "Password is required";
        passwordError.style.display = "block";
        return false;
    } else if (password.length < 5) {
        passwordError.textContent = "Password must be at least 5 characters long";
        passwordError.style.display = "block";
        return false;
    } else {
        passwordError.style.display = "none";
        return true;
    }
}


function validateConfirmPassword() {
    var password = document.getElementById("password").value.trim();
    var cpassword = document.getElementById("cpassword").value.trim();
    var cpasswordError = document.getElementById("cpasswordError");
    if (cpassword === '') {
        cpasswordError.textContent = "Please repeat the password";
        cpasswordError.style.display = "block";
        return false;
    } else if (password !== cpassword) {
        cpasswordError.textContent = "Passwords do not match";
        cpasswordError.style.display = "block";
        return false;
    } else {
        cpasswordError.style.display = "none";
        return true;
    }
}

function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}