<?php
session_start();
require "includes/database_connect.php";

if( !isset($_GET["property_id"]) ) {
  header("location: index.php");
  exit();
}

if( $con ) {
  $pg_id = $_GET["property_id"];
  $sql_query1 = "SELECT * FROM properties WHERE id=$pg_id";
  $property_result = mysqli_query($con,$sql_query1);
  
  if( !$property_result ) {
    echo mysqli_error($con);
    exit();
  }
  elseif( mysqli_num_rows($property_result)==0 ) {
    header("location: index.php");
    exit();
  }
  elseif( mysqli_num_rows($property_result)==1 ) {
    $property_row = mysqli_fetch_assoc($property_result);
    $pg_city_id = $property_row["city_id"];
    $pg_name = $property_row["name"];
    $pg_address = $property_row["address"];
    $pg_description = $property_row["description"];
    $gender_allowed = $property_row["gender"];
    $pg_rent = $property_row["rent"];
    $pg_rating_clean = $property_row["rating_clean"];
    $pg_rating_food = $property_row["rating_food"];
    $pg_rating_safety = $property_row["rating_safety"];
    $pg_rating_overall = round(($property_row["rating_clean"] + $property_row["rating_food"] + $property_row["rating_safety"])/3, 1);

    $sql_query2 = "SELECT * FROM cities WHERE id=$pg_city_id";
    $city_result = mysqli_query($con,$sql_query2);
    if( !$city_result ) {
      echo mysqli_error($con);
      exit();
    }
    else {
      $city_row = mysqli_fetch_assoc($city_result);
      $city_name = $city_row["name"];
    }

    $sql_interest = "SELECT * FROM interested_users_properties WHERE property_id = $pg_id";
    $interest_result = mysqli_query($con,$sql_interest);
    if( $interest_result ) {
      $num_interested = mysqli_num_rows($interest_result);
    }
  }
}
else {
  echo "Database Connectivity Error!";
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pg_name; ?> | PG Life</title>
    <?php include "includes/head_links.php"; ?>
    <link href="css/property_details.css" rel="stylesheet"/>
</head>
<body>

<?php include "includes/header.php"; ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb py-2">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <?php if($city_result){ ?>
        <li class="breadcrumb-item">
            <a href="property_list.php?city=<?php echo $city_name; ?>"><?php echo $city_name; ?></a>
        </li>
        <li class="breadcrumb-item active"><?php echo $pg_name; ?></li>
        <?php } ?>
    </ol>
</nav>

