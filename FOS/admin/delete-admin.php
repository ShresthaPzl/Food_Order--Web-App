
<?php
    include("../config/constants.php");
    // 1. Get the ID of Admin to be deleted
        $id = $_GET['id'];
    // 2. Create SQL Query to Delete Admin
        $sql = "DELETE FROM tbl_admin WHERE id = $id";

        // Execute the Query
        $statement = mysqli_query($conn, $sql);

        // Check Whether the Query is executed successfully or not
        if($statement == TRUE)
        {
            // Query Executed Successfully and Admin Deleted
            //echo "Admin Deleted.";

        // 3. Redirect to Manage admin page with message
            // Create session variable to display the message
            $_SESSION['delete-admin'] = "<div class='success'>Admin Deleted Successfully :)</div>";

            // Redirect to Manage admin page
            header('location:' . $siteURL . 'admin/manage-admin.php');
        }
        else
        {
            // Failed to Delete Admin
            //echo "Failed to Delete Admin!";

            // Create session variable to display the message
            $_SESSION['delete-admin'] = "<div class='error'>Failed to delete Admin! </div>";

            // Redirect to Manage admin page
            header('location:' . $siteURL . 'admin/manage-admin.php');
        }
    

?>