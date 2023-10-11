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
            <a href="#">
                <ion-icon class="icon" name="help-circle-outline"></ion-icon>
                About us
            </a>
            <a href="home.html">
                <ion-icon class="icon" name="home-outline"></ion-icon>
                Home
            </a>
            <a href="#">
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
        <?php
        @$db = new mysqli('localhost', 'root', '', 'project_pai');
        if ($db->connect_errno) {
            echo "ziemniaki - connection failed: " . $db->connect_error;
        }
        ?>

        <!-- TODO - add a tab switch between login and register -->
        <div class="form-box">

            <form method="POST" action="home.php">
                <h2>Login</h2>

                <div class="inputbox">
                    <ion-icon name="person-outline"></ion-icon>
                    <input type="text" name="login" id="login" minlength="1" maxlength="20" required>
                    <label for="login">Username</label>
                </div>
                <!-- How do you change the placement of lock and eye? -->
                <div class="inputbox">
                    <a href="#" id="showpassword"> <ion-icon name="eye-outline" id="showpassword-icon"></ion-icon> </a>
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="password" id="password" required>
                    <label for="password">Password</label>
                </div>

                <div class="remember">
                    <input type="checkbox" name="rememberme" id="rememberme">
                    <label for="rememberme">Remember me!</label>
                </div>
                
                <button>Log in!</button>

                <div class="register">
                    <p>Don't have an account? <a href="#"> Register now!</a></p>
                    <!-- 
                        Should we make another site called register.php
                        or try to work our way around login? 
                        cookies? 

                        ^ I'll expand this form box to switch between login and register with a slider of some sorts
                    -->
                </div>
            </form>
            
        </div>
<?php
    //function used to check user data in DB
    function check(){
        //some code to check if there's user like that lol
    }
?>
    </main>

    <script src="login.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
