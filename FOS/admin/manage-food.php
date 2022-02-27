<?php include("partials/menu.php"); ?>

<body>
    <div class="main-content">
        <div class="wrapper">

            <h1>Manage Food</h1>
            <br><br>

            <?php
            // Checking and Displaying the add session
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            // Checking and Displaying the delete Session
            if(isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            // Checking and Displaying the upload Session
            if(isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            // Checing and Displaying the unauthorized Session
            if(isset($_SESSION['unauthorized'])) {
                echo $_SESSION['unauthorized'];
                unset($_SESSION['unauthorized']);
            }
            
            // Checing and Displaying the update Session
            if(isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            ?>

            <br><br>
            <!-- Button to add Admin -->
            <a href="<?= $siteURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>

            <br><br>

            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th> Title </th>
                    <th> Image </th>
                    <th> Price </th>
                    <th> Featured </th>
                    <th> Active </th>
                    <th> Actions </th>
                </tr>
                <?php
                // Create a SQL Query to get all the Food
                $sql = "SELECT * FROM tbl_food";

                // Execute the query
                $statement = mysqli_query($conn, $sql);

                // Count the rows to check whether the food is available or not
                $cout = mysqli_num_rows($statement);

                // Create serial number variable and set default values as 1
                $sn = 1;
                if ($cout > 0) {

                    // we have food in database

                    // Getj the food from database and Display
                    while ($row = mysqli_fetch_assoc($statement)) {
                        // Get the values from individual colums
                        $sn++;
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                ?>
                        <tr>
                            <td><?= $sn++; ?></td>
                            <td><?= $title; ?> </td>

                            <td>
                                <?php
                                    // Check whether we have image or not
                                    if($image_name == "") {

                                        // We do not have image, Display Error Message
                                        echo "<div class='error'> Image Not Added! </div>";
                                    } else {

                                        // We have image
                                        ?>
                                        <img src="<?=$siteURL; ?>images/StorageDB/Food/<?=$image_name; ?>" width="150px">
                                        <?php
                                    }
                                ?>
                            </td>

                            <td>$<?= $price; ?> </td>
                            <td><?= $featured; ?> </td>
                            <td><?= $active; ?> </td>
                            <td>
                                <a href="<?= $siteURL; ?>admin/update-food.php?id=<?=$id; ?>" class="btn-secondary">Update</a>
                                <a href="<?=$siteURL;?>admin/delete-food.php?id=<?=$id; ?>&image_name=<?=$image_name; ?>" class="btn-danger">Delete</a>
                            </td>
                        </tr>


                <?php

                    }
                } else {

                    // Food not added in database
                    echo "<tr> <td colspan='7' class='error'> Food Not Added Yet! <td> </tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>




<?php include("partials/footer.php"); ?>