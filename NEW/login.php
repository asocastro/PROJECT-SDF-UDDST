<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: dashboard.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT userid, username, password FROM users WHERE username = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($userid, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["userid"] = $userid;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: dashboard.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Muli'>
    <style>
      body {
        background: #Fbf3e4 !important;
        font-family: 'Muli', sans-serif;
        
      }

      h1 {
        color: #004d8f;
        padding-top: 3rem;
        padding-bottom: 2rem;
        font-weight: bold;
      }
      h2 {
        font-weight: bold;
        padding-top: 1rem;
        color: #000;
      }

      a {
        color: #000;
      }

      p {
        color: #000;
      }

      a:hover {
        color: #B4d7ff;
        text-decoration: none;
      }
      .form-control:focus {
          color: #000;
          
          border:2px solid #B4d7ff;
          outline: 0;
          box-shadow: none;
      }
      
      .btn {
        background: #B4d7ff;
        border: #B4d7ff;
      }
      .btn:hover {
        background: #B4d7ff;
        border: #B4d7ff;
      }
    </style>
</head>

<body>
<div class="pt-5">
  <h1 class="text-center">Utility Due Date and Subscription Tracker</h1>
    <div class="container">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card card-body">

                <?php
                    if (!empty($login_err)) {
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                    }
                ?>
                <div class="form-group">
                    <label class="text-center">Please fill in your credentials to login.</label>
                    
                 </div>
                <form id="submitForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group required">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>

                <div class="form-group required">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>

                <div class="form-group pt-1">
                    <button type="submit" class="btn btn-primary btn-block">Log In</button>
                </div>

                <p class="small-xl pt-3 text-center">
                    <span class= "text-muted">Don't have an account? </span>
                    <a href="register.php"><b>Sign up now.</b></a>
                </p>
        </form>
    </div>
</body>

</html>