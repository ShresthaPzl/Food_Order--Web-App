<?php
    // Include Constatns page
    include("../config/constants.php");
    if(isset($_GET['id']) && isset($_GET['image_name'])) {  //  Either user '&&' or 'AND'

        // Process to Delete
        // Echo "Process to Delete";

        // 1. Get ID and Image Name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // 2. Remove the Image if Available
            // Check whether the image is available or not and delete only if it is available
            if($image_name != "") {

                // It has image and need to remove from folder
                
                // Get the Image path
                $path = "../images/StorageDB/Food/".$image_name;

                // Remove Image file from folder
                $remove = unlink($path);

                // Check whether image is removed or not
                if($remove == False) {
                    // Failed to Remove image
                    $_SESSION['upload'] = "<div class='error'> Failed to Remove Image File! </div>";
                    header('location:'.$siteURL.'admin/manage-food.php');
                    
                    // Stop the process
                    die();
                }
            }

        // 3. Delete Food from Database
            $sql = "DELETE FROM tbl_food WHERE id=$id";

            // Execute the Query
            $statement = mysqli_query($conn, $sql);

            // Check whether query execute or not and set the session message respectively
            if($statement == TRUE) {

                // Food Deleted 
                $_SESSION['delete'] = "<div class='success'> Food Deleted Successfully! </div>";
                header('location:'.$siteURL.'admin/manage-food.php');
            } else {

                // Failed to Delete food
                $_SESSION['delete'] = "<div class='error'> Failed to Delete Food! </div>";
                header('location:'.$siteURL.'admin/manage-food.php');
            }
            
        
        // 4. Redirect to manage food with session message
    } else {

        // Redirect to manage food page
        // echo "Redirect";

        $_SESSION['unauthorized'] = "<div class='error'> Unauthorized Access.</div>";
        header('location:'.$siteURL.'admin/manage-food.php');
    }

?>