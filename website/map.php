<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geoglasia - Map</title>
    <!-- This is the map file! Very important! -->
    <!-- TODO: Big SVG map covering a majority of the screen, highlightable and clickable, markers placed in supported countries -->

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

            <!-- Hover & mouse position/scale info -->
            <div class="hover-info">
                <h2>Country:</h2>
                <h2 class="hovered-text">NONE</h2>
            </div>
            <div class="cursor-info">
                <h3 class="current-scale">Scale: 1.0x</h3>
                <h3 class="current-pos">Position: 0px, 0px</h3>

                <?php
                if ($user && $user['is_admin']) {
                ?>
                <div class="admin">
                    <h2 class="admin">Admin debugger</h2>
                    <h4 class="click-origin admin">Country origin [topleft]: <span class='copyable'>Click something!</span></h4>
                    <h4 class="click-offset admin">[copy to db] Offset by: <span class='copyable'>Click something!</span></h4>
                </div>
                
                <?php
                }
                ?>
            </div>
            
            <div class="svg-container">
                <div class="markers" style='visibility: hidden'>
                    <?php
                    $getPlaces = "SELECT * FROM places";
                    $places = $db->query($getPlaces);

                    // Loop through all places, find the corresponding country, get the country code
                    
                    while ($place = $places->fetch_assoc()) {
                        // Get the corresponding country
                        $country_id = $place['country_id'];
                        $getCountryInfo = "SELECT * FROM countries WHERE country_id = $country_id";
                        $result = $db->query($getCountryInfo);
                        $country = $result->fetch_assoc();

                        // Get variables
                        $countryCode = $country['country_code'];
                        $locationOffset = $place['location_offset']; // (varchar 255, store a whole translate parameter in there)
                        $countryName = $country['country_name'];
                        $placeName = $place['city'];
                        $cityIMG = $place['cityIMG'];
                        $city_desc = $place['city_desc'];

                        // Create a marker element [and pass country-code + location offset so we can set it in JS]
                        printf(
                            '<div class="marker" data-country-code="%s" data-offset="%s" data-img="%s" data-desc="%s" data-name="%s" data-country="%s">
                                <span class="tooltip">%s, %s</span>
                                <div class="mark"></div>
                            </div>', $countryCode, $locationOffset, $cityIMG, $city_desc, $placeName, $countryName, $placeName, $countryName);
                        
                    }
                    ?>

                    <!-- <div class="marker">
                        <span class="tooltip">This will appear when hovered</span>
                        <a class="mark"></a>  This gets filled in by JS
                    </div> -->
                </div>
            </div>
        </div>

        <section class="booking">
            <?php
            if (!$user) {
            ?>
            <div class="not-logged-in">
                <ion-icon name="warning" class="warning"></ion-icon>
                <h2>Log in to start booking!</h2>
            </div>
            

            <?php } 
            else 
            { ?>

            <img alt="One of our wonderful booking destinations!" class='place-image' src="https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png">

            <div class="info">
                <h3 class="name">Place name, Country name</h3>
                <p class="desc">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Excepturi, nostrum.</p>
            </div>

            <div class="date-info">
                <p class="startdate">Start date: TBD</p>
                <p class="enddate">End date: TBD</p>
            </div>

            <form action="map.php" method="POST">
                <!-- All the booking table parameters -->
                <input type="hidden" name="place_id" id="place_id">
                <input type="hidden" name="book_date" id="book_date">
                <input type="hidden" name="book_start" id="book_start">
                <input type="hidden" name="book_end" id="book_end">

                <button name="submit" id="submit">Book this place!</button>
            </form>
            <?php } ?>

            <section class="booking-results">
                <?php
                if (isset($_POST['submit'])) {
                    $place_id = $_POST['place_id'];
                    $user_id = $user['user_id'];
                    $book_date = $_POST['book_date'];
                    $book_start = $_POST['book_start'];
                    $book_end = $_POST['book_end'];

                    $sql = "INSERT INTO booking(place_id, user_id, book_date, book_start, book_end) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param("iisss", $place_id, $user_id, $book_date, $book_start, $book_end);
                    $stmt->execute();

                    echo "<div class='success'> Successfully booked! </div>";
                }
                ?>
            </section>
        </section>

    </main>

    

    <script src="js/map.js"></script>
    <script src="js/main.js"></script>
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>