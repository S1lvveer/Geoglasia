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
                    <h2 class="admin">Click events</h2>
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

                        // Create a marker element [and pass country-code + location offset so we can set it in JS]
                        echo
                            "<div class='marker' data-country-code='$countryCode' data-offset = '$locationOffset'>
                                <span class='tooltip'>$placeName, $countryName</span>
                                <div class='mark'></div>
                            </div>";
                        
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
            
        </section>
    </main>

    

    <script src="js/map.js"></script>
    <script src="js/main.js"></script>
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>