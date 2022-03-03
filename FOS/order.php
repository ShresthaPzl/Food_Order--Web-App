<?php include("partials-front/menu.php"); ?>

<?php
    
    // Check whether food id is set or not
    if(isset($_GET['food_id'])) {

        // Get the food id and details of the selected food
        $food_id = $_GET['food_id'];

        // Get the details of the selected food
        $sql = "SELECT * FROM tbl_food WHERE id=$food_id";

        // Execute the query 
        $statement = mysqli_query($conn, $sql);

        // Count the rows
        $count = mysqli_num_rows($statement);

        // Check whether the data is available or not
        if($count == 1) {

            // Data is available
            // Get the data from database
            $row = mysqli_fetch_assoc($statement);

            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];

        } else {

            // Data is unavailable
            // Redirect to home page
            header('location:'.$siteURL);
        }

    } else {

        // Redirect to homepage
        header('location:'.$siteURL);
    }
?>
    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" class="order" method="post">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">

                        <?php
                            // Check whether the image is available or not
                            if($image_name == ""){

                                // Image not available
                                echo "<div class='error'> Image not Available</div>";
                            } else {

                                // Image is available
                                ?>
                                <img src="<?=$siteURL;?>images/StorageDB/Food/<?=$image_name;?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                <?php
                            }
                        ?>
                       
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?=$title; ?></h3>
                        <input type="hidden" name="food" value="<?=$title; ?>">

                        <p class="food-price">$<?=$price; ?></p>
                        <input type="hidden" name="price" value="<?=$price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
                
                // Check whether the submit button is clicked or not 

                if(isset($_POST['submit'])) {

                    // Get all the details from form and save in the database
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty;

                    $order_date = date("Y-m-d h:i:sa");  // order date

                    $status = "Ordered";  // ordered, on deliver, deliverd, cancelled

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address =  $_POST['address'];


                    // Sql query to save the order in database
                    $sql2 = "INSERT INTO tbl_order SET
                        food = '$food',
                        price = $price,
                        qty = $qty,
                        total = $total,
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                    ";

                    // Execute the query
                    $statement2 = mysqli_query($conn, $sql2);

                    // check whether query executed successfully or not

                    if($statement2 == TRUE) {

                        // Query Executed and order saved
                        $_SESSION['order'] = "<div class='success text-center'> Food Ordered Successfully!</div>";
                        header('location:'.$siteURL);
                    } else {

                        // Failed to saved order
                        $_SESSION['order'] = "<div class='error text-center'> Failed to Order Food!</div>";
                        header('location:'.$siteURL);
                    }


                     
                }
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php include("partials-front/footer.php"); ?>