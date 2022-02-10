<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>

        <br><br>
        <?php
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
            }


        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td> Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>

                <tr>
                    <td> New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td> Confirm Password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value=" <?=$id; ?>";>
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            // Check whether the submit button is clicke or not
            if(isset($_POST['submit']))
            {
                //echo "Clicked";
                
                // 1. Get the data from Form 
                $id = $_POST['id'];
                $current_password = md5($_POST['current_password']);
                $new_password = md5($_POST['new_password']);
                $confirm_password = md5($_POST['confirm_password']);

                
                // 2. Check whether the users  with current ID and Current Password exists or not
                $sql = "SELECT * FROM tbl_admin WHERE id = $id && password ='$current_password'";

                    // Execute the query
                $statement = mysqli_query($conn, $sql);

                    // Check wether the query is execute or not
                if($statement == TRUE)
                {
                    // Check whether data is available or not
                    $cout = mysqli_num_rows($statement);

                    if($cout == 1)
                    {
                        // User Exist and Password can be changed
                        //echo "User is found";

                        // Check whether the new password and confirm match or not

                        if($new_password === $confirm_password)
                        {
                            // Update the password

                            // SQL Query to update the password in database
                            $sql1 = "UPDATE tbl_admin SET
                                password = '$new_password'
                                WHERE id = $id
                            ";
                                
                                // Execute the query
                            $statement = mysqli_query($conn, $sql1);

                                // Check whether the query is executed or not
                            if($statement == TRUE)
                            {
                                // Display success message
                                $_SESSION['change-password'] = "<div class='success'>PASSWORD CHANGED SUCCESSFULLY!</div>";
                                header('location:' . $siteURL . 'admin/manage-admin.php');
                            }
                            else
                            {
                                // Display Error Message
                                $_SESSION['change-password'] = "<div class='error'>FAILED TO CHANGE PASSWORD!</div>";
                                header('location:' . $siteURL . 'admin/manage-admin.php');
                            }

                        }
                        else
                        {
                            // Redirect to manage admin with Error message
                            $_SESSION['password-not-match'] = "<div class='error'> PASSWORD DID NOT MATCH!</div>";
                        header('location:' . $siteURL . 'admin/manage-admin.php');

                        }
                    }
                    else
                    {
                        // User Does not Exist and set messaeg  ,redirect
                        $_SESSION['user-not-fount'] = "<div class='error'> USER NOT FOUND!</div>";
                        header('location:' . $siteURL . 'admin/manage-admin.php');
                    }
                }
                // 3. Check whether the current or new password and confirm password match or not

                // 4. Chage Password if all above is true
            }


        ?>
    </div>
</div>


<?php include("partials/footer.php"); ?>