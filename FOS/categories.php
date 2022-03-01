<?php include("partials-front/menu.php"); ?>



<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        // Display all the categories that are active
        // SQL Query
        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

        // Execute the query
        $statement = mysqli_query($conn, $sql);

        // Count Rows
        $cout = mysqli_num_rows($statement);

        // Check whether categories available or not
        if ($cout > 0) {

            // Categories is available
            while ($row = mysqli_fetch_assoc($statement)) {
                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];
        ?>

                <a href="<?=$siteURL;?>category-foods.php?category_id=<?=$id;?>">
                    <div class="box-3 float-container">

                        <?php
                        // Check whether Image is available or not
                        if ($image_name == "") {

                            // Display the message
                            echo "<div class='error'>Image Not Available</div>";
                        } else {

                            // Image Available
                        ?>
                            <img src="<?= $siteURL; ?>images/StorageDB/Category/<?= $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                        <?php
                        }
                        ?>



                        <h3 class="float-text text-white"><?= $title; ?></h3>
                    </div>
                </a>

        <?php

            }
        } else {

            // Categories not Available
            echo "<div class='error'> Category Not Found!</div>";
        }
        ?>


        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->


<?php include("partials-front/footer.php"); ?>