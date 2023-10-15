<?php
// Random utilities!


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