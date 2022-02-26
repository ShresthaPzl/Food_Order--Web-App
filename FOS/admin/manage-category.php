<?php include("partials/menu.php"); ?>

<body>
    <div class="main-content">
        <div class="wrapper">

            <h1>Manage Category</h1>
            <br><br>
            <!-- Button to add Admin -->
            <a href="<?= $siteURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>

            <br><br>

            <?php
            // Checking and Displaying the add session
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            // Checing and Displaying the remove session
            if (isset($_SESSION['remove'])) {
                echo $_SESSION['remove'];
                unset($_SESSION['remove']);
            }

            // Checing and Displaying the delete session
            if (isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            // Cheking and Displaying the no-category-found session
            if (isset($_SESSION['no-category-found'])) {
                echo $_SESSION['no-category-found'];
                unset($_SESSION['no-category-found']);
            }

            // Checking and Displaying the update Session
            if (isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            // Checking and Displaying the update session
            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            // Checking and Displaying the failed-remove session
            if (isset($_SESSION['failed-remove'])) {
                echo $_SESSION['failed-remove'];
                unset($_SESSION['failed-remove']);
            }

            ?>

            <br>

            <table class="tbl-full">
                <tr>
                    <th> S.N </th>
                    <th> Title </th>
                    <th> Image Name </th>
                    <th> Featured </th>
                    <th> Active </th>
                    <th> Actions </th>
                </tr>

                <?php
                // Query to get all categories from database
                $sql = "SELECT * FROM tbl_category";

                // Execute the query
                $statement = mysqli_query($conn, $sql);

                // Count rows
                $count = mysqli_num_rows($statement);
                $sn = 1;

                // Check whether we have data in database or not
                if ($count > 0) {
                    // We have data in database
                    // Get the data and display
                    while ($row = mysqli_fetch_assoc($statement)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                        
                ?>

                        <tr>
                            <td> <?= $sn++; ?> </td>
                            <td> <?= $title; ?> </td>

                            <td>
                                <?php
                                // Check whether image is available or not
                                if ($image_name != "") {
                                    // Display the image
                                ?>
                                    <img src="<?= $siteURL; ?>images/StorageDB/Category/<?= $image_name; ?>" width="100px">
                                <?php

                                } else {
                                    // Display the message
                                    echo "<div class='error'> Image Not Added. </div>";
                                }
                                ?>
                            </td>

                            <td> <?= $featured; ?> </td>
                            <td> <?= $active; ?> </td>
                            <td>
                                <a href="<?= $siteURL; ?>admin/update-category.php?id= <?= $id; ?>" class="btn-secondary">Update</a>
                                <a href="<?= $siteURL; ?>admin/delete-category.php?id= <?= $id; ?>&image_name=<?= $image_name; ?>" class="btn-danger">Delete</a>
                            </td>
                        </tr>

                    <?php
                    }
                } else {
                    // We'll display the message inside table
                    ?>

                    <tr>
                        <td colspan="6">
                            <div class="err">
                                No Category Added.
                            </div>
                        </td>
                    </tr>

                <?php
                }
                ?>

            </table>
        </div>
    </div>
</body>




<?php include("partials/footer.php"); ?>