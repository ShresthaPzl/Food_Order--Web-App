<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        
        <?php
        // Checking and Displaying upload Session
            if(isset($_SESSION['upload'])){
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

                            // Count Rows to check whether we have categories or not
                            $count = mysqli_num_rows($statement);

                            // If count is greater than zero, we have categories else we don't have categories
                            if($count > 0){
                                // We have categories
                                while($row = mysqli_fetch_assoc($statement)){
                                    // Get the details of category
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>
                                    // Display on Dropdown
                                    <option value="<?=$id; ?>"><?=$title; ?></option>

                                    <?php

                                }

                            } else {
                                // We don't have category
                                ?>
                                <option value="0">No Category Found</option>
                                <?php
                            }

                            


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
        if(isset($_POST['submit'])){
            //echo "Clicked";
            // Add the food in Database

            // 1. Get the data from form
            
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            // Check whether radio button for featured and active are checked or not
            if(isset($_POST['featured'])){
                $featured = $_POST['featured'];
            } else {
                $featured = "No"; // Setting the default value
            }

            if(isset($_POST['active'])){
                $active = $_POST['active'];
            } else {
                $active = "No"; // Setting the default value
            }

            // 2. Upload the image if selected

                // Check whether select image is clicked or not and upload the image only if the image is selected
                if(isset($_FILES['image']['name'])){

                    // Get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    // Check whether the image is selected or not and upload image only if selected
                    if($image_name != ""){

                        // Image is selected
                        // A. Rename the image
                            // Get the extension of selected image (jpg, png, gif, etc)
                            $exe = end(explode('.', $image_name));

                            // Create New Image  name for Image
                            $image_name = "Food-Name-".rand(0000, 9999).".".$exe;

                        // B. Upload the image
                            // Get the src path and Destination path

                            // Sorce path is the current location of the image
                            $src = $_FILES['image']['tmp_name'];

                            // Destination Path for the image to be uploaded
                            $des = "../images/StorageDB/Food/".$image_name;

                            // Finally upload the food image

                            $upload = move_uploaded_file($src, $des);

                            // Check whether the image uploaded or not 

                            if($upload == FALSE){
                                // Image is not uploaded
                                // Redirect to add-food page with error message
                                $_SESSION['upload'] = "<div class='error'> Failed to Uplaod Image! </div>";
                                header('location:'.$siteURL.'admin/add-food.php');
                                // Stop the process
                                die();
                            }

                    } else {

                    }

                } else {

                    // Setting default value as blank
                    $image_name = ""; 
                }

            // 3. Insert into database
            
                // Create a SQL Query to insert into database
                $sql2 = "INSERT INTO tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active  = '$active'
                ";

                // Execute the query
                $statement = mysqli_query($conn, $sql2);

                // Check whether data inserted or not
                // 4. Redirect with message to manage food page
                if($statement == TRUE){

                    // Data inserted successfully
                    $_SESSION['add'] = "<div class='success'> Food Added Successfully! </div>";
                    header('location:'.$siteURL.'admin/manage-food.php');

                } else {
                    // Failed to insert data
                    // Redirect with error message
                    $_SESSION['add'] = "<div class='error'> Failed To Add Food! </div>";
                    header('location:'.$siteURL.'admin/manage-food.php');
                }

            


        }

        ?>
    </div>
</div>

<?php include("partials/footer.php"); ?>