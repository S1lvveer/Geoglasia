<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geoglasia - About Us</title>

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
    <?php
    # Start up the session & check whether the user is logged in.
    session_start();
    
    if ( isset($_SESSION['Authenticated']) ) {
        # will deal with this later!
    }
    ?>

    <!-- Top navigation bar! -->
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
            <!-- <a href="login.html">User</a> -->
            <a href="login.php" class="logintext">
                <ion-icon name="person-circle-outline" class="icon"></ion-icon>
                Login
            </a>
            <a href="#">User</a>
            
            <button class="cta">Contact</button>
        </div>
    </header>

    <!-- Home items -->
    <main>
        <div class="aboutus">
            <h1>
                GEOGLASIA
            </h1>

            <h3>Your one-stop destination for travel around East Asia!</h3>
            <p>> Currently supports travel in Asian countries such as:</p>

            <div class="country-grid">
                <p data-country="SK">South Korea</p>
                <p data-country="JP">Japan</p>
                <p data-country="CN">China</p>
                <p data-country="TW">Taiwan</p>
                <p data-country="VN">Vietnam</p>
                <p data-country="KH">Cambodia</p>
                <p data-country="TH">Thailand</p>
                <p data-country="LA">Laos</p>
                <p data-country="BD">Bangladesh</p>
                <p data-country="BT">Bhutan</p>
                <p data-country="MY">Malaysia</p>
                <p data-country="SG">Singapore</p>
                <p data-country="MN">Mongolia</p>
                <p data-country="NP">Nepal</p>
                <p data-country="IN">India</p>
                <p data-country="MN">Myanmar</p>
            </div>
        </div>
    </main>


    <!--
        possible stuff to add to actual site lol
        <section class="home-wrapper">
        <div class="card" style="display: block; width: 250px; height: 150px; background-color: aliceblue; border-radius: 25px;">

        </div>
    </section>
    -->
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>