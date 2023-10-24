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
        
        <div class="stats">
            <?php
            if (!$user) {
                // User is not logged in
            ?>
                <div class="not-logged-in">
                    <ion-icon name="warning" class="warning"></ion-icon>
                    <h2>Log in to see your stats!</h2>
                </div>

            <?php 
            } else { 
                echo "<h1>User statistics</h1>";

                // Get today's date
                $today = date("Y-m-d");

                // Get past, in progress, and future reservations
                $all_sql = "SELECT * 
                FROM user_bookings
                JOIN booking ON user_bookings.book_id = booking.book_id
                WHERE %s";

                $active_sql = sprintf($all_sql, "booking.book_start <= '$today' AND booking.book_end >= '$today'");
                $expired_sql = sprintf($all_sql, "booking.book_end < '$today'");
                $future_sql = sprintf($all_sql, "booking.book_start > '$today'");

                $active_query = $db->query($active_sql);
                $active = $active_query->num_rows;

                $expired_query = $db->query($expired_sql);
                $expired = $expired_query->num_rows;

                $future_query = $db->query($future_sql);
                $future = $future_query->num_rows;


                /*
                $query = "SELECT

                COUNT(CASE
                    WHEN booking.book_start <= $today AND booking.book_end >= $today THEN 1
                    ELSE 0
                END) AS active_reservations,
                COUNT(CASE
                    WHEN booking.book_end < $today THEN 1
                    ELSE 0
                END) AS expired_reservations,
                COUNT(CASE
                    WHEN booking.book_start > $today THEN 1
                    ELSE 0
                END) AS future_reservations

                FROM user_bookings
                JOIN booking ON user_bookings.book_id = booking.book_id
                WHERE user_id = ?";

                $stmt = $db->prepare($query);
                $stmt->bind_param("s", $user['user_id']);
                $stmt->execute();
                $stmt->bind_result($active, $expired, $future);
                $stmt->fetch();
                $stmt->close();
                */
                // ^ Doesn't work for some reason, shows them all up instead of just one :(. Also, this doesn't need to be prepared, as there is 0 user input.

                $total = $future + $active + $expired;

                echo "<p>You have $total total reservations.
                <br> -> $future are reserved,
                <br> -> $active are in progress,
                <br> -> $expired are expired.
                </p>";
            }
            ?>
            
        </div>

        <!-- infinite swiper left -->
        <div class="card-container left-card">
            <div class="swiper leftSwiper home-cards">
                <div class="swiper-wrapper country-list">
                    <?php
                    $countriesQuery = 'SELECT * FROM countries';

                    $countryResult = $db->query($countriesQuery);

                    while ($row = $countryResult->fetch_assoc()) {
                        $countryName = $row['country_name'];
                        $countryDesc = $row['country_desc'];
                        $countryCode = $row['country_code'];

                        printf("
                        <div class='swiper-slide card'>
                            <div class='country-outline' data-country-code='%s'></div>
                    
                            <h2>%s</h2>
                        
                            <div class='description'>%s</div>
                        </div>", $countryCode, $countryName, $countryDesc);
                    }

                    $countryResult->free_result();
                    ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
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
                echo "<h1>Your Reservations</h1>";
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
                    $stmt2->prepare("SELECT users.login FROM user_bookings, users 
                    WHERE user_bookings.user_id = users.user_id
                    AND book_id = ? AND book_date < ?");
                    $stmt2->bind_param("is", $book_id, $row['book_start']);
                    $stmt2->execute();
                    $participants = $stmt2->get_result();
                    $num_participants = $participants->num_rows;

                    $participantNames = "";
                    for ($i=1; $i<=$num_participants; $i++) {
                        $userRow = $participants->fetch_assoc();
                        $participantNames .= $userRow['login'];

                        if ($i != $num_participants)
                            $participantNames .= ", ";
                    }

                    $stmt2->close();

                    // Collect basic information about the trip
                    $city = $row['city'];

                    $reservation_date = $row['book_date'];
                    $start_date = $row['book_start'];
                    $end_date = $row['book_end'];
                    $max_participants = $row['max_participants'];
                    $pricePerDay = $row['pricePerDay'];

                    $trip_length = date_diff(date_create($start_date), date_create($end_date));
                    $trip_length = $trip_length->format("%a");

                    // Display all the info about the trip!
                    printf(
                    "<div class='result'>
                        <h2> > Reservation for <span class='placename'>%s</span> <</h2>
                        <p>Reservation date: <span>%s</span></p>
                        <p>Start date: <span>%s</span></p>
                        <p>End date: <span>%s (Trip lasts %s days) </span> </p>
                        <p>Participants: <span>%s/%s </span> [users: %s] </p>
                        <p>Price per day: <span>%s USD </span> </p>
                        
                    </div>", $city, $reservation_date, $start_date, $end_date, $trip_length, $num_participants, $max_participants, $participantNames, $pricePerDay);
                }

                $stmt->close();
            } 

            ?>
        </div>

        <!-- infinite swiper left -->
        <div class="card-container right-card">
            <div class="swiper rightSwiper home-cards">
                <div class="swiper-wrapper country-list">
                <?php
                        $placesQuery = 'SELECT places.*, country_name FROM places, countries
                        WHERE places.country_id = countries.country_id';

                        $placesResult = $db->query($placesQuery);

                        while ($row = $placesResult->fetch_assoc()) {
                            $countryRow = $placesResult->fetch_assoc();
                            $country = $countryRow['country_name'];

                            printf("
                            <div class='swiper-slide card'>
                                <div class='img-holder'> <img src='%s'> </div>
                        
                                <h2>%s, %s</h2>
                            
                                <div class='description'>%s</div>
                            </div>", $row['cityIMG'], $row['city'], $country, $row['city_desc']);
                        }

                        $placesResult->free_result();
                        ?>
                </div>
                <div class="swiper-pagination2"></div>
            </div>
        </div>
    </main>

    <script src="js/main.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


    <script>
    // Insert a country outline SVG for each country!
    const country_list = document.querySelector(".country-list");

    // Handle the SVG by setting its' viewbox to the boundingbox of the path.
    function setViewBox(svg) {
        let path = svg.querySelector("path");

        let bounds = path.getBBox();
        svg.setAttribute('viewBox', `${bounds.x} ${bounds.y} ${bounds.width} ${bounds.height}`);
    }

    // Detect whenever a child is added (in this case, an SVG).
    function childAdded(mutationList) {
        mutationList.forEach(mutation => {
            mutation.addedNodes.forEach(node => {
                if (node.tagName === 'svg') {
                    setViewBox(node);
                }
            })
        })
    }

    const observer = new MutationObserver(childAdded)
    observer.observe(country_list, {childList: true, subtree: true});
    // observer.observe()

    // Generate the map!
    fetch("../assets/asiaLow.svg")
        .then(response => response.text())
        .then(svgText => {
            // Loaded the file. Now I have to parse it
            const parser = new DOMParser();
            const doc = parser.parseFromString(svgText, 'image/svg+xml');

            function createCountrySVG(countryCode) {
                // Find the country's path in the svg file and single it out 
                let path = doc.getElementById(countryCode);
                if (path) {
                    let svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                    
                    svg.setAttribute('width', '100');
                    svg.setAttribute('height', '100');

                    //console.log(countryCode, "appended");
                    svg.appendChild(path.cloneNode(true));

                    return svg;
                }

                return null; // no country path found
            }

            // Loop through all of the outline elements, create an SVG in them!
            const outlines = document.querySelectorAll(".country-outline")
            outlines.forEach(outline => {
                let countryCode = outline.getAttribute("data-country-code");
                let svg = createCountrySVG(countryCode);
                if (svg) {
                    outline.appendChild(svg);
                }
            })
        })
        .catch(error => {
            console.error("Error loading the SVG file:", error);
        });
    </script>


    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".leftSwiper", {
            spaceBetween: 20,
            centeredSlides: true,
            loop: true,
            keyboard: {
                enabled: true,
            },
            autoplay: {
            delay: 5000,
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

        var swiper2 = new Swiper(".rightSwiper", {
            spaceBetween: 20,
            centeredSlides: true,
            loop: true,
            keyboard: {
                enabled: true,
            },
            autoplay: {
            delay: 5000,
            disableOnInteraction: false,
            },
        })
    </script>
</body>
</html>