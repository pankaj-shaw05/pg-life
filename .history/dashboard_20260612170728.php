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
            <a href="index.html">Home</a>
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
                    <div class="edit-profile">Edit Profile</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="my-interested-properties">
    <div class="page-container">
        <h1>My Interested Properties</h1>

        
        <div class="property-card row">
            <div class="image-container col-md-4">
                <img src="img/images/properties.jpeg" alt="Property Image">
            </div>
            <div class="content-container col-md-8">
                <div class="row no-gutters justify-content-between">
                    <div class="star-container">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <div class="interested-container">
                        <i class="fas fa-heart"></i>
                        <div class="interested-text">0</div>
                    </div>
                </div>
                <div class="detail-container">
                    <div class="property-name">Navkar Paying Guest</div>
                    <div class="property-address">44, Juhu Scheme, Juhu, Mumbai, Maharashtra 400058</div>
                    <div class="property-gender">
                        <img src="img/images/male.png" alt="">
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="rent-container col-6">
                        <div class="rent">Rs 9,500/-</div>
                        <div class="rent-unit">per month</div>
                    </div>
                    <div class="button-container col-6">
                        <a href="#" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="property-card row">
            <div class="image-container col-md-4">
                <img src="img/images/properties2.jpeg" alt="Property Image">
            </div>
            <div class="content-container col-md-8">
                <div class="row no-gutters justify-content-between">
                    <div class="star-container">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="interested-container">
                        <i class="fas fa-heart"></i>
                        <div class="interested-text">0</div>
                    </div>
                </div>
                <div class="detail-container">
                    <div class="property-name">Ganpati Paying Guest</div>
                    <div class="property-address">Police Beat, SV Road, Borivali East, Mumbai - 400066</div>
                    <div class="property-gender">
                        <img src="img/images/malefemale.png" alt="">
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="rent-container col-6">
                        <div class="rent">Rs 8,500/-</div>
                        <div class="rent-unit">per month</div>
                    </div>
                    <div class="button-container col-6">
                        <a href="#" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include "includes/footer.php"; ?>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
document.querySelectorAll('.interested-container i').forEach(function(icon) {
    let count = 0;
    icon.addEventListener('click', function() {
        this.classList.toggle('active');
        let countDiv = this.nextElementSibling;
        if (this.classList.contains('active')) {
            count++;  // Badhaao
        } else {
            count--;
        }
        countDiv.textContent = count;
    });
});
</script>


</body>
</html>