<?php if( $property_result && mysqli_num_rows($property_result)==1 ) { ?>


<div id="property-images" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#property-images" data-slide-to="0" class="active"></li>
        <li data-target="#property-images" data-slide-to="1"></li>
        <li data-target="#property-images" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="img/images/properties.jpeg" alt="slide">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="img/images/properties2.jpeg" alt="slide">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="img/images/properties.jpeg" alt="slide">
        </div>
    </div>
    <a class="carousel-control-prev" href="#property-images" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#property-images" role="button" data-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>


<div class="property-summary page-container">
    <div class="row no-gutters justify-content-between">
        <div class="star-container" title="<?php echo $pg_rating_overall; ?>">
            <?php
            $star_full = floor($pg_rating_overall);
            $star_empty = 5-1-$star_full;
            for($i=1; $i<=$star_full; $i++) { ?><i class="fas fa-star"></i><?php }
            if(($pg_rating_overall-$star_full)>0.2 && ($pg_rating_overall-$star_full)<0.8) { ?><i class="fas fa-star-half-alt"></i><?php }
            elseif(($pg_rating_overall-$star_full)>=0.8) { ?><i class="fas fa-star"></i><?php }
            elseif(($pg_rating_overall-$star_full)<=0.2) { ?><i class="far fa-star"></i><?php }
            for($i=1; $i<=$star_empty; $i++) { ?><i class="far fa-star"></i><?php }
            ?>
        </div>
        <div class="interested-container">
            <?php if(isset($_SESSION["user_id"])) {
                $user_id = $_SESSION["user_id"];
                $sql_isLiked = "SELECT * FROM interested_users_properties WHERE user_id=$user_id AND property_id=$pg_id";
                $isLiked_result = mysqli_query($con, $sql_isLiked);
                if(mysqli_num_rows($isLiked_result)==1) { ?>
                    <i class="is-interested-image fas fa-heart" style="color:#EA322E;" property_id="<?php echo $pg_id; ?>"></i>
                <?php } else { ?>
                    <i class="is-interested-image far fa-heart" style="color:#aaa;" property_id="<?php echo $pg_id; ?>"></i>
                <?php }
            } else { ?>
                <i class="is-interested-image far fa-heart" property_id="<?php echo $pg_id; ?>" onclick="alert('Please login first!')"></i>
            <?php } ?>
            <div class="interested-text">
                <span class="interested-user-count"><?php echo $num_interested; ?></span> interested
            </div>
        </div>
    </div>

    <div class="detail-container">
        <div class="property-name"><?php echo $pg_name; ?></div>
        <div class="property-address"><?php echo $pg_address; ?></div>
        <div class="property-gender">
            <?php
            if($gender_allowed=='male') { ?><img src="img/images/male.png" /><?php }
            elseif($gender_allowed=='female') { ?><img src="img/images/female.png" /><?php }
            else { ?><img src="img/images/malefemale.png" /><?php }
            ?>
        </div>
    </div>
    <div class="row no-gutters">
    <div class="rent-container col-6">
        <div class="rent">Rs <?php echo $pg_rent; ?>/-</div>
        <div class="rent-unit">per month</div>
    </div>
    <div class="button-container col-6">

<?php if(isset($_SESSION["user_id"])) { ?>

    <a href="#"
       class="btn btn-primary"
       onclick="alert('Booking feature coming soon!'); return false;">
       Book Now
    </a>

<?php } else { ?>

    <a href="#"
       class="btn btn-primary"
       data-toggle="modal"
       data-target="#login-modal">
       Book Now
    </a>

<?php } ?>

    </div>
</div>
</div>

<div class="property-amenities">
    <div class="page-container">
        <h1>Amenities</h1>
        <div class="row justify-content-between">
            <?php
            $amenity_types = ['Building', 'Common Area', 'Bedroom', 'Washroom'];
            foreach($amenity_types as $type) {
                $query = "SELECT properties_amenities.id, amenities.name, amenities.icon 
                          FROM properties_amenities 
                          JOIN amenities ON properties_amenities.amenity_id=amenities.id 
                          WHERE amenities.type='$type' AND properties_amenities.property_id=$pg_id";
                $result = mysqli_query($con, $query);
                if($result && mysqli_num_rows($result)>0) {
                    echo '<div class="col-md-auto"><h5>'.$type.'</h5>';
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="amenity-container">';
                     if($row["name"] == "Wifi") {
    echo '<i class="fas fa-wifi"></i> ';
}
elseif($row["name"] == "TV") {
    echo '<i class="fas fa-tv"></i> ';
}
elseif($row["name"] == "Power Backup") {
    echo '<i class="fas fa-bolt"></i> ';
}
elseif($row["name"] == "Lift") {
    echo '<i class="fas fa-arrow-up"></i> ';
}
elseif($row["name"] == "Geyser") {
    echo '<i class="fas fa-shower"></i> ';
}
elseif($row["name"] == "Fire Extinguisher") {
    echo '<i class="fas fa-fire-extinguisher"></i> ';
}
elseif($row["name"] == "Water Purifier") {
    echo '<i class="fas fa-tint"></i> ';
}
elseif($row["name"] == "Dining") {
    echo '<i class="fas fa-utensils"></i> ';
}
elseif($row["name"] == "Washing Machine") {
    echo '<i class="fas fa-soap"></i> ';
}
elseif($row["name"] == "Bed") {
    echo '<i class="fas fa-bed"></i> ';
}
elseif($row["name"] == "Bed with Mattress") {
    echo '<i class="fas fa-bed"></i> ';
}
elseif($row["name"] == "Air Conditioner") {
    echo '<i class="fas fa-snowflake"></i> ';
}
elseif($row["name"] == "CCTV") {
    echo '<i class="fas fa-video"></i> ';
}
                        echo '<span>'.$row["name"].'</span>';
                        echo '</div>';
                    }
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</div>


<div class="property-about page-container">
    <h1>About the Property</h1>
    <p><?php echo $pg_description; ?></p>
</div>


<div class="property-rating">
    <div class="page-container">
        <h1>Property Rating</h1>
        <div class="row align-items-center justify-content-between">
            <div class="col-md-6">
                <?php
                $ratings = [
                    ['icon' => 'fa-broom', 'label' => 'Cleanliness', 'value' => $pg_rating_clean],
                    ['icon' => 'fa-utensils', 'label' => 'Food Quality', 'value' => $pg_rating_food],
                    ['icon' => 'fa-lock', 'label' => 'Safety', 'value' => $pg_rating_safety],
                ];
                foreach($ratings as $rating) {
                    $sf = floor($rating['value']);
                    $se = 5-1-$sf;
                    echo '<div class="rating-criteria row">';
                    echo '<div class="col-6"><i class="fas '.$rating['icon'].'"></i> '.$rating['label'].'</div>';
                    echo '<div class="col-6">';
                    for($i=1;$i<=$sf;$i++) echo '<i class="fas fa-star"></i>';
                    if(($rating['value']-$sf)>0.2 && ($rating['value']-$sf)<0.8) echo '<i class="fas fa-star-half-alt"></i>';
                    elseif(($rating['value']-$sf)>=0.8) echo '<i class="fas fa-star"></i>';
                    else echo '<i class="far fa-star"></i>';
                    for($i=1;$i<=$se;$i++) echo '<i class="far fa-star"></i>';
                    echo '</div></div>';
                }
                ?>
            </div>
            <div class="col-md-4 text-center">
                <div class="rating-circle">
                    <div class="total-rating"><?php echo $pg_rating_overall; ?></div>
                    <div class="rating-circle-star-container">
                        <?php
                        $sf = floor($pg_rating_overall);
                        $se = 5-1-$sf;
                        for($i=1;$i<=$sf;$i++) echo '<i class="fas fa-star"></i>';
                        if(($pg_rating_overall-$sf)>0.2 && ($pg_rating_overall-$sf)<0.8) echo '<i class="fas fa-star-half-alt"></i>';
                        elseif(($pg_rating_overall-$sf)>=0.8) echo '<i class="fas fa-star"></i>';
                        else echo '<i class="far fa-star"></i>';
                        for($i=1;$i<=$se;$i++) echo '<i class="far fa-star"></i>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
$sql_testimonials = "SELECT * FROM testimonials WHERE property_id=$pg_id";
$testimonials_result = mysqli_query($con, $sql_testimonials);
if($testimonials_result && mysqli_num_rows($testimonials_result)>0) { ?>

<div class="property-testimonials page-container">
    <h1>What People Say</h1>
</div>

<?php while($testimonial = mysqli_fetch_assoc($testimonials_result)) { ?>
<div class="testimonial-block">

    <div class="testimonial-image-container">
        <img src="img/images/user.png" alt="User" class="testimonial-img">
    </div>
    <div class="testimonial-text">
        <i class="fas fa-quote-left"></i>
        <p><?php echo $testimonial["content"]; ?></p>
    </div>
    <div class="testimonial-name">- <?php echo $testimonial["user_name"]; ?></div>
</div>
<?php } ?>

<?php } ?>

<?php } ?>

<?php include "includes/footer.php"; ?>
<?php include "includes/login_modal.php"; ?>
<?php include "includes/signup_modal.php"; ?>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/property_detail.js"></script>
<script src="js/login.js"></script>
</body>
</html>
<?php mysqli_close($con); ?> 