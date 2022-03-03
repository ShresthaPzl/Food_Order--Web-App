<?php include("partials/menu.php"); ?>

<body>
    <div class="main-content">
        <div class="wrapper">

           <h1>Manage Order</h1>

           <br><br>
           <?php
                // checking and displaying update session
                if(isset($_SESSION['update'])) {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
           ?>

            <br><br>
           <table class="tbl-full">
               <tr>
                   <th> S.N </th>
                   <th> Food </th>
                   <th> Price </th>
                   <th> Quantity </th>
                   <th> Total </th>
                   <th> Order Date </th>
                   <th> Status </th>
                   <th>Customer Name </th>
                   <th> Contact </th>
                   <th> Email </th>
                   <th> Address </th>
                   <th> Actions </th>
               </tr>

               <?php
                    // Get all the orders from database
                    $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; // Display the lastest order at First

                    // Execute the query
                    $statement = mysqli_query($conn, $sql);

                    // Count the rows
                    $count = mysqli_num_rows($statement);
                    $sn = 1;

                    // Check whether the rows are available or not
                    if($count > 0 ) {

                        // Order Available
                        while($row = mysqli_fetch_assoc($statement)) {

                            // Get all the data
                            $id = $row['id'];
                            $food = $row['food'];
                            $price = $row['price'];
                            $qty = $row['qty'];
                            $total = $row['total'];
                            $order_date = $row['order_date'];
                            $status = $row['status'];
                            $customer_name = $row['customer_name'];
                            $customer_contact = $row['customer_contact'];
                            $customer_email = $row['customer_email'];
                            $customer_address = $row['customer_address'];

                        ?>
                            
                            <tr>
                                <td><?=$sn++; ?></td>
                                <td><?=$food; ?></td>
                                <td><?=$price ;?></td>
                                <td><?=$qty ;?></td>
                                <td><?=$total ;?></td>
                                <td><?=$order_date ;?></td>

                                <td>
                                    <?php
                                    // Ordered, On Delivery, Delivered, Cancelled
                                        if($status == "ordered") {
                                            echo "<label>$status</label>";
                                        } else if($status == "on delivery") {
                                            echo "<label style='color: orange;'>$status</label>";
                                        } else if($status == "delivered") {
                                            echo "<label style='color: green;'>$status</label>";
                                        } else if($status == "cancelled") {
                                            echo "<label style='color: red;'>$status</label>";
                                        }
                                    ?>
                                </td>
                                
                                <td><?=$customer_name ;?></td>
                                <td><?=$customer_contact ;?></td>
                                <td><?=$customer_email ;?></td>
                                <td><?=$customer_address ;?></td>

                                <td>
                                <a href="<?=$siteURL;?>admin/update-order.php?id=<?=$id; ?>" class="btn-secondary">Update</a>
                                </td>
                            </tr>



                        <?php
                        }
                    } else {

                        // Order Not Available
                        echo "<tr><td colspan='12'><div class='error'> Orders Not Available!</div></td></tr>";
                    }
               ?>

           </table>
        </div>
    </div>
</body>




<?php include("partials/footer.php"); ?>