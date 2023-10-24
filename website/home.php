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

        <div class="reservation">

            <?php
            if (!$user) {
                // User is not logged in
            ?>
                <div class="not-logged-in">
                    <ion-icon name="warning" class="warning"></ion-icon>
                    <h2>Log in to see your reservations!</h2>
                </div>

            <?php 
            } else { 
                // User is logged in!
                $user_id = $user['user_id'];
                
                // Prepare a statement to grab all of our user's reservations.
                $stmt = $db->stmt_init();
                $stmt->prepare(
                    "SELECT booking.book_id, book_date, book_start, book_end, max_participants, city, pricePerDay
                    FROM user_bookings, booking, places
                    WHERE user_bookings.book_id = booking.book_id
                    AND booking.place_id = places.place_id
                    AND user_id = ?"
                );
                $stmt->bind_param("s", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                // Today's date
                $today = date("Y-m-d");

                while ($row = $result->fetch_assoc()) {
                    // Get number of participants in this booking
                    $book_id = $row['book_id'];

                    $stmt2 = $db->stmt_init();
                    $stmt2->prepare("SELECT * FROM user_bookings WHERE book_id = ? AND book_date < ?");
                    $stmt2->bind_param("is", $book_id, $row['book_start']);
                    $stmt2->execute();
                    $participants = $stmt2->get_result()->num_rows;
                    $stmt2->close();

                    // Collect basic information about the trip
                    $city = $row['city'];

                    $reservation_date = $row['book_date'];
                    $start_date = $row['book_start'];
                    $end_date = $row['book_end'];
                    $max_participants = $row['max_participants'];

                    $trip_length = date_diff(date_create($start_date), date_create($end_date));
                    $trip_length = $trip_length->format("%a");

                    // Display all the info about the trip!
                    printf(
                    "<div class='result'>
                        <h3>Reservation for %s:</h3>
                        <p>Reservation date: %s</p>
                        <p>Start date: %s</p>
                        <p>End date: %s (Trip lasts %s days)</p>
                        <p>Participants: %s/%s</p>
                        
                    </div>", $city, $reservation_date, $start_date, $end_date, $trip_length, $participants, $max_participants);
                }

                $stmt->close();
            } 

            ?>


        </div>
        <!-- infinite swiper -->
        <div class="swipeWrap"> <!-- this many divs is for actually getting the whole thing wrapped -->
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
                    ?>
                </div>
                <div class="swiper-pagination">
            </div>
        </div>
    </main>

    <script src="js/main.js"></script>

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