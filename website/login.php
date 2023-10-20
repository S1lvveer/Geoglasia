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

    <link rel="icon" href="../assets/globe.svg">
</head>
<body>
    <?php
    # Start up the session & check whether the user is logged in.
    session_start();
    
    require_once("require/database.php");

    $user = null;
    if ( isset($_COOKIE['user_id']) ) {
        $userid = $_COOKIE['user_id'];

        // Find user and save it to the $user variable
        $sql = "SELECT * FROM users WHERE user_id = $userid";
        $result = $db->query($sql);

        $user = $result->fetch_assoc();
    }

    ?>
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
            
            <button class="cta">See offers</button>
        </div>
    </header>

    <main>

        <div class="loginandregister">
            <div class="warnings">
            <?php
                require_once("require/utility.php");

                // Login form [ Log in & store cookie ]
                if (isset($_POST['submit-login'])) {
                    $login = $_POST['login'];
                    $password = $_POST['password-login'];

                    $sql = "SELECT * FROM users WHERE login = '$login'";
                    $result = $db->query($sql);
                    $user = $result->fetch_assoc();
                    if ($user) {
                        // Function to hash the given password and compare it to the one saved in the database
                        if (password_verify($password, $user['password'])) {
                            // Redirect to home! Logged in!

                            // TODO set cookie!
                            // setcookie(name, value, expire, path, domain, secure, httponly);
                            setcookie('user_id', $user['user_id'], time() + 86400*2, '/');

                            echo "<div class='warning success'> Successfully logged in! Redirecting... </div>";
                            
                            redirect_in(2, "home.php");
                        } else {
                            echo "<div class='warning'> Password does not match. </div>";
                        }
                    } else {
                        echo "<div class='warning'> Username does not exist. </div>";
                    }
                }



                // Register form [ Error check, create user, log in & store cookie ]
                if (isset($_POST['submit-register'])) {
                    $login = $_POST['username'];
                    $password = $_POST['password-register'];
                    $email = $_POST['email'];
                    $name = $_POST['firstname'];
                    $surname = $_POST['lastname'];
                    $dob = $_POST['dob'];

                    $password_hashed = password_hash($password, PASSWORD_DEFAULT); // This is apparently a safe way to do it

                    // Server sided checks!
                    $errors = array();

                    if (empty($login) OR empty($email) OR empty($password)) {
                        array_push($errors, "All fields are required.");
                    }
                    /*if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        array_push($errors, "Email is invalid.");
                    }*/
                    
                    // Is email taken?
                    $sql = "SELECT * FROM users WHERE email = '$email'";
                    $is_taken = $db->query($sql);
                    $rows = $is_taken->num_rows;
                    if ($rows > 0) {
                        array_push($errors, "Email address is already in use.");
                    }

                    // Is username taken?
                    $sql = "SELECT * FROM users WHERE login = '$login'";
                    $is_taken = $db->query($sql);
                    $rows = $is_taken->num_rows;
                    if ($rows > 0) {
                        array_push($errors, "Username is already in use.");
                    }



                    // Count and display all errors!
                    if (count($errors) > 0) {
                        foreach ($errors as $error) {
                            echo "<div class='warning'> $error </div>"; // TODO make it a cooler alert display
                        }
                    } else {
                    // Create a new user!
                        $sql = "INSERT INTO users(login, email, password, name, surname, dob) VALUES( ?, ?, ?, ?, ?, ? )";
                        $stmt = $db->prepare($sql);

                        if (!$stmt) {
                            die("Something went wrong whilst preparing statement.");
                        }

                        $stmt->bind_param("ssssss", $login, $email, $password_hashed, $name, $surname, $dob);
                        $stmt->execute();

                        echo "<div class='warning success'>Successfully registered! Redirecting...</div>"; // TODO make it log in automatically as well
                        redirect_in(2, "home.php");
                    }
                    
                }
            ?>
            </div>

            <div class="forms">
                <!-- Redirects to login.php, but if the login is successful, code above should redirect you to home.php -->

                <div class="form-box" id="form-login">
                    <!-- Login -->
                    <form method="POST" action="login.php"> 
                        <h2>Login</h2>

                        <div class="form-input">
                            <ion-icon name="person-outline"></ion-icon>

                            <input type="text" name="login" id="login" minlength="1" maxlength="20" required>
                            <label for="login">Username</label>
                        </div>

                        <div class="form-input">
                            <a href="#" onclick="password_visibility(this);"> <ion-icon name="eye-outline"></ion-icon> </a>
                            <ion-icon name="lock-closed-outline"></ion-icon>

                            <input type="password" name="password-login" id="password-login" class="pass" required>
                            <label for="password-login">Password</label>
                        </div>

                        <div class="remember">
                            <input type="checkbox" name="rememberme" id="rememberme">
                            <label for="rememberme">Remember me!</label>
                        </div>
                        
                        <input type="submit" name="submit-login" id="submit-login" value="Log in!">

                        <div class="register">
                            <p>Don't have an account? <a href="#" onclick="form_visibility('register')"> Register now!</a></p>
                        </div>
                    </form>
                </div>

                <div class="form-box" id="form-register" style="display:none">
                    <!-- Register -->
                    <form method="POST" action="login.php">
                        <h2>Register</h2>

                        <div class="form-input">
                            <ion-icon name="person-outline"></ion-icon>
                            <input type="text" name="username" id="username" minlength="1" maxlength="20" required>
                            <label for="username">Username</label> 
                        </div>

                        <div class="double-input">
                            <div class="form-input">
                                <input type="text" name="firstname" id="firstname" minlength="1" maxlength="50" required>
                                <label for="firstname">First name</label>
                            </div>
                            
                            <div class="form-input">
                                <input type="text" name="lastname" id="lastname" minlength="1" maxlength="50" required>
                                <label for="lastname">Last name</label>
                            </div>
                        </div>

                        <div class="form-input">
                            <ion-icon name="mail-outline"></ion-icon>
                            <input type="email" name="email" id="email" required>
                            <label for="email">Email</label>
                        </div>

                        <div class="form-input">
                            <a href="#" onclick="password_visibility(this);"> <ion-icon name="eye-outline"></ion-icon> </a>
                            <ion-icon name="lock-closed-outline"></ion-icon>

                            <input type="password" name="password-register" id="password-register" class="pass" required>
                            <label for="password-register">Password</label>
                        </div>

                        <div class="form-input">
                            <input type="date" name="dob" id="dob" required>
                            <label for="dob">Birth date</label>
                        </div>

                        <input type="submit" name="submit-register" id="submit-register" value="Register">

                        <div class="register">
                            <p>Already have an account? <a href="#" onclick="form_visibility('login')"> Log in!</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </main>


    <script src="login.js"></script>
    <script src="main.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
