<?php
session_start();

if(isset($_SESSION["user_id"])) {
    header("location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | PG Life</title>
    <?php include "includes/head_links.php"; ?>
    <link href="css/home.css" rel="stylesheet" />
</head>
<body>


<?php include "includes/header.php"; ?>

<div class="banner-container">
    <h2 class="white pb-3">Happiness per Square Foot</h2>
    <form id="search-form" action="property_list.php" method="GET">
    <div class="input-group city-search">
        <input type="text" class="form-control input-city" name="city" id="city" placeholder="Enter your city to search for PGs"/>
        <div class="input-group-append">
            <button type="submit" class="btn btn-secondary">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</form>
</div>


<div class="page-container">
    <h1 class="city-heading">Major Cities</h1>
    <div class="row">

        <div class="city-card-container col-md">
            <a href="property_list.php?city=Delhi">
                <div class="city-card rounded-circle">
                    <img src="img/images/delhi.png" class="city-img" alt="Delhi"/>
                </div>
            </a>
        </div>

        <div class="city-card-container col-md">
            <a href="property_list.php?city=Mumbai">
                <div class="city-card">
                    <img src="img/images/mumbai.png" class="city-img" alt="Mumbai"/>
                </div>
            </a>
        </div>

        <div class="city-card-container col-md">
            <a href="property_list.php?city=Bangaluru">
                <div class="city-card rounded-circle">
                    <img src="img/images/bengalore.png" class="city-img" alt="Bangalore"/>
                </div>
            </a>
        </div>


        <div class="city-card-container col-md">
            <a href="property_list.php?city=Hyderabad">
                <div class="city-card rounded-circle">
                    <img src="img/images/hyderabad.png" class="city-img" alt="Hyderabad"/>
                </div>
            </a>
        </div>

    </div>
</div>

<?php include "includes/footer.php"; ?>
<?php include "includes/login_modal.php"; ?>
<?php include "includes/signup_modal.php"; ?>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>