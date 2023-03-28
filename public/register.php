<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect them to the dashboard page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

// Include config file
require_once "../auth/config.php";

// Define variables and initialize with empty values
$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $stmt->store_result();

                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";

        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $stmt->store_result();

                if($stmt->num_rows == 1){
                    $email_err = "This email is already registered.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

// Validate password and confirm password
if(empty(trim($_POST["password"]))){
    $password_err = "Please enter a password.";
} elseif(strlen(trim($_POST["password"])) < 6){
    $password_err = "Password must have at least 6 characters.";
} elseif(empty(trim($_POST["confirm_password"]))){
    $confirm_password_err = "Please confirm password.";
} elseif(trim($_POST["password"]) !== trim($_POST["confirm_password"])){
    $confirm_password_err = "Password did not match.";
} else{
    // Hash the password
    $password = trim($_POST["password"]);
    $password = password_hash($password, PASSWORD_DEFAULT);
}




    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){

        // Generate a new unique ID
        $new_id = uniqid();

        // Prepare an insert statement
        $sql = "INSERT INTO users (id, username, email, password) VALUES ('$new_id', '$username', '$email', '$password')";

        if($stmt = $conn->prepare($sql)){

            // Attempt to execute the prepared statement
            if($stmt->execute()){

                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.cdnfonts.com/css/proxima-nova-2" rel="stylesheet">
    <link rel="icon" href="chatbot.png">
    <title>Регистрация</title>
    <link rel="stylesheet" href="forms.css">
    <style type="text/css">

    </style>
</head>
<body>
<div class="bgimg"></div>
    <div class="form-wrapper">
        <h2>Регистрация</h2>
        <p>Пожалуйста, введите ваши данные чтобы создать аккаунт.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">



            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <input type="email" name="email" class="text-input" value="<?php echo $email; ?>" placeholder=" ">
                <label>Email</label>
                <span class="help-block"><?php echo $email_err; ?></span>
            </div> 

            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input type="text" name="username" class="text-input" value="<?php echo $username; ?>" placeholder=" ">
                <label>Имя Пользователя</label>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            

            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="password" class="text-input" value="<?php echo $password; ?>" placeholder=" ">
                <label>Пароль</label>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>


            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="confirm_password" class="text-input" value="<?php echo $confirm_password; ?>" placeholder=" ">
                <label>Подтвердите Пароль</label>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>



            <div class="form-group align-horiz">
                <input type="submit" class="button" value="Отправить">
                <input type="reset" class="button" value="Сбросить">
            </div>
            <p>Уже есть аккаунт? <a href="login.php">Зайдите здесь</a>.</p>
        </form>
    </div>    
</body>
</html>



