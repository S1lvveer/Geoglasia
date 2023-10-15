const logo = document.querySelector(".logo");

// Redirect to 'home.php' when the globe is clicked.
logo.addEventListener("click", (e) => {
    e.preventDefault();

    window.location.href = "home.php";
})