document.getElementById("username").addEventListener("keyup", validateUsername);
document.getElementById("password").addEventListener("keyup", validatePassword);

function validateUsername() {
    var username = document.getElementById("username").value.trim();
    var usernameError = document.getElementById("usernameError");
    if (/[^a-zA-Z]/.test(username)) {
        usernameError.textContent = "Username should only contain letters";
        usernameError.style.display = "block";
    } else {
        usernameError.style.display = "none";
    }

}

function validatePassword() {
    var password = document.getElementById("password").value.trim();
    var passwordError = document.getElementById("passwordError");
    if (password === '') {
        passwordError.textContent = "Password is required";
        passwordError.style.display = "block";
    } else {
        passwordError.style.display = "none";
    }
}

function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}