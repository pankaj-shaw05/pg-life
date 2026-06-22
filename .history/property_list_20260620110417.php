<?php
session_start();
require "includes/database_connect.php";

if(!isset($_GET["city"])) {
    header("location: index.php");
    exit();
}

$city = ucwords(strtolower($_GET["city"]));

$sql_city = "SELECT * FROM cities WHERE name='$city'";
$city_result = mysqli_query($con, $sql_city);
$properties_result = FALSE;

if($city_result && mysqli_num_rows($city_result) == 1) {
    $city_row = mysqli_fetch_assoc($city_result);
    $city_id = $city_row["id"];

    if(isset($_GET["filter"])) {
    if($_GET["filter"] == "rent_desc") {
        $sql_prop = "SELECT * FROM properties WHERE city_id='$city_id' ORDER BY rent DESC";
    } elseif($_GET["filter"] == "rent_asc") {
        $sql_prop = "SELECT * FROM properties WHERE city_id='$city_id' ORDER BY rent ASC";
    } elseif($_GET["filter"] == "rating_desc") {
        $sql_prop = "SELECT * FROM properties WHERE city_id='$city_id' ORDER BY rating_food+rating_clean+rating_safety DESC";
    }
} elseif(isset($_GET["gender"])) {
    $gender = $_GET["gender"];
    if($gender == "male" || $gender == "female") {
        $sql_prop = "SELECT * FROM properties WHERE city_id='$city_id' AND gender='$gender'";
    } else {
        $sql_prop = "SELECT * FROM properties WHERE city_id='$city_id'";
    }
} else {
    $sql_prop = "SELECT * FROM properties WHERE city_id='$city_id'";
}
    }
    $properties_result = mysqli_query($con, $sql_prop);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PGs in <?php echo $city; ?> | PG Life</title>
    <?php include "includes/head_links.php"; ?>
    <link href="css/property_list.css" rel="stylesheet"/>
</head>
<body>
<?php include "includes/header.php"; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb py-2">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active"><?php echo $city; ?></li>
    </ol>
</nav>

<div class="page-container">
    <input type="hidden" id="city-name" value="<?php echo $city; ?>">
<?php
if($properties_result && mysqli_num_rows($properties_result) > 0) {
?>
    <div class="filter-bar row justify-content-around">
    <div class="col-auto" data-toggle="modal" data-target="#filter-modal" style="cursor:pointer;">
    <img src="img/images/filter.png"/>
    <span>Filter</span>
</div>
    <div class="col-auto">
        <a class="filter-link" href="property_list.php?city=<?php echo $city; ?>&filter=rent_desc">
            <img src="img/images/desc.png"/>
            <span>Highest rent first</span>
        </a>
    </div>
    <div class="col-auto">
        <a class="filter-link" href="property_list.php?city=<?php echo $city; ?>&filter=rent_asc">
            <img src="img/images/asc.png"/>
            <span>Lowest rent first</span>
        </a>
    </div>
</div>

<div class="modal fade" id="filter-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Filters</h3>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
    <h5>Gender</h5>
    <hr />
    <div>
        <button class="btn btn-outline-dark gender-btn" data-value="">No Filter</button>
        <button class="btn btn-outline-dark gender-btn" data-value="male">
            <i class="fas fa-mars"></i> Male
        </button>
        <button class="btn btn-outline-dark gender-btn" data-value="female">
            <i class="fas fa-venus"></i> Female
        </button>
    </div>
    <br>
    <h5>Rent</h5>
    <hr />
    <div>
        <button class="btn btn-outline-dark rent-btn" data-value="rent_desc">Highest rent first</button>
        <button class="btn btn-outline-dark rent-btn" data-value="rent_asc">Lowest rent first</button>
    </div>
</div>
<div class="modal-footer">
    <button id="apply-filter" class="btn btn-success">Apply</button>
</div>
            
        </div>
    </div>
</div>

<?php
    while($row = mysqli_fetch_assoc($properties_result)) {
        $pg_id = $row["id"];
        $pg_name = $row["name"];
        $pg_address = $row["address"];
        $pg_rent = $row["rent"];
        $pg_gender = $row["gender"];
        $pg_rating = round(($row["rating_clean"] + $row["rating_food"] + $row["rating_safety"]) / 3, 1);

        $sql_interest = "SELECT * FROM interested_users_properties WHERE property_id=$pg_id";
        $interest_result = mysqli_query($con, $sql_interest);
        $num_interested = mysqli_num_rows($interest_result);
?>
        <div class="property-card row">
            <div class="image-container col-md-4">
                <img src="img/images/properties.jpeg" class="img-fluid">
            </div>
            <div class="content-container col-md-8">
                <div class="row no-gutters justify-content-between">
                    <div class="star-container">
                        <?php
                        $star_full = floor($pg_rating);
                        $star_empty = 5 - 1 - $star_full;
                        for($i = 1; $i <= $star_full; $i++) {
                            echo '<i class="fas fa-star"></i>';
                        }
                        if(($pg_rating - $star_full) > 0.2 && ($pg_rating - $star_full) < 0.8) {
                            echo '<i class="fas fa-star-half-alt"></i>';
                        } elseif(($pg_rating - $star_full) >= 0.8) {
                            echo '<i class="fas fa-star"></i>';
                        } else {
                            echo '<i class="far fa-star"></i>';
                        }
                        for($i = 1; $i <= $star_empty; $i++) {
                            echo '<i class="far fa-star"></i>';
                        }
                        ?>
                    </div>
                    <div class="interested-container">
                    <?php if(isset($_SESSION["user_id"])) {
                    $user_id = $_SESSION["user_id"];
                    $sql_liked = "SELECT * FROM interested_users_properties WHERE user_id=$user_id AND property_id=$pg_id";
                    $liked_result = mysqli_query($con, $sql_liked);
                    if(mysqli_num_rows($liked_result) == 1) {
                    echo '<i class="fas fa-heart is-interested-image" style="color:#EA322E;" property_id="'.$pg_id.'"></i>';
            } else {
                    echo '<i class="far fa-heart is-interested-image" style="color:#aaa;" property_id="'.$pg_id.'"></i>';
             }
         } else {
                    echo '<i class="far fa-heart is-interested-image" property_id="'.$pg_id.'" onclick="alert(\'Please login first!\')"></i>';
         } ?>
                <div class="interested-text"><?php echo $num_interested; ?> interested</div>
                </div>
                </div>
                <div class="detail-container">
                    <div class="property-name"><?php echo $pg_name; ?></div>
                    <div class="property-address"><?php echo $pg_address; ?></div>
                    <div class="property-gender">
                        <?php
                        if($pg_gender == 'male') echo '<img src="img/images/male.png">';
                        elseif($pg_gender == 'female') echo '<img src="img/images/female.png">';
                        else echo '<img src="img/images/malefemale.png">';
                        ?>
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="rent-container col-6">
                        <div class="rent">Rs <?php echo $pg_rent; ?>/-</div>
                        <div class="rent-unit">per month</div>
                    </div>
                    <div class="button-container col-6">
                        <a href="property_detail.php?property_id=<?php echo $pg_id; ?>" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
} elseif($city_result && mysqli_num_rows($city_result) == 0) {
    echo "<p>$city does not exist in our records!</p>";
} elseif($properties_result && mysqli_num_rows($properties_result) == 0) {
    echo "<p>No PGs found in $city!</p>";
}
?>
</div>

<?php include "includes/footer.php"; ?>
<?php include "includes/login_modal.php"; ?>
<?php include "includes/signup_modal.php"; ?>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/property_list.js"></script>
</body>
</html>
<?php mysqli_close($con); ?> 