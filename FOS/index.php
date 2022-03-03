<?php include("partials-front/menu.php"); ?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <form action="<?=$siteURL;?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->
<br><br>
<?php
    // Checking and Displaying order session
    if(isset($_SESSION['order'])) {
        echo $_SESSION['order'];
        unset($_SESSION['order']);
    }
?>

<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        // Create SQL Query to Display Categories from Database
        $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";

        // Execute the query
        $statement = mysqli_query($conn, $sql);

        // Count rows to check whether the category is available or not
        $count = mysqli_num_rows($statement);

        if ($count > 0) {

            // Category is available
            while ($row = mysqli_fetch_assoc($statement)) {

                // Get the values like id, title, image_name
                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];
        ?>
                <a href="<?=$siteURL; ?>category-foods.php?category_id=<?=$id;?>">
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

            // Category is not available
            echo "<div class='error'> Category is Not Added. </div>";
        }
        ?>


        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        // Getting foods from database that are active and featured
        $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";

        // Execute the query
        $statement2 = mysqli_query($conn, $sql2);

        // Count rows
        $count2 = mysqli_num_rows($statement2);

        // Check wether food is available or not
        if ($count2 > 0) {

            // Food is available
            while ($rows = mysqli_fetch_assoc($statement2)) {
                $id = $rows['id'];
                $title = $rows['title'];
                $description = $rows['description'];
                $price = $rows['price'];
                $image_name = $rows['image_name'];
        ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">

                        <?php
                            // Check whether image available or not

                            if($image_name == "") {

                                // Image not available
                                echo "<div class='error'> Image Not Available!</div>";
                            } else {

                                // Image Available
                                ?>
                                    <img src="<?=$siteURL;?>images/StorageDB/Food/<?=$image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                <?php
                            }
                        ?>
                        
                    </div>

                    <div class="food-menu-desc">
                        <h4><?=$title; ?></h4>
                        <p class="food-price">$<?=$price; ?></p>
                        <p class="food-detail">
                           <?=$description; ?>
                        </p>
                        <br>

                        <a href="<?=$siteURL; ?>order.php?food_id=<?=$id; ?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>

        <?php


            }
        } else {

            // Food is not available
            echo "<div class='error'> Food Not Available!</div>";
        }
        ?>


        <div class="clearfix"></div>



    </div>

    <p class="text-center">
        <a href="#">See All Foods</a>
    </p>
</section>
<!-- fOOD Menu Section Ends Here -->



<?php include("partials-front/footer.php"); ?>