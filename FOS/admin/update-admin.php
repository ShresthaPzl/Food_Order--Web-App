<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php
            
            // 1. Get the id of selected admin
            $id = $_GET['id'];

            // 2. Create SQL Query to get the details
            $sql = "SELECT * FROM tbl_admin WHERE id = $id";

                // Execute the query
            $statement = mysqli_query($conn, $sql);

                // check whethe the query is executed or not
            if($statement == TRUE)
            {
                // Check whether the data is available or not
                $count = mysqli_num_rows($statement);
                
                // Check wether we have admin data or not

                if($count == 1)
                {
                    // Get the Details
                    //echo "Admin Available";
                    $row = mysqli_fetch_assoc($statement);

                    $full_name = $row['full_name'];
                    $username = $row['username'];


                }
                else
                {
                    // Redirect to manage admin page
                    header('location:' . $siteURL . 'admin/manage-admin.php');
                }

            }


        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td> Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value=" <?=$full_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td> Username: </td>
                    <td>
                        <input type="text" name="username" value=" <?=$username; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value=" <?=$id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            // Check whether the submit button is clicked or not
            if(isset($_POST['submit']))
            {
                // echo "Clicked";
                // Get all the values from form to update

                $id = $_POST['id'];
                $full_name = $_POST['full_name'];
                $username = $_POST['username'];
                

                // SQL Query to update admin

                $sql1 = "UPDATE tbl_admin SET
                    full_name = '$full_name',
                    username = '$username'
                    WHERE id = '$id';
                ";

                // Execute the query

                $statement = mysqli_query($conn, $sql1);

                // Check whether the query is execute or not
                if($statement == TRUE)
                {
                    // Query Executed and admin updated
                    $_SESSION['update-admin'] = "<div class='success'> Admin Updated Successfully!</div>";
                    // Redirect to manage admin page
                    header('location:' . $siteURL . 'admin/manage-admin.php');
                }
                else
                {
                    // Failed to update admin
                    // Query Executed and admin updated
                    $_SESSION['update-admin'] = "<div class='error'> Failed to Update Admin!</div>";
                    // Redirect to manage admin page
                    header('location:' . $siteURL . 'admin/manage-admin.php');
                }

            }


        ?>
    </div>
</div>


<?php include("partials/footer.php"); ?>