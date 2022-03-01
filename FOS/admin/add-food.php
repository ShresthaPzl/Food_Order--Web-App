<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
            // checking and displaying the upload session
            if(isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td> Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Enter Food Title">
                    </td>
                </tr>

                <tr>
                    <td> Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td> Food Price: </td>
                    <td>
                        <input type="number" name="price" placeholder="Enter Food Price">
                    </td>
                </tr>

                <tr>
                    <td> Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td> Category: </td>
                    <td>
                        <select name="category">

                        <?php

                            // Create PHP code to display categories from database

                            // 1. Create SQL Query to get all active categories from database
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                            // Execute the query
                            $statement = mysqli_query($conn, $sql);

                            // Count the rows
                            $count = mysqli_num_rows($statement);

                            // Check whether the rows are available or not
                            if($count > 0 ){

                                // Categories is available
                                while($row = mysqli_fetch_assoc($statement)) {
                                    
                                    // Get the details of category
                                    $id = $row['id'];
                                    $title = $row['title'];

                                    echo "<option value='$id'>$title</option>";

                                }

                            } else {

                                // Categories is not available
                                echo "<option value='0'> No Category Found</option>";
                            }
                            // 2. Display on Dropdown
                        ?>
    
                               
                        </select>
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
        
        <?php

            // Check whether the sumbit button is clicked or not
            if(isset($_POST['submit'])) {
                
                // Button Clicked
                // echo "Clicked";

                // Get all the food detail from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price= $_POST['price'];
                $category = $_POST['category'];
                
                // For radio type, we need to check whether button is clicked or not
                // For Featured
                if(isset($_POST['featured'])) {

                    // Get the value from the form
                    $featured = $_POST['featured'];
                } else {
                    // Set the default value
                    $featured = "No";
                }

                // For Active 
                if(isset($_POST['active'])) {

                    // Get the value from the form
                    $active = $_POST['active'];

                } else {

                    // Set default value
                    $active = "No";
                }

                // Check whether the image is selected or not and set the value for image accordingly
                // print_r($_FILES['image']);

                // 2. Upload the image if selected

                if(isset($_FILES['image']['name'])) {

                    // Get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    // Check whether the image is selected or not and upload image only if selected
                    if($image_name != "") {

                        // Image is selected

                        // A. Rename the image
                            // Get the extension of selected image
                            $exe = end(explode('.', $image_name));

                            // Create new name form image
                            $image_name = "Food-Name-".rand(000, 999).".".$exe;

                        // B. Upload the image

                            // Get the source and Destination path

                            // Get the source file path
                            $src = $_FILES['image'] ['tmp_name'];

                            // Get the destination path for the image to be uploaded
                            $des = "../images/StorageDB/Food/".$image_name;

                            // Finally upload the food image
                            $upload = move_uploaded_file($src, $des);

                            // Check wether image uploaded or not
                            if($upload == FALSE) {

                                // Failed to upload image
                                // REdirect to add food page with session message
                                $_SESSION['upload'] = "<div class='error'> Failed to Upload Image!</div>";
                                header('location:'.$siteURL.'admin/add-food.php');
                                // Stop the process
                                die();
                            }

                    }


                } else {

                    $image_name = "";  // Setting default value as blank
                }

                // 3. Insert Into the Database

                    // Create SQL Query to save in the database
                    $sql2 = "INSERT INTO tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = $category,
                        featured = '$featured',
                        active = '$active'
                    ";

                    // Execute the query
                    $statement2 = mysqli_query($conn, $sql2);

                    // Check whether data inserted or not
                    if($statement2 == TRUE) {

                        // Data is Inserted
                        $_SESSION['add'] = "<div class='success'> Food Added Successfully!</div>";
                        header('location:'.$siteURL.'admin/manage-food.php');
                    } else {

                        // Data is not Inserted
                        $_SESSION['add'] = "<div class='error'> Failed to Add Food!</div>";
                        header('location:'.$siteURL.'admin/manage-food.php');

                    }

            }
        ?>
    </div>
</div>

<?php include("partials/footer.php"); ?>