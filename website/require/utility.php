<?php
// Random utilities!

// Get page descriptions!
$pagedescs = [
    "home" => "<span> > Home < </span>",
    "aboutus" => "<span> > About Us < </span>",
    "admin" => "The <span> > Admin Panel < </span>",
    "login" => "<span> > Login </span> & <span> Register < </span>",
    "map" => "The <span> > Map < </span>"
];
function get_page_text($fileName) {
    global $pagedescs;

    if ($pagedescs[$fileName])
        return $pagedescs[$fileName];
    else
        return "";
}

// Creates a js script that redirects you in X seconds
function redirect_in($seconds, $location) {
    $ms = $seconds * 1000;
    echo "<script>
        setTimeout(() => {
            window.location.href = '$location';
        }, $ms);
    </script>";
}
?>