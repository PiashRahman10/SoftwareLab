<?php
session_start();

// Database connection details
$host = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'adr';
$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);

// Check if connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_SESSION['useremail'])) {
    $userprofile = $_SESSION['useremail'];
    $name  = "";

    // Ensure the profilephoto column exists
    $sql = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $sql->bind_param("s", $userprofile);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $name = $data["fullname"];
    }
}

// Check if delete button is clicked
if (isset($_POST['delete'])) {
    $emailToDelete = mysqli_real_escape_string($conn, $_POST['email']);
    $idToDelete = mysqli_real_escape_string($conn, $_POST['id']);

    // Start a transaction to ensure all deletions are atomic
    mysqli_begin_transaction($conn);

    try {
        // Delete from likes table
        $sql_likes = "DELETE FROM likes WHERE post_id = ?";
        $stmt_likes = $conn->prepare($sql_likes);
        $stmt_likes->bind_param("i", $idToDelete);
        $stmt_likes->execute();

        // Delete from comments table
        $sql_comments = "DELETE FROM comments WHERE post_id = ?";
        $stmt_comments = $conn->prepare($sql_comments);
        $stmt_comments->bind_param("i", $idToDelete);
        $stmt_comments->execute();

        // Delete from community table (the post)
        $delete_sql = "DELETE FROM community WHERE email = ? AND id = ?";
        $stmt_delete = $conn->prepare($delete_sql);
        $stmt_delete->bind_param("si", $emailToDelete, $idToDelete);
        $stmt_delete->execute();

        // Commit the transaction
        mysqli_commit($conn);
        
        echo '<script>alert("Post deleted successfully."); </script>';
        } catch (Exception $e) {
        // If there is any error, rollback the transaction
        mysqli_rollBack($conn);
        echo "Error deleting record: " . $e->getMessage();
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <title>Alliance </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- xtra team link start -->
    <style>
        /* Custom animation for lawyer cards */
        .arb-card {
            position: relative;
            overflow: hidden;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }
        .arb-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        /* Increase circle size, border, and padding for images */
        .arb-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border: 5px solid #007bff;
            padding: 7px;
        }
        .page-header {
            background: url("header-page.jpg") top center no-repeat;
            background-size: cover;
            text-shadow: 0 0 30px rgba(0, 0, 0, .1);
        }



        

        /* Main Content Styles */
        .main-content {
            width: 80%;
            margin: 100px;
        }

        /* Post Card Styles */
        .post-card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
            transition: box-shadow 0.3s ease;
            max-width: 600px;
        }
        .post-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card-body {
            padding: 20px;
        }
        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .post-content {
            font-size: 16px;
            margin-bottom: 10px;
            color: #666666;
        }
        .post-time {
            font-size: 14px;
            color: #999999;
            margin-bottom: 10px;
        }
        .post-image {
            width: 100%;
            height: 300px;
            border-radius: 10px;
            margin-top: 10px;
            object-fit: cover;
            display: block;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                width: 90%;
            }
        }
    </style>
    

</head>

<body>
    
    <!-- Topbar Start -->
    <div class="container-fluid bg-light p-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="row gx-0 d-none d-lg-flex">
            <div class="col-lg-7 px-5 text-start">
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                    <small class="fa fa-map-marker-alt text-primary me-2"></small>
                    <small>Baridhara, Gulshan-2, Dhaka-1212</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center py-3">
                    <small class="far fa-clock text-primary me-2"></small>
                    <small>Sat - Thu : 09.00 AM - 09.00 PM</small>
                </div>
            </div>
            <div class="col-lg-5 px-5 text-end">
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                    <small class="fa fa-phone-alt text-primary me-2"></small>
                    <small>+88 01780337775</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center">
                    <a class="btn btn-sm-square rounded-circle bg-white text-primary me-1" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-sm-square rounded-circle bg-white text-primary me-1" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-sm-square rounded-circle bg-white text-primary me-1" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-sm-square rounded-circle bg-white text-primary me-0" href=""><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>

    
