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

            <?php 
            if ($fileName == "home") {// Only show this on the home page, although it could be everywhere theoretically..
            ?>
            <!-- Spinning "Globasia" around the logo [hide in editor]-->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">>
                <!-- Create text 1 & 2 on the outside -->
                <text>
                    <textPath href="#circle-path">Geoglasia</textPath>
                    <animateTransform
                    attributeName="transform"
                    attributeType="XML"
                    type="rotate"
                    from="0 100 100"
                    to="360 100 100"
                    dur="20s"
                    repeatCount="indefinite"
                    />
                </text>

                <text>
                    <textPath href="#circle-path">Geoglasia</textPath>
                    <animateTransform
                    attributeName="transform"
                    attributeType="XML"
                    type="rotate"
                    from="180 100 100"
                    to="540 100 100"
                    dur="20s"
                    repeatCount="indefinite"
                    />
                </text>

                <!-- Define the path for the circle on the outside -->
                <path id="circle-path" d="M 100,180 A 80,80 0 0,1 20,100" fill="transparent" />
            </svg>

            <?php } ?>
        </div>
        

        <div class="nav-links">
            <?php
            // Display login when not logged in,
            // else display stuff related to the user's account

            if ($user) {
                $username = $user['login'];
                echo "<h3>
                <ion-icon name='person-circle-outline' class='icon'></ion-icon>
                > Howdy, <span class='greeting'>$username!</span>
                </h3>";

                if ($user['is_admin']) {
                    echo "<a href='admin.php'>
                    Admin Panel
                    </a>";
                }

                echo "<a href='logout.php'>
                Logout
                </a>";
            } else { 
            ?>

            <?php

                // For anything BUT the login page - Login
                if ($fileName != "login") 
                    echo "<a href='login.php' class='logintext'>
                        <ion-icon name='person-circle-outline' class='icon'></ion-icon>
                        Login
                    </a>";
            ?>
            <?php 
            } 
            ?>

            <!-- <a href="#">User</a> -->
            
            <button class="cta">See offers</button>
        </div>
    </header>