<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geoglasia - About Us</title>

    <link rel="stylesheet" href="style.css">
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
        <!-- I will complete the style.css soon! Just need the updated version first -->
        <div class="aboutus">
            <h1>Geoglasia! [Will complete style soon, just need updated version]</h1>
            <h3>Your one-stop destination for travel around Asia! <br>
            > Currently supports travel in Asian countries such as:
            </h3>
            <ul>
                <li>South Korea</li>
                <li>Japan</li>
                <li>China</li>
            </ul>
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