<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Geoglasia - About Us</title>

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
          <div class="grid-wrapper">
          <?php
              $countryName = "SELECT countries.country_name FROM countries, places 
                              WHERE countries.country_id = places.country_id";

    $placeQuery = "SELECT places.city, places.city_desc, places.pricePerDay, places.cityIMG FROM places";    

              $result = $db -> query($placeQuery);
              $countryResult = $db -> query($countryName);

    while($row = $result -> fetch_assoc() AND $countryRow = $countryResult ->fetch_assoc()) {
        printf("
        <div class='grid-element'>
                <div class='img-sect'><img class='img-style' src='%s'></div>
                <div class='city-thingies'>
                    <h3>%s<br>%s</h3>
                    <div class='description'>%s</div>
                    <div><h2>%s USD/day</h2><a href='map.php'><button>Go book!</button></a></div>
                </div>
            </div>",$row['cityIMG'], $countryRow['country_name'], $row['city'], $row['city_desc'], $row['pricePerDay']);
    }
?>
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
      slidesPerView: 2,
      spaceBetween: 30,
      loop: true,
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