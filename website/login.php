<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geoglasia - Login</title>

    <link rel="stylesheet" href="css/style.css">
    <?php
        // Also link the equivalent "name.css" to this file!
        $fileName = basename(__FILE__, '.php');

        if (file_exists("css/$fileName.css")) {
            echo "<link rel='stylesheet' href='css/$fileName.css'>";
        }
    ?>
</head>
<body>
    <header>
        <nav class="nav-links">
            <a href="aboutus.php">
                <ion-icon class="icon" name="help-circle-outline"></ion-icon>
                About us
            </a>
            <a href="home.php">
                <ion-icon class="icon" name="home-outline"></ion-icon>
                Home
            </a>
            <a href="map.php">
                <ion-icon class="icon" name="earth-outline"></ion-icon>
                Map
            </a>
        </nav>

        <div class="logo-container">
            <img src="../assets/globe.svg" alt="logo" class="logo">
        </div>
        

        <div class="nav-links">
            <a href="login.php">User</a>
            
            <button class="cta">Contact</button>
        </div>
    </header>

    <main>

        <div class="loginandregister">
            <div class="warnings">
            <?php
                require_once("require/database.php");

                // Login form [ Log in & store cookie ]
                if (isset($_POST['submit-login'])) {

                }

                // Register form [ Error check, create user, log in & store cookie ]
                if (isset($_POST['submit-register'])) {
                    $username = $_POST["login"];
                    $password = $_POST["password"];
                    $email = 0;

                    $password_hashed = password_hash($password, PASSWORD_DEFAULT); // This is apparently a safe way to do it

                    // Server sided checks!
                    $errors = array();

                    if (empty($username) OR empty($email) OR empty($password)) {
                        array_push($errors, "All fields are required.");
                    }
                    /*if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        array_push($errors, "Email is invalid.");
                    }*/
                    
                    // Is email taken?
                    $sql = "SELECT * FROM users WHERE email = '$email'";
                    $is_taken = $db->query($sql);
                    $rows = $db->num_rows();
                    if ($rows > 0) {
                        array_push($errors, "Email address already in use.");
                    }

                    // Is username taken?
                    $sql = "SELECT * FROM users WHERE login = '$login'";
                    $is_taken = $db->query($sql);
                    $rows = $db->num_rows();
                    if ($rows > 0) {
                        array_push($errors, "Email address already in use.");
                    }



                    // Count and display all errors!
                    if (count($errors) > 0) {
                        foreach ($errors as $error) {
                            echo "$error <br>"; // TODO also make cool display
                        }
                    } else {
                    // Create a new user!
                        $sql = "INSERT INTO users(login, email, password) VALUES( ?, ?, ? )";
                        $stmt = $db->prepare($sql);

                        if (!$stmt) {
                            die("Something went wrong whilst preparing statement.");
                        }

                        $stmt->bind_param("sss", $username, $email, $password_hashed);
                        $stmt->execute();

                        echo "Successfully registered!"; // TODO make cool display & redirect to home.php like 3 seconds after
                    }
                    
                }
            ?>
            </div>

            <div class="forms">
                <!-- TODO - add a tab switch between login and register -->
                <!-- Redirects to login.php, but if the login is successful, code above should redirect you to home.php -->

                <div class="form-box">
                    <!-- Login -->
                    <form method="POST" action="login.php"> 
                        <h2>Login</h2>

                        <div class="form-input">
                            <ion-icon name="person-outline"></ion-icon>

                            <input type="text" name="login" id="login" minlength="1" maxlength="20" required>
                            <label for="login">Username</label>
                        </div>

                        <div class="form-input">
                            <a href="#" id="showpassword"> <ion-icon name="eye-outline" id="showpassword-icon"></ion-icon> </a>
                            <ion-icon name="lock-closed-outline"></ion-icon>

                            <input type="password" name="password" id="password" required>
                            <label for="password">Password</label>
                        </div>

                        <div class="remember">
                            <input type="checkbox" name="rememberme" id="rememberme">
                            <label for="rememberme">Remember me!</label>
                        </div>
                        
                        <input type="submit" name="submit-login" id="submit-login" value="Log in!">

                        <div class="register">
                            <p>Don't have an account? <a href="#"> Register now!</a></p>
                        </div>
                    </form>
                </div>

                <div class="form-box">
                    <!-- Register -->
                    <form method="POST" action="login.php">
                        <h2>Register</h2>

                        <div class="form-input">
                            <input type="text" name="username" id="username" minlength="1" maxlength="20" required>
                            <label for="username">Username</label> 
                        </div>

                        <input type="submit" name="submit-register" id="submit-register" value="Register">
                    </form>
                </div>
            </div>
        </div>

    </main>

    <script src="login.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
