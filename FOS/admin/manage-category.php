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
                            <td> <?=$sn++; ?> </td>
                            <td> <?=$title; ?> </td>
                            
                            <td> 
                                <?php
                                    // Check whether image is available or not
                                    if($image_name!= "")
                                    {
                                        // Display the image
                                        ?>
                                            <img src="<?=$siteURL; ?>images/Database Storage/Category/<?=$image_name; ?>" width="100px">
                                        <?php

                                    }
                                    else
                                    {
                                        // Display the message
                                        echo "<div class='error'> Image Not Added. </div>";
                                    }
                                ?>
                            </td>

                            <td> <?=$featured; ?> </td>
                            <td> <?=$active; ?> </td>
                            <td>
                                <a href="#" class="btn-secondary">Update</a>
                                <a href="#" class="btn-danger">Delete</a>
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