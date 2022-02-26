<?php

    include("../config/constants.php");
    // Check whether the id and image_name value is set or not

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        // Get the value and delete
        // echo "Value set and deleted";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Remove the physical presence of file if available then only we will delete data from database
        if($image_name != "")
        {
            // Image is available. So remove it
            $path = "../images/StorageDB/Category/".$image_name;
            // Remove the Image
            $remove = unlink($path);

            // If failed to remove image then add an error message and stop the process
            if($remove == FALSE)
            {
                // Set the session message
                $_SESSION['remove'] = "<div class='error'> Failed to Remove Category Image! </div>";
                // REdirect to manage category page
                header('location:' .$siteURL. 'admin/manage-category.php');
                // Stop the process
                die();
            }
        }
        

        // Delete Data from Database
        $sql = "DELETE FROM tbl_category WHERE id= $id";
        
            // Execute the query
        $statement = mysqli_query($conn, $sql);

            // Check whether the query executed or not
        if($statement == TRUE)
        {
            // Set Success message and Redirect
            $_SESSION['delete'] = "<div class='success'> Category Deleted Successfully! </div>";
            //Redirect to manage category
            header('location:' . $siteURL. 'admin/manage-category.php');
        }
        else
        {
            // Set error message and Redirect
            $_SESSION['delete'] = "<div class='error'> Failed to Delete Category! </div>";
            //Redirect to manage category
            header('location:' . $siteURL. 'admin/manage-category.php');
        }
        // REdirect to manage category page with message
    }
    else
    {
        // Redirect to manage category page
        header('location:' . $siteURL . 'admin/manage-category.php');
    }


?>