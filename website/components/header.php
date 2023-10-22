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