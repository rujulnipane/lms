// Function to validate username
document.getElementById("name").addEventListener("keyup", validateUsername);

function validateUsername() {
  var username = document.getElementById("name").value;
  var usernameError = document.getElementById("nameError");
  if (/[^a-zA-Z0-9]/.test(username)) {
    usernameError.textContent = "Username should only contain letters and digits";
    usernameError.style.display = "block";
  } else {
    usernameError.style.display = "none";
  }
}

// Function to validate email
document.getElementById("email").addEventListener("keyup", validateEmail);

function validateEmail() {
  var email = document.getElementById("email").value;
  var emailError = document.getElementById("emailError");
  if (!/^\S+@\S+\.\S+$/.test(email)) {
    emailError.textContent = "Invalid email format";
    emailError.style.display = "block";
  } else {
    emailError.style.display = "none";
  }
}

// Function to validate password
document.getElementById("password").addEventListener("keyup", validatePassword);

function validatePassword() {
  var password = document.getElementById("password").value;
  var passwordError = document.getElementById("passwordError");
  if (password.length < 5) {
    passwordError.textContent = "Password must be at least 6 characters long";
    passwordError.style.display = "block";
  } else {
    passwordError.style.display = "none";
  }
}

// Function to validate database username
document.getElementById("dbuser").addEventListener("keyup", validateDBUsername);

function validateDBUsername() {
  var dbuser = document.getElementById("dbuser").value;
  var dbuserError = document.getElementById("dbuserErr");
  if (!dbuser) {
    dbuserError.textContent = "Database username is required";
    dbuserError.style.display = "block";
  } else {
    dbuserError.style.display = "none";
  }
}

// Function to validate database password
document.getElementById("dbpass").addEventListener("keyup", validateDBPassword);

function validateDBPassword() {
  var dbpass = document.getElementById("dbpass").value;
  var dbpassError = document.getElementById("dbpasswordError");
  if (!dbpass) {
    dbpassError.textContent = "Database password is required";
    dbpassError.style.display = "block";
  } else {
    dbpassError.style.display = "none";
  }
}

// Function to validate database name
document.getElementById("dbname").addEventListener("keyup", validateDBName);

function validateDBName() {
  var dbname = document.getElementById("dbname").value;
  var dbnameError = document.getElementById("dbnameErr");
  if (!dbname) {
    dbnameError.textContent = "Database name is required";
    dbnameError.style.display = "block";
  } else {
    dbnameError.style.display = "none";
  }
}

function validateForm() {
  validateUsername();
  validateEmail();
  validatePassword();
  validateDBUsername();
  validateDBPassword();
  validateDBName();

  var errors = document.querySelectorAll('.invalid-feedback');
  for (var i = 0; i < errors.length; i++) {
    if (errors[i].textContent) {
      return false;
    }
  }
  return true;
}