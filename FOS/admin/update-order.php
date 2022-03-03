<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>
        
        <?php

             // CHeck whether id is set or not
            if(isset($_GET['id'])) {

                
                // Get the order details
                $id = $_GET['id'];

                // Get all other details based on the id

                // sql query to get the order details from database
                $sql = "SELECT * FROM tbl_order WHERE id=$id";

                // Execute the query 
                $statement = mysqli_query($conn, $sql);

                // Count the rows
                $count = mysqli_num_rows($statement);

                // Checke whether the rows are available or not
                if($count == 1) {

                    // Order is available
                    $row = mysqli_fetch_assoc($statement);

                    // get the details 
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];



                } else {

                    // Details not available
                    // Redirect To manage order
                    header('location:'.$siteURL.'admin/manage-order.php');

                }

            } else {

                // Redirect to manage order page
                header('location:'.$siteURL.'admin/manage-order.php');
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Food Name: </td>
                    <td><b><?=$food;?></b></td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td><b>$<?=$price;?></b></td>
                </tr>

                <tr>
                    <td>Quantity: </td>
                    <td>
                        <input type="number" name="qty" value="<?=$qty;?>">
                    </td>
                </tr>

                <tr>
                    <td>Status: </td>
                    <td>
                        <select name="status">
                            <option <?php if($status == "ordered") {echo "selected";} ?> value="ordered"> Ordered </option>
                            <option <?php if($status == "on delivery") {echo "selected";} ?> value="on delivery"> On delivery </option>
                            <option <?php if($status == "delivered") {echo "selected";} ?> value="delivered"> Delivered </option>
                            <option <?php if($status == "cancelled") {echo "selected";} ?> value="cancelled"> Cancelled </option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer Name:</td>
                    <td>
                        <input type="text" name="customer_name" value="<?=$customer_name;?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Contact:</td>
                    <td>
                        <input type="text" name="customer_contact" value="<?=$customer_contact;?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer E-Mail:</td>
                    <td>
                        <input type="text" name="customer_email" value="<?=$customer_email;?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Address:</td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="5"><?=$customer_address;?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name='id' value="<?=$id;?>">
                        <input type="hidden" name='price' value="<?=$price;?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>


            </table>
        </form>

        <?php

            // Check wether update button is clicked or not
            if(isset($_POST['submit'])) {

                // Get all the values from form
                $id = $_POST['id'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];

                $total = $qty * $price;

                $status = $_POST['status'];

                $customer_name = $_POST['customer_name'];
                $customer_contact = $_POST['customer_contact'];
                $customer_email = $_POST['customer_email'];
                $customer_address = $_POST['customer_address'];

                // Update the values
                $sql2 = "UPDATE tbl_order SET 
                    qty = $qty,
                    total = $total,
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'
                    WHERE id=$id
                ";

                // Execute the qeury
                $statement2 = mysqli_query($conn, $sql2);

                // Check whether query executed or not
                if($statement == TRUE) {
                    
                    // updated
                    $_SESSION['update'] = "<div class='success'>Order Updated Successfully!</div>";
                    header('location:'.$siteURL.'admin/manage-order.php');

                } else {


                    // Failed to update
                    $_SESSION['update'] = "<div class='error'>Failed to update Order</div>";
                    header('location:'.$siteURL.'admin/manage-order.php');

                }
            }
        
        ?>
    </div>
</div>

<?php include("partials/footer.php"); ?>