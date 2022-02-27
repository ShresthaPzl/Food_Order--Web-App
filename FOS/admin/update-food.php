<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>

        <br><br>
        <?php
            // Check whether id is set or not
            if(isset($_GET['id'])) {

                // Get all the details
                $id = $_GET['id'];

                    // SQL Query to get the selected food
                    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

                    // Execute the query
                    $statement2 = mysqli_query($conn, $sql2);

                    // Get the values based on query executed
                    $row2 = mysqli_fetch_assoc($statement2);

                    // Get the individual values of selected food
                    $title = $row2['title'];
                    $description = $row2['description'];
                    $price = $row2['price'];
                    $current_image = $row2['image_name'];
                    $current_category = $row2['category_id'];
                    $featured = $row2['featured'];
                    $active = $row2['active'];
            } else {

                // Redirect to manage food
                header('location:'.$siteURL.'admin/manage-food.php');
            }

        ?>

        <form action="" method="post" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td> Title: </td>
                    <td>
                        <input type="text" name="title" value="<?= $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td> Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?=$description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?=$price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>

                        <?php
                            if($current_image == "") {

                                // Image not Available
                                echo "<div class='error'> Image not Available</div>";

                            } else {

                                // Image Available
                                ?>
                                <img src="<?=$siteURL;?>images/StorageDB/Food/<?=$current_image; ?>" alt="" width="150px">
                                <?php
                            }
                        ?>

                    </td>
                </tr>

                <tr>
                    <td>Select New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">

                            <?php
                                // Query to get active categories
                                $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'";

                                // Execute the query 
                                $statement = mysqli_query($conn, $sql);

                                // Count the rows
                                $count = mysqli_num_rows($statement);

                                // Check whether category available or not
                                if($count > 0) {

                                    // Category Available
                                    while($row = mysqli_fetch_assoc($statement)) {
                                        $category_title = $row['title'];
                                        $category_id =  $row['id'];

                                        echo "<option value='$category_id'>$category_title</option>";
                                    }

                                } else {

                                    // Category Not Available
                                    echo "<option value='0'> Category Not Available!</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured == "Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured == "No") {echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active == "Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active == "No") {echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?=$id; ?>">
                        <input type="hidden" name="current_image" value="<?=$current_image; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php
            // Check whether button is clicked or not

            if(isset($_POST['submit'])) {

                //echo "Button Clicked";

                // 1. Get all the details from the form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // 2. Upload the image if selected
                    // Check whether upload button is clicked or not
                    if($_FILES['image']['name']) {
                        
                        // Upload Button Clicked
                        $image_name = $_FILES['image'] ['name']; // New image name

                        // check whether the file is available or not
                        if($image_name != "") {
                            
                            // Image is available
                            // A. Uploading New Image
                            // Rename the image
                            $exe = end(explode(".", $image_name));  // Gets the extension of the image

                            $image_name = "Food-Name".rand(000, 999).".".$exe;  // This will be renamed image

                            // Get the source path and destination path
                            $src_path = $_FILES['image']['tmp_name'];  // Source Path of image

                            $des_path = "../images/StorageDB/Food/".$image_name;  // Destination path of image

                            $upload = move_uploaded_file($src_path, $des_path);  // Uploads the file

                            // Check whether the image is uploaded or not
                            if($upload == FALSE) {

                                // Failed to Upload
                                $_SESSION['upload'] = "<div class='error'> Failed to Upload Image!</div>"; 
                                header('location:'.$siteURL.'admin/manage-food.php');

                                // stop the process
                                die();
                            } 

                            // 3. Remove the current image if new image is uploaded

                            if($current_image != ""){

                                // Current image is available
                                // Remove the image
                                $remove_path = "../images/StorageDB/Food/".$current_image;

                                $remove = unlink($remove_path);  // removes the image

                                // Check whether image is removed or not
                                
                                if($remove == FALSE) {

                                    // Failed to remove current image
                                    $_SESSION['remove-failed']  = "<div class='error'>Failed to Remove Current Image!</div>";
                                    // Redirect to manage food
                                    header('location:'.$siteURL.'admin/manage-food.php');
                                    // Stops the process
                                    die();

                                }
                            }
                        }
                    } else {

                        $image_name = $current_image;
                    }

                // 4. Update the food in database
                $sql3 = "UPDATE tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id= $id
                ";

                // Execute the query
                $statement3 = mysqli_query($conn, $sql3);

                // Check whether the query is executed or not
                if($statement3 == TRUE) {
                    // 5. Redirect to manage food with sesion messag
                    // Food Update
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully!</div>";
                    header('location:'.$siteURL.'admin/manage-food.php');

                } else {

                    // Failed to update food
                    $_SESSION['update'] = "<div class='error'>Failed to Update Food!</div>";
                    header('location:'.$siteURL.'admin/manage-food.php');
                }

            }


        ?>
    </div>
</div>

<?php include("partials/footer.php"); ?>