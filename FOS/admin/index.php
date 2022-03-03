<?php include("partials/menu.php"); ?>


<!-- Main Content Section Starts -->

<div class="main-content">
    <div class="wrapper">
        <h1>DASHBOARD</h1>
        <br><br>

        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        ?>

        <br><br>



        <!--Box 1 -->
        <div class="col-4 text-center">

        <?php
            // Sql query to get total category
            $sql = "SELECT * FROM tbl_category";

            // Execute the query
            $statement = mysqli_query($conn, $sql);

            // Count the rows
            $count = mysqli_num_rows($statement);


        ?>
            <h1 style="color: red;"><?=$count; ?></h1>
            <br>
            category
        </div>

        <!--Box 2 -->
        <div class="col-4 text-center">

        <?php
            // Sql query to get total category
            $sql2 = "SELECT * FROM tbl_food";

            // Execute the query
            $statement2 = mysqli_query($conn, $sql2);

            // Count the rows
            $count2 = mysqli_num_rows($statement2);


        ?>
            <h1 style="color: red;"><?=$count2;?></h1>
            <br>
            Foods
        </div>

        <!--Box 3 -->
        <div class="col-4 text-center">

        <?php
            // Sql query to get total category
            $sql3 = "SELECT * FROM tbl_order";

            // Execute the query
            $statement3 = mysqli_query($conn, $sql3);

            // Count the rows
            $count3 = mysqli_num_rows($statement3);


        ?>
            <h1 style="color: red;"><?=$count3;?></h1>
            <br>
            Total Orders
        </div>

        <!--Box 4 -->
        <div class="col-4 text-center">

            <?php
                // Create SQL Query to get total revenu generated
                // Aggregate function in sql 
                $sql4 = "SELECT sum(total) AS Total FROM tbl_order WHERE status='delivered'";

                // Execute the query
                $statement4 = mysqli_query($conn, $sql4);

                // Get the value
                $row4 = mysqli_fetch_assoc($statement4);

                // Get the total revenue
                $total_revenue = $row4['Total'];

            ?>
            <h1 style="color: red;">$<?=$total_revenue;?></h1>
            <br>
            Revenue Generated
        </div>

        <div class="clearfix"></div>

    </div>
</div>

<!-- Main Content Section Ends -->



<?php include("partials/footer.php"); ?>