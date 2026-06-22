<?php
session_start();

if(isset($_SESSION["user_id"])) {
    require "includes/database_connect.php";
    
    $user_id = $_SESSION["user_id"];
    
    $sql = "SELECT * FROM users WHERE id='$user_id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    
    $full_name = $row["full_name"];
    $email = $row["email"];
    $phone = $row["phone"];
    $college = $row["college_name"];

    $sql_liked = "SELECT * FROM interested_users_properties 
                  INNER JOIN properties 
                  ON interested_users_properties.property_id = properties.id 
                  WHERE user_id=$user_id";
    $liked_result = mysqli_query($con, $sql_liked);
    
} else {
    header("location: index.php");
    exit();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | PG Life</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/all.min.css" rel="stylesheet"/>
    <link href="css/common.css" rel="stylesheet" />
    <link href="css/dashboard.css" rel="stylesheet"/>
</head>
<body>
<?php include "includes/header.php"; ?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb py-2">
        <li class="breadcrumb-item">
            <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Dashboard
        </li>
    </ol>
</nav>


<div class="my-profile page-container">
    <h1>My Profile</h1>
    <div class="row">
        <div class="col-md-3 profile-img-container">
            <i class="fas fa-user profile-img"></i>
        </div>
        <div class="col-md-9">
            <div class="row no-gutters justify-content-between align-items-end">
                <div class="profile">
                    <div class="name"><?php echo $full_name; ?></div>
                    <div class="email"><?php echo $email; ?></div>
                    <div class="phone"><?php echo $phone; ?></div>
                    <div class="college"><?php echo $college; ?></div>
                </div>
                <div class="edit">
                    <a href="#" data-toggle="modal" data-target="#edit-profile-modal">
                    <div class="edit-profile">Edit Profile</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if($liked_result && mysqli_num_rows($liked_result) > 0) {
    while($property = mysqli_fetch_assoc($liked_result)) {
        $pg_name = $property["name"];
        $pg_address = $property["address"];
        $pg_rent = $property["rent"];
        $pg_gender = $property["gender"];
        $pg_id = $property["id"];
?>
        <div class="property-card row">
            <div class="image-container col-md-4">
                <img src="img/images/properties.jpeg" alt="Property Image">
            </div>
            <div class="content-container col-md-8">
                <div class="detail-container">
                    <div class="property-name"><?php echo $pg_name; ?></div>
                    <div class="property-address"><?php echo $pg_address; ?></div>
                    <div class="property-gender">
                        <?php
                        if($pg_gender == 'male') {
                            echo '<img src="img/images/male.png">';
                        } elseif($pg_gender == 'female') {
                            echo '<img src="img/images/female.png">';
                        } else {
                            echo '<img src="img/images/malefemale.png">';
                        }
                        ?>
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="rent-container col-6">
                        <div class="rent">Rs <?php echo $pg_rent; ?>/-</div>
                        <div class="rent-unit">per month</div>
                    </div>
                    <div class="button-container col-6">
                        <a href="#" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
} else {
    echo '<p class="mx-4">No interested properties yet!</p>';
}
?>
<?php include "includes/footer.php"; ?>
<?php include "includes/edit_profile_modal.php"; ?>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
document.querySelectorAll('.interested-container i').forEach(function(icon) {
    let count = 0;
    icon.addEventListener('click', function() {
        this.classList.toggle('active');
        let countDiv = this.nextElementSibling;
        if (this.classList.contains('active')) {
            count++;  
        } else {
            count--;
        }
        countDiv.textContent = count;
    });
});
</script>


</body>
</html>