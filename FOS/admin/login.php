<?php include("../config/constants.php"); ?>

<html>
  <head>
    <title>LogIn - Food Order System</title>
    <link rel="stylesheet" href="../CSS/admin.css">
  </head>

  <body>
    
    
    <div class="login">
      <h1 class="text-center">Login</h1>
      <br><br>
      <?php

      // Checking and Displaying login session
      if(isset($_SESSION['login']))
      {
        echo $_SESSION['login'];
        unset($_SESSION['login']);
      }

      // Checking and Displaying no-login-message session
      if(isset($_SESSION['no-login-message']))
      {
        echo $_SESSION['no-login-message'];
        unset($_SESSION['no-login-message']);
      }

      ?>

      <br><br>
      <!-- Log In Form -->
      <form action="" method="POST" class="text-center">

        Username : 
        <input type="text" name="username" placeholder="Enter Username">

        <br><br>

        Password :
        <input type="password" name="password" placeholder="Enter Password">

        <br><br>

        <input type="submit" name="submit" value="LogIn">



      </form>


      <br><br><br>
      <p class="text-center">Created By - <a href="https://Www.pzlshrestha.com">Shrestha Pzl</a></p>
    </div>
      
  </body>
</html>

<?php
  // Check whether the submit button is clicked or not

  if(isset($_POST['submit']))
  {
    // Process for login
    
    // 1. Get the data from login form
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // 2. SQL Query to check whether the user with username and password exists or not

    $sql = "SELECT * FROM tbl_admin WHERE username = '$username' && password = '$password'";

    // 3. Execute the Query 
    $statment = mysqli_query($conn, $sql);

    // 4. Count rows to check whether the users exist or not

    $count = mysqli_num_rows($statment);

    if($count == 1)
    {
      // User Available and login Success
      $_SESSION['login'] = "<div class='success'> Welcome, $username!</div>";
      $_SESSION['user'] = $username; // To check whether the user is logged in or not and logout will unset it
      // Redirect to Home Page/Dashboard
      header('location:' . $siteURL. 'admin/');
    }
    else
    {
      // User Not Available and Login Failed
      $_SESSION['login'] = "<div class='error text-center'> Login Failed ! Try Again with Valid username or password!!!</div>";
      // Redirect to Home Page/Dashboard
      header('location:' . $siteURL. 'admin/login.php');

    }


  }


?>