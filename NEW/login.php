<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
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
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

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
                    $stmt->bind_result($id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: welcome.php");
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
      body{
        background: #194c7f !important;
        font-family: 'Muli', sans-serif;
        
      }
      h1{
        color: #fff;
        padding-bottom: 2rem;
        font-weight: bold;
      }
      a{
        color: #333;
      }
      a:hover{
        color: #E8D426;
        text-decoration: none;
      }
      .form-control:focus {
          color: #000;
          background-color: #fff;
          border:2px solid #E8D426;
          outline: 0;
          box-shadow: none;
      }
      
      .btn{
        background: #E8D426;
        border: #E8D426;
      }
      .btn:hover {
        background: #E8D426;
        border: #E8D426;
      }
    </style>
</head>

<body>
<div class="pt-5">
  <h1 class="text-center">Utility Due Date and Subscription Tracker</h1>
  <p>Please fill in your credentials to login.</p>
    <div class="container">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card card-body">

                <?php
                    if (!empty($login_err)) {
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                    }
                ?>

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
                    <a href="register.php">Sign up now</a>
                </p>
        </form>
    </div>
</body>

</html>