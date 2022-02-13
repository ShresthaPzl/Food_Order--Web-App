<?php
    // Check whether the user is loggged in or not - AUTHORIZATION or ACCESS CONTROL

    if(!isset($_SESSION['user']))  // If user session is not set
    {
        // User is not logged in 
        // Redirect to login page with message

        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access this page !</div>";
        
        // REdirect to login page
        header('location:' . $siteURL . 'admin/login.php');
    }


?>