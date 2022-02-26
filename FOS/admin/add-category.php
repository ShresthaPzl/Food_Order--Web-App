<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>

        <br><br>

        <?php
        // Checking and Displaying the add session
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }


        // Checking and Displaying the upload session

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <br>

        <!-- Add Category Starts -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td> Title: </td>
                    <td>
                        <input type="text" name="title" placeholder=" Category Title ">
                    </td>
                </tr>

                <tr>
                    <td> Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td> Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td> Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>



            </table>
        </form>
        <!-- Add Category Ends -->

        <?php

        // Check whether the submit button is clicked or not
        if (isset($_POST['submit'])) {
            //echo "Clicked";

            // 1. Get the value from category form
            $title = $_POST['title'];

            // For radio type, we need to check whether the button is select or not

            // For Featured radio button
            if (isset($_POST['featured'])) {
                // Get the value from form
                $featured = $_POST['featured'];
            } else {
                // Set the Default value
                $featured = "No";
            }

            // For Active radio button
            if (isset($_POST['active'])) {
                // Get the value from form
                $active = $_POST['active'];
            } else {
                // Set the Default value
                $active = "No";
            }

            // Check wether the image is selected or not and set the value for image accordingly
            //print_r($_FILES["image"]);
            //die(); // Break the code here

            if (isset($_FILES['image']['name'])) {
                // Upload the image
                // To Upload the image we need image name, source path and destination path

                $image_name = $_FILES['image']['name'];

                // Upload the image only if image is selected
                if ($image_name != "") {
                    // Auto Rename our image
                    // Get the extension of our image (jpg, png, gif, etc) e.g. "food1.jpg";
                    $exe = end(explode('.', $image_name)); // explode(); - function used to split the string from given symbol
                    // end(); - function take the end part of the split as we need the last part which is extension


                    // Rename the Image
                    $image_name = "Food_Category_" . rand(000, 99) . '.' . $exe; // e.g. Food_Category_093.jpg 




                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/StorageDB/Category/" . $image_name;

                    // Finally upload the image

                    $upload = move_uploaded_file($source_path, $destination_path);

                    // Check whether the image is uploaded or not
                    // adn if the image is not uploaded then we will stop the process and redirect with error message

                    if ($upload == FALSE) {
                        // Set Message
                        $_SESSION['upload'] = "<div class='error'> Failed to Upload Image! </div>";
                        // REdirect to add category page
                        header('location:' . $siteURL . 'admin/add-category.php');

                        // stop the process
                        die();
                    }
                }
            } else {
                // Don't upload image and set the image name value as blank
                $image_name = "";
            }


            // 2. Create SQL Query to insert category into database

            $sql = "INSERT INTO tbl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'

                ";

            // Execute the query
            $statement = mysqli_query($conn, $sql);

            // Check whether the query is execute or not

            if ($statement == TRUE) {
                // Query  Executed and Category added
                $_SESSION['add'] = "<div class='success'> Category Added Successfully! </div>";
                // Redirect to the manage category page
                header('location:' . $siteURL . 'admin/manage-category.php');
            } else {
                // Failed to Add Category
                $_SESSION['add'] = "<div class='error'> Failed To Add Category ! </div>";
                // Redirect to the manage category page
                header('location:' . $siteURL . 'admin/add-category.php');
            }
        }


        ?>
    </div>
</div>

<?php include("partials/footer.php"); ?>