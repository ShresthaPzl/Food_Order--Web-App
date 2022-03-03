<?php include("partials-front/menu.php"); ?>

<?php

// Check whethe id is passed or not
if (isset($_GET['category_id'])) {

    // Get the id
    $category_id = $_GET['category_id'];

    // Get the category title based on category ID
    $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

    // Execute the query
    $statement = mysqli_query($conn, $sql);

    // Get the value from database

    $row = mysqli_fetch_assoc($statement);

    // Get the title 
    $category_title = $row['title'];
} else {

    // Category not passed
    // Redirect to home page
    header('location:' . $siteURL);
}
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <h2>Foods on <a href="#" class="text-white">"<?= $category_title; ?>"</a></h2>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>
        <?php

        // Create SQL Query to get food based on selected category
        $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

        // Execute the query
        $statement2 = mysqli_query($conn, $sql2);

        //count the rows
        $count = mysqli_num_rows($statement2);

        // Check whether the data is available or not
        if ($count > 0) {

            // Food are available
            while ($row2 = mysqli_fetch_assoc($statement2)) {

                // Get all the values and data
                $id = $row2['id'];
                $title = $row2['title'];
                $price = $row2['price'];
                $description = $row2['description'];
                $image_name = $row2['image_name'];

        ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php
                        // Check whether image is available or not
                        if ($image_name == "") {

                            // Image not available 
                            echo "<div class='error'> Image Not Available !</div>";
                        } else {
                            // Image available  
                        ?>

                            <img src="<?= $siteURL; ?>images/StorageDB/Food/<?= $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                        <?php

                        }
                        ?>
                    </div>

                    <div class="food-menu-desc">
                        <h4><?= $title; ?></h4>
                        <p class="food-price">$<?= $price; ?></p>
                        <p class="food-detail">
                            <?= $description; ?>
                        </p>
                        <br>

                        <a href="<?=$siteURL; ?>order.php?food_id=<?=$id; ?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>
                    
            <?php

            }
        } else {

            // Food are not available

            echo "<div class='error'> Food Not Found!</div>";
        }
            ?>
                


                <div class="clearfix"></div>




</section>
<!-- fOOD Menu Section Ends Here -->

<?php include("partials-front/footer.php"); ?>