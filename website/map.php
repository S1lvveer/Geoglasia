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

    <?php
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // All things related to booking! (This needs to be above the map generation code, so all the information is always kept up-to-date.) //

    // Create a popup of class "class"
    $popups = array();
    function popup($class, $text) {
        global $popups;
        $entry = 
        "<div class='$class'>
            $text
            <button class='close' onclick='closePopup(this)'>X</button>
        </div>";

        array_push($popups, $entry);
    }

    // Display all popups by the end (to make sure every info is updated)
    function displayPopups() {
        global $popups;
        foreach($popups as $entry) {
            echo $entry;
        }
    }

    if (isset($_POST['submit'])) {
        $place_id = (int)$_POST['place_id'];
        $user_id = $user['user_id'];
        $place_name = $_POST['place_name'];

        // Store errors here
        $errors = array();

        // Today's date
        $book_date = date("Y-m-d");


        // Ensure on the server that a valid one doesn't exist yet
        $stmt = $db->prepare("SELECT * FROM booking WHERE place_id = ? AND book_start > ?");
        $stmt->bind_param("ss", $place_id, $book_date);
        $stmt->execute();

        $result = $stmt->get_result();
        $doesExist = $result->num_rows;
        //echo "$doesExist";

        // If the booking doesn't exist yet, create it!
        if ($doesExist == 0) {
            // Firstly, ensure on the server that a valid one doesn't exist yet



            // Generate database friendly dates, along with a random start + end date + random max participants!
            $randomParticipants = mt_rand(4,8);
            $randomStart = mt_rand(1, 28); // trip starts in 1-28 days
            $randomEnd = $randomStart + mt_rand(3,21); // trip will last for 3-14 days
            $book_start = date("Y-m-d", strtotime("+$randomStart days"));
            $book_end = date("Y-m-d", strtotime("+$randomEnd days"));

            
            //var_dump($place_id, $randomParticipants, $book_start, $book_end);

            $stmt->close();
            $stmt = $db->stmt_init();
            $stmt->prepare( "INSERT INTO booking(place_id, max_participants, book_start, book_end) VALUES (?, ?, ?, ?)" );
            $stmt->bind_param("iiss", $place_id, $randomParticipants, $book_start, $book_end);
            $stmt->execute();

            $lastid = $stmt->insert_id;

            $stmt->close();
            $addToBooking = "INSERT INTO user_bookings(user_id, book_id, book_date) VALUES (?, ?, ?)";
            $stmt = $db->stmt_init();
            $stmt->prepare($addToBooking);
            $stmt->bind_param("iis", $user_id, $lastid, $book_date);
            $stmt->execute();

            popup("success", "You are position 1/$randomParticipants.");
            popup("success", "The trip will start at $book_start (in $randomStart days), and end at $book_end (in $randomEnd days)!");
            
        } else {
            // The booking already exists!
            $book_id = $_POST['book_id'];
            $book_start = $_POST['book_start'];
            $book_end = $_POST['book_end'];
            $max_participants = (int)$_POST['max_participants'];
            //var_dump($book_id, $book_start, $book_end, $max_participants);


            //var_dump($book_id, $user_id);
            // Find out whether the user is already booked here
            $stmt->close();
            $stmt = $db->stmt_init();
            $stmt->prepare("SELECT * FROM user_bookings WHERE book_id = ? AND user_id = ?");
            $stmt->bind_param("ss", $book_id, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $isBooked = $result->num_rows;

            if ($isBooked == 0) {
                // The user isn't booked yet!

                // Find out if there is an eligible spot
                $stmt->close();
                $stmt = $db->stmt_init();
                $stmt->prepare("SELECT * FROM user_bookings WHERE book_id = ?");
                $stmt->bind_param("s", $book_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $amount = $result->num_rows;

                if ($amount < $max_participants) {
                    // There is a spot!

                    $stmt->close();
                    $addToBooking = "INSERT INTO user_bookings(user_id, book_id, book_date) VALUES (?, ?, ?)";
                    $stmt = $db->prepare($addToBooking);
                    $stmt->bind_param("sss", $user_id, $book_id, $book_date);
                    $stmt->execute();

                    $userPosition = $amount + 1;
                    popup("success", "You are position $userPosition/$max_participants.");
                } else {
                    array_push($errors, "The booking is filled. ($max_participants/$max_participants participants)");
                }
            } else {
                array_push($errors, "You are already booked to $place_name.");
            }
            
        }

        if (count($errors) > 0) {
            // Display all errors!
            foreach ($errors as $error) {
                popup("fail", "$error");

            }
        } else {
            // Successful!
            popup("success", "Successfully booked a trip to $place_name!");
        }
    }
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

                        // Get the corresponding booking (if it exists)
                        $today = date("Y-m-d");
                        $place_id = $place['place_id'];
                        $getBookInfo = "SELECT * FROM booking WHERE place_id = $place_id AND book_start > $today";
                        $result = $db->query($getBookInfo);

                        // Fill up the booking attributes (otherwise it's hard to decide whether to add these attributes or not)
                        $booking_data_attributes = "";
                        if ($result->num_rows > 0) {
                            $booking = $result->fetch_assoc();
                            
                            $book_id = $booking['book_id'];
                            $book_start = $booking['book_start'];
                            $book_end = $booking['book_end'];
                            $max_participants = $booking['max_participants'];

                            // Check for how many participants there are.
                            $stmt = $db->stmt_init();
                            $stmt->prepare("SELECT * FROM user_bookings WHERE book_id = ?");
                            $stmt->bind_param("s", $book_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $participants = $result->num_rows;
                            $stmt->close();

                            

                            // Finally, fill the booking attributes
                            $booking_data_attributes = sprintf(
                            'data-bookid="%s" data-bookstart="%s" data-bookend="%s" data-participants="%s" data-max-participants="%s"'
                            ,$book_id, $book_start, $book_end, $participants, $max_participants
                            );
                        }

                        // Get variables
                        $countryCode = $country['country_code'];
                        $locationOffset = $place['location_offset']; // (varchar 255, store a whole path percent offset in there)
                        $countryName = $country['country_name'];
                        $placeName = $place['city'];
                        $cityIMG = $place['cityIMG'];
                        $city_desc = $place['city_desc'];

                        // Create a marker element [and pass country-code + location offset so we can set it in JS]
                        printf(
                            '<div class="marker" data-country-code="%s" data-offset="%s" data-img="%s" data-desc="%s" data-name="%s" data-country="%s" data-placeid="%s" %s>
                                <span class="tooltip">%s, %s</span>
                                <div class="mark"></div>
                            </div>', $countryCode, $locationOffset, $cityIMG, $city_desc, $placeName, $countryName, $place_id, $booking_data_attributes, $placeName, $countryName);
                        
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
                <h3 class="name">Select a place.</h3>
                <p class="desc">Select a place to start booking!</p>
            </div>

            <div class="trip-info">
                <p class="startdate">Start date: TBD</p>
                <p class="enddate">End date: TBD</p>
                <p class="participants">Participants: None!</p>
            </div>

            <form action="map.php" method="POST">
                <!-- All the booking table parameters needed -->
                <input type="hidden" name="place_id" id="place_id">

                <input type="hidden" name="book_id" id="book_id">
                <input type="hidden" name="book_start" id="book_start">
                <input type="hidden" name="book_end" id="book_end">
                <input type="hidden" name="participants" id="participants">
                <input type="hidden" name="max_participants" id="max_participants">

                <!-- Extra parameters so I can see stuff in php code -->
                <input type="hidden" name="place_name" id="place_name">

                <button name="submit" id="submit" disabled>Book this place!</button>
            </form>
            <?php } ?>

            <section class="booking-results">
                <?php
                displayPopups();
                ?>
            </section>
        </section>

    </main>

    
    <script>
        // Close a php popup.
        function closePopup(element) {
            element.parentElement.remove();
        }
    </script>

    <script src="js/map.js"></script>
    <script src="js/main.js"></script>
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>