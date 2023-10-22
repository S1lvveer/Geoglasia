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
    
    require_once("require/utility.php");
    require_once("require/database.php");
    $user = getUser();
    
    // Create the header!
    require_once("components/header.php");

    ?>

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
        </div>
        
        
    </main>

    <script src="main.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 20,
            centeredSlides: true,
            loop: true,
            keyboard: {
                enabled: true,
            },
            autoplay: {
            delay: 6500,
            disableOnInteraction: false,
            },
            pagination: {
            el: ".swiper-pagination",
            clickable: true,
            },
            navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
            },
        });
    </script>
</body>
</html>