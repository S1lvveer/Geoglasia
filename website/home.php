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

        <section class="home-wrapper">
            <?php

                // for(int i = 1; i <= 16; i++){
                // I'm gonna show cards using php lmao
                // }
            ?>

            <section class="home-cards">

                <div class="card">
                    <div class="img-sect">img of country outline</div>

                    <h3></h3>
                    <ul>
                    </ul>
                    
                    <p class="description">
                    </p>
                </div>
            </section>


            
        </section>
    </main>

    <script src="main.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>