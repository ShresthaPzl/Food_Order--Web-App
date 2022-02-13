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
            <h1>5</h1>
            <br>
            category
        </div>

        <!--Box 2 -->
        <div class="col-4 text-center">
            <h1>5</h1>
            <br>
            category
        </div>

        <!--Box 3 -->
        <div class="col-4 text-center">
            <h1>5</h1>
            <br>
            category
        </div>

        <!--Box 4 -->
        <div class="col-4 text-center">
            <h1>5</h1>
            <br>
            category
        </div>

        <div class="clearfix"></div>

    </div>
</div>

<!-- Main Content Section Ends -->



<?php include("partials/footer.php"); ?>