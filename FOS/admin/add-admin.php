<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php
            // Checking whether the session is set or not
            if(isset($_SESSION['add-admin']))
            {
                echo $_SESSION['add-admin']; // Display the session message
                unset($_SESSION['add-admin']); // Remove the session message
            }


        ?>
        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Your Username">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
    	                <input type="password" name="password" placeholder="Enter Your Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            // Process the value form Form and save it in database

            // Check whether the submit button is clicked or not

            if(isset($_POST['submit']))
            {
                // Button Clicked
                // echo "Button Clicked";

                // 1. Get the data from Form
                $full_name = $_POST['full_name'];
                $username = $_POST['username'];
                $password = md5($_POST['password']);  // md5(); - Function to do one way encryption

                // 2. SQL Query to save the data into database
                $sql = "INSERT INTO tbl_admin SET
                    full_name = '$full_name',
                    username = '$username',
                    password = '$password'
                ";

                // 3. Execute the query and save data in database
                $statement = mysqli_query($conn,$sql) or die();

                // 4. Check Whether the (Query is Executed or) data is inserted or not and display  appropriate message
                if($statement == TRUE)
                {
                    // Data is inserted
                    //echo "Data added successfully!";

                    // Create a session variable to display the message
                    $_SESSION['add-admin'] = "<div class='success'>Admin Added Successfully :) </div>";

                    // Redirect page to manage-admin page
                    header('location:' . $siteURL . 'admin/manage-admin.php');

                }
                else
                {
                    // Failed to Insert data
                    //echo "Fail to insert data";

                    // Create a session variable to display the message
                    $_SESSION['add-admin'] = "<div class='error'>Failed to add Admin :( </div>";

                    // Redirect page to manage-admin page
                    header('location:' . $siteURL . 'admin/add-admin.php');
                }



            } 



        ?>
    </div>
</div>



<?php include("partials/footer.php"); ?>