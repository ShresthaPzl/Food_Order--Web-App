<?php include("partials/menu.php"); ?>

<body>
    <div class="main-content">
        <div class="wrapper">

            <h1>Manage Admin</h1>
            <br><br>

            <?php
            // Checking and Displaying Add Admin Session
            if (isset($_SESSION['add-admin'])) {
                echo $_SESSION['add-admin']; // Displaying the session message
                unset($_SESSION['add-admin']); // Removing the session Message once it displayed
            }

            // Checking and Displaying Delete Admin Session
            if(isset($_SESSION['delete-admin']))
            {
                echo $_SESSION['delete-admin'];
                unset($_SESSION['delete-admin']);
            }

            // Checking and Displaying Update Admin Session
            if(isset($_SESSION['update-admin']))
            {
                echo $_SESSION['update-admin'];
                unset($_SESSION['update-admin']);
            }

            // CHecking and Displaying User not Found Session 
            if(isset($_SESSION['user-not-fount']))
            {
                echo $_SESSION['user-not-fount'];
                unset($_SESSION['user-not-fount']);
            }
            
            // Checking and Displaying Password not Match Session
            if(isset($_SESSION['password-not-match']))
            {
                echo $_SESSION['password-not-match'];
                unset($_SESSION['password-not-match']);
            }

            // Checking and Displaying change password Session
            if(isset($_SESSION['change-password']))
            {
                echo $_SESSION['change-password'];
                unset($_SESSION['change-password']);
            }

            ?>

            <br><br>
            <!-- Button to add Admin -->
            <a href="add-admin.php" class="btn-primary">Add Admin</a>

            <br><br>

            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>

                <?php
                // SQL Query to Get all the Admin 
                $sql = "SELECT * FROM tbl_admin";

                // Execute the query
                $statement = mysqli_query($conn, $sql);

                // Check whether the query is execute or not
                if ($statement == TRUE) {
                    // Count Rows to check if data is available or not on database
                    $count = mysqli_num_rows($statement); // mysqli_num_rows(); - function to check all the rows in database

                    $sn = 1;

                    // Check the num of rows
                    if ($count > 0) {
                        // We have data in database
                        while ($rows = mysqli_fetch_assoc($statement)) {
                            // Using while loop to get all the data from database
                            // and while loop will execute as long as we have data in database

                            // Get Individual data
                            $id = $rows['id'];
                            $full_name = $rows['full_name'];
                            $username = $rows['username'];

                            // Displaying the values in out table
                ?>
                            <tr>
                                <td> <?=$sn++; ?> </td>
                                <td> <?=$full_name; ?> </td>
                                <td> <?=$username; ?></td>
                                <td>
                                    <a href=" <?= $siteURL; ?>admin/update-password.php?id= <?=$id; ?>" class="btn-primary">Change Password</a>
                                    <a href=" <?= $siteURL; ?>admin/update-admin.php?id= <?=$id; ?>" class="btn-secondary">Update</a>
                                    <a href=" <?= $siteURL; ?>admin/delete-admin.php?id= <?=$id; ?>" class="btn-danger">Delete</a>
                                </td>
                            </tr>



                <?php
                        }
                    } else {
                        // We do not have data in database
                    }
                }


                ?>
            </table>
        </div>
    </div>
</body>




<?php include("partials/footer.php"); ?>