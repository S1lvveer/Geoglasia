<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geoglasia - Admin Panel</title>

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
    // Start up the session & check whether the user is logged in.
    session_start();

    require_once("require/utility.php");
    require_once("require/database.php");
    $user = getUser();
    
    // Create the header!
    require_once("components/header.php");

    // Only load the page if the user is an admin.
    if ($user && $user['is_admin'] ) { # remove || true once we only want admins to view this, or add "|| true" if you want the statement to always go thru
    ?>


    <!-- Home items -->
    <main>
        <!-- <section class="UserStats">
            <table>
                <tr>
                    <th>login</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Date of Birth</th>
                </tr>
                <tr>

                </tr>
            </table>
        </section>

        <section class="BookingStats">
            <table>
                <tr>
                    <th>Country</th>
                    <th>City</th>
                    <th>User</th>
                    <th>Date of booking</th>
                    <th>Reservation start</th>
                    <th>Reservation end</th>    
                </tr>
            </table>
        </section> -->
    </main>

    <?php
    } else {
        echo "<div class='db-error-alert'> ERROR: You are not permitted to view this page. </div>";
    };
    ?>

    <script src="js/main.js"></script>
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    
</body>
</html>