<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 wow fadeIn" data-wow-delay="0.1s">
    <a href="Homepage.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h1 class="m-0 text-primary"><i class="fas fa-landmark me-3"></i>Alliance</h1>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="Homepage.php" class="nav-item nav-link">Home</a>
            <a href="aboutus.php" class="nav-item nav-link ">About</a>
            
            <a href="mediator.php" class="nav-item nav-link">Mediator</a>
            <a href="arbitrator.php" class="nav-item nav-link active">Arbitrator</a>
            <a href="query.php" class="nav-item nav-link">Query</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle " data-bs-toggle="dropdown">Service</a>
                <div class="dropdown-menu rounded-0 rounded-bottom m-0">
                    <a href="Arbitration_proposal.php" class="dropdown-item ">Arbitration Proposal</a>
                    <a href="Arbitration.php" class="dropdown-item">Arbitration Case File</a>
                    <a href="mediation_proposal.php" class="dropdown-item">Mediation Proposal</a>
                    <a href="mediation.php" class="dropdown-item">Mediation Case File</a>
                    <a href="others.php" class="dropdown-item">Service Information</a>
                    <a href="lawyer.php" class="dropdown-item">Lawyers Info</a>
                    
                </div>
            </div>
            <a href="profile.php" class="nav-item nav-link">Profile</a>
        </div>
        <a href="lawyer_registration.php" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block">Register<i class="fa fa-arrow-right ms-3"></i><br>as lawyer</a>
    </div>
</nav>
    <!-- Navbar End -->

   


<div class="container light-style flex-grow-1 container-p-y">
        <h4 class=""></h4>
        <div class="row">
            
            <div class="col-lg-3 " style="position:fixed">
                <?php include("Profile_side_nabbar.php"); ?>
            </div>

            <!--Post content part -->
            <div class="col-lg-9 " style="margin-top: 100px; margin-left:375px; ">
                                            <?php
                                              
                                              // SQL query to fetch events
                                              $sql = "SELECT u.profilepic,c.id, c.email, c.fullname, c.description, c.file, c.date
                                                            FROM community AS c
                                                            JOIN user AS u ON u.email = c.email
                                                            ORDER BY  id DESC; ";
                                              $result = $conn->query($sql);
                      
                                            if ($result->num_rows > 0) {
                                               
                                                    // Loop through the results and display each event
                                                  // Inside the while loop where you display the posts
                                                while ($row = $result->fetch_assoc()) {
                                                   
                                                    if ($userprofile == $row["email"]) {  // Display delete button for logged-in user
                                                        echo '<div class="post-card p-2">
                                                                <div class="card-body">
                                                                    <div class="user-info">
                                                                        <img src="' . $row["profilepic"] . '" alt="Avatar" class="user-avatar">
                                                                        <strong>' . $row["fullname"] . '</strong>
                                                                        <form method="post" action="" style="display:inline;">
                                                                            <input type="hidden" name="email" value="' . $row["email"] . '">
                                                                            <input type="hidden" name="id" value="' . $row["id"] .'">
                                                                            <button class="btn delete btn-danger btn-sm" type="submit" name="delete" style="margin-left:220px;">Delete</button>
                                                                        </form>
                                                                    </div>
                                                                    <p class="post-time">' . $row["date"] . '</p>
                                                                    <img src="' . $row["file"] . '" alt="Post Image" class="post-image">
                                                                    <p class="post-content">' . $row["description"] . '</p>
                                                                </div>
                                                            </div>';
                                                    } else {
                                                        echo 'You have not posted yet';
                                                    }
                                                }
                                                
 
                                                
                                                  
                                              } else {
                                                  echo "No events found";
                                              }
                      
                                              mysqli_close($conn);  
                                            ?> 
            </div>
            <!--Post content part -->

        </div>
    </div>
   
   

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    


    <!-- JavaScript to set the current date in the hidden field -->
<script>
    // Automatically populate the current date and time into the hidden input field
    document.getElementById('current_date').value = new Date().toISOString().slice(0, 19).replace('T', ' ');
</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

