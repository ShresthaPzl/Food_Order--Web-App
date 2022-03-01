<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php
            // Check whether the id is set or not
            if(isset($_GET['id'])){
                 // Get the id and all other detail
                 $id = $_GET['id'];

                 // Create SQL Query to get all other detail
                 $sql = "SELECT * FROM tbl_category WHERE id=$id";

                 // Execute the query
                $statement = mysqli_query($conn, $sql);

                // Count the row to check the whether the id is valid or not
                $count = mysqli_num_rows($statement);

                if($count == 1){
                    // Get all the data

                    $row = mysqli_fetch_assoc($statement);

                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];



                } else {
                    // Redirect to manage category with session message
                    $_SESSION['no-category-found'] = "<div class='error'>  Category Not Found! </div>";
                    header('location:'.$siteURL.'admin/manage-category.php');
                }

            } else {

                // Redirect to manage category
                header('location:'.$siteURL.'admin/manage-category.php');
            }
        ?>
    <form action="" enctype="multipart/form-data" method="POST">
        <table class="tbl-30">
            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" value="<?= $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Current Image</td>
                <td>
                    <?php
                        if($current_image != ""){
                            // Display the image

                            ?>
                        <img src="<?=$siteURL;?>images/StorageDB/Category/<?=$current_image; ?>" width="150px">
                            <?php
                        } else {
                            // Display Message
                            echo "<div class='error'>Image Not Added!</div>";
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <td>New Image</td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Featured:</td>
                <td>
                    <input <?php if($featured == "Yes") { echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes

                    <input <?php if($featured == "No") { echo "checked";} ?> type="radio" name="featured" value="No"> No
                </td>
            </tr>

            <tr>
                <td>Active:</td>
                <td>
                    <input <?php if($active == "Yes") { echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                    <input <?php if($active == "No") { echo "checked";} ?> type="radio" name="active" value="No"> No
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

    if(isset($_POST['submit'])){
        // echo "Clicked";
        // 1. Get all the values from our form

        $id = $_POST['id'];
        $title = $_POST['title'];
        $current_image = $_POST['current_image'];
        $featured = $_POST['featured'];
        $active = $_POST['active'];

        // 2. Update New Image if Selected
        // Check whether the image is selected or not
        if(isset($_FILES['image']['name'])){
            // Get the image Details
            $image_name = $_FILES['image']['name'];

            // Check whether the image is available or not
            if($image_name != ""){
                // Image Available
                // A. Upload the New Image

                // Auto Rename our image
                // Get the extension of our image (jpg, png, gif, etc) e.g. "food1.jpg";
                $exe = end(explode('.', $image_name)); // explode(); - function used to split the string from given symbol
                // end(); - function take the end part of the split as we need the last part which is extension


                // Rename the Image
                $image_name = "Food_Category_".rand(000, 99).'.'.$exe; // e.g. Food_Category_093.jpg 




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
                    header('location:' . $siteURL . 'admin/manage-category.php');

                    // stop the process
                    die();
                }
                // B. Remove the Current Image if available

                if($current_image != ""){
                    $remove_path = "../images/StorageDB/Category/".$current_image;

                    $remove = unlink($remove_path);

                    // Check whether the image is removed or not
                    // and if failed to remove then display message and stop the proces

                    if ($remove == FALSE) {
                        // Failed to remove the image
                        $_SESSION['failed-remove'] = "<div class='error'> Failed To Remove Image!</div>";
                        // Redirect to manage category page
                        header('location:' . $siteURL . 'admin/manage-category.php');
                        die();
                    }

                }

               
            }else {
                $image_name = $current_image;
            }
        } else {

            $image_name = $current_image;
        }
        // 3. Update the Database
            $sql2 = "UPDATE tbl_category SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active'
                WHERE id = $id
            ";

            // Execute the query
            $statement2 = mysqli_query($conn, $sql2);

        // 4. Redirect to manage category with message
            // Check whether query executed or not
            if($statement2 == true){
                // Category Updated
                $_SESSION['update'] = "<div class='success'>Category Updated Successfully!</div>";
                header('location:'.$siteURL.'admin/manage-category.php');

            } else {
                // Failed to update category
                $_SESSION['update'] = "<div class='error'>Failed To Update Category!</div>";
                header('location:'.$siteURL.'admin/manage-category.php');
            }

    }


    ?>
    </div>
</div>

<?php include("partials/footer.php"); ?>