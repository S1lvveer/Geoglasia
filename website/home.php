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

   <!-- Link Swiper's CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

</head>
<body>
    <?php
    # Start up the session & check whether the user is logged in.
    session_start();
    
    require_once("require/database.php");
    $user = getUser();
    
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

            <!-- The name of the current page, ex. "The Admin Panel" -->
            <div class="page-name">
                <h1 class="name">
                    <?php
                    require_once("require/utility.php");
                    echo get_page_text($fileName);
                    ?>
                </h1>
            </div>
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
            
            <?php
            // Display login when not logged in, display username & button to user settings if you are

            if ($user) {
                $username = $user['login'];
                echo 
                "<h3>
                <ion-icon name='person-circle-outline' class='icon'></ion-icon>
                > Howdy, <span class='greeting'>$username!</span>
                </h3>";
            } else { 
            ?>
                <a href="login.php" class="logintext">
                    <ion-icon name="person-circle-outline" class="icon"></ion-icon>
                    Login
                </a>
            <?php 
            } 
            ?>

            <a href="#">User</a>
            
            <button class="cta">See offers</button>
        </div>
    </header>

    <!-- Home items -->
    <main>
        
        <div class="map">
            <div class="map-bg"></div>
            
        </div>
    
        <!-- infinite swiper -->
        <div class="swiper mySwiper home-cards">
            <div class="swiper-wrapper">
<?php
    $countriesQuery = 'SELECT countries.country_name, countries.country_desc FROM countries';
    $placesQuery = 'SELECT places.city FROM places';

    $countryResult = $db->query($countriesQuery);

    while ($row = $countryResult->fetch_assoc()) {
        printf("
        <div class='swiper-slide card'>
            <div class='img-sect'>img of country outline</div>
    
            <h3>%s</h3>
            <ul></ul>
        
            <div class='description'>%s</div>
        </div>", $row['country_name'], $row['country_desc']);
    }

    $countryResult->free_result();

    // If you want to display data from the "places" table as well, use a similar approach with the $placesQuery.
?>
        </div>
        </div>
        <div class="swiper-pagination"></div>
        
    </main>

    <script src="main.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 10,
    loop: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      640: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      768: {
        slidesPerView: 4,
        spaceBetween: 40,
      },
      1024: {
        slidesPerView: 5,
        spaceBetween: 50,
      },
    },
  });
</script>
</body>
</html>