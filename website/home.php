<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geoglasia - Home</title>

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

            <!-- Spinning "Globasia" around the logo [hide in editor]-->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">>
                <!-- Create text 1 & 2 on the outside -->
                <text>
                    <textPath href="#circle-path">Geoglasia</textPath>
                    <animateTransform
                    attributeName="transform"
                    attributeType="XML"
                    type="rotate"
                    from="0 100 100"
                    to="360 100 100"
                    dur="20s"
                    repeatCount="indefinite"
                    />
                </text>

                <text>
                    <textPath href="#circle-path">Geoglasia</textPath>
                    <animateTransform
                    attributeName="transform"
                    attributeType="XML"
                    type="rotate"
                    from="180 100 100"
                    to="540 100 100"
                    dur="20s"
                    repeatCount="indefinite"
                    />
                </text>

                <!-- Define the path for the circle on the outside -->
                <path id="circle-path" d="M 100,180 A 80,80 0 0,1 20,100" fill="transparent" />
            </svg>
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
        <div class="map">

        </div>

        <section class="home-wrapper">
        
        <section class="home-cards">
        <div class="card">
            <div class="img-sect">img of country outline</div>

            <h3>Japan</h3>
            <ul>
                <li>Tokyo</li>
                <li>Kyoto</li>
            </ul>
            
            <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
            Ut enim ad minim veniam, quis nostrud exercitation ullamco 
            laboris nisi ut aliquip ex ea commodo consequat.
            </p>
            <!--
                place p at the end
            -->
        </div>
        </section>
        
    </section>
    </main>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>