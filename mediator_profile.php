<?php
session_start();
include("db.php");

// Check if session variable is set
if (isset($_SESSION['useremail'])) {
    $userprofile = $_SESSION['useremail'];

    // Query for user information
    $sql = "SELECT * FROM user WHERE email='$userprofile'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $data = mysqli_fetch_assoc($result); // Fetch user data
    } else {
        echo "No user data found.";
        exit();
    }
} else {
    echo "User email not set in session.";
    exit();
}

// Close the database connection
$conn->close();
?>

<!-- HTML START -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>User Profile</title>
    <style>
        .logout-button, .edit-profile {
            height: 40px;
            padding: 0 20px;
            border-radius: 25px;
            color: white;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s;
        }

        .logout-button {
            background-color: #dc3545;
        }

        .logout-button:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }

        .edit-profile {
            background-color: #007bff;
        }

        .edit-profile:hover {
            background-color: #0069d9;
            transform: scale(1.05);
        }
    </style>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/favicon.ico" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
<section class="header">
    <?php include("mediator_nav.php"); ?>
    <div class="text-box">
        <h1 style='color:white;'>My Profile as Mediator</h1>
    </div>
</section>

<!-- Profile Section -->
<section style="background-color: #eee;">
    <div class="container py-5">
        <div class="row">
            <!-- Profile left side -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <?php
                        echo "<img src='" . htmlspecialchars($data['profilepic']) . "' height='100px' width='100px' alt='Profile Picture'>";
                        ?>
                        <p class="text-muted mb-1">Welcome, valued client!</p>
                        <p class="text-muted mb-4">Thank you for being with us.</p>

                        <div class="d-flex justify-content-center mb-2">
                            <a class="edit-profile" style="padding-top:7px" href="mediator_edit_profile.php">Edit Profile</a>
                        </div>
                        <div class="d-flex justify-content-center mb-2">
                            <a class="logout-button" style="padding-top:7px" href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile details right side -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Full Name</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?php echo htmlspecialchars($data['fullname']); ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?php echo htmlspecialchars($data['email']); ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Phone</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?php echo htmlspecialchars($data['phone']); ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Status</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-muted mb-0"><?php echo htmlspecialchars($data['status']); ?></p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Profile Section End -->

<!-- Footer Section -->
<!-- Footer code remains unchanged -->

<!-- JavaScript Libraries -->
<script src="lib/jquery/jquery.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/counterup/counterup.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>

</body>
</html>
