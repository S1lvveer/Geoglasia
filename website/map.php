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
                <h3>Country:</h3>
                <h3 class="hovered-text">NONE</h3>
            </div>
            <div class="cursor-info">
                <!-- <h3>Scale:</h3> -->
                <h3 class="current-scale">Scale: 1.0x</h3>
                <!-- <h3>Position on map:</h3> -->
                <h3 class="current-pos">Position: 0px, 0px</h3>
            </div>
            
            <div class="svg-container"></div>
        </div>
    </main>

    <script src="js/map.js"></script>
    <script src="js/main.js"></script>
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>