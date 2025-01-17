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

// Check if form is submitted
if (isset($_POST['submit'])) {
    $description = mysqli_real_escape_string($conn, $_POST['content']);
    $date = mysqli_real_escape_string($conn, $_POST['current_date']);
   
    // Handle file upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $targetDir = "uploads/"; // Directory where the image will be stored
        $targetFile = $targetDir . basename($_FILES["profile_picture"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the file is an image
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check !== false) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
                // Insert the form data and file path into the database
                $sqlinstitution = "INSERT INTO community (fullname, email,date,description,file ) 
                                 VALUES ('$name', '$userprofile','$date', '$description', '$targetFile')"; 

                // Check if the query is successful
                if (mysqli_query($conn, $sqlinstitution)) {
                    echo '<script>
                    window.location.href="query.php"; 
                    alert(" Posted. now refresh the page ")
                    </script>';
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
}
// Check if delete button is clicked
if (isset($_POST['delete'])) {
    $emailToDelete = mysqli_real_escape_string($conn, $_POST['email']);
    $idToDelete = mysqli_real_escape_string($conn, $_POST['id']);
    
    // Perform the delete operation
    $delete_sql = "DELETE FROM community WHERE email = '$emailToDelete' AND id='$idToDelete'";
    
    if (mysqli_query($conn, $delete_sql)) {
        echo '<script>alert("Post deleted successfully."); </script>';
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
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
        /* Style for the Like and Comment buttons side by side */
.like-comment-section {
    display: flex;
    justify-content: space-between; /* Space out like and comment */
    align-items: center; /* Vertically align the items */
    gap: 10px; /* Add some space between the buttons */
    margin-top: 10px;
}

.like-btn {
    display: flex;
    align-items: center;
    padding: 6px 12px;
    font-size: 14px;
    border-radius: 4px;
}

.like-btn i {
    margin-right: 5px; /* Space between the icon and text */
}

.comment-form {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
}

.comment-form textarea {
    width: 100%;
    padding: 6px;
    font-size: 14px;
    border-radius: 4px;
    border: 1px solid #ccc;
    resize: vertical;
}

.comment-form button {
    padding: 6px 12px;
    font-size: 14px;
    border-radius: 4px;
    background-color: #6c757d;
    color: white;
    border: none;
}

.comment-form button:hover {
    background-color: #5a6268;
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

   

    <div class="main-content">
    <div class="row">
        <div class="col-lg-4" >
            <div class="create-post-card" style=" position: fixed;">
                <h4>Create a Post</h4>
                <form action="#" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="content" class="form-label">Post Content</label>
                        <textarea class="form-control" id="content" name="content" rows="2" required style="width: 300px;"></textarea>
                    </div>
                    <label for="profile_picture" class="form-label">Upload Post Image </label>
                    <div class="mb-3">
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                    </div>
                    <?php if (isset($_SESSION['useremail'])): ?>
                        <input type="hidden" id="current_date" name="current_date">
                        <button type="submit" name="submit" class="btn btn-primary">Create Post</button>
                        <?php else: ?>
                            <?php echo'For Resgistared Person' ?>  
                            <?php endif; ?>
                </form>
            </div>
        </div>
        <div class="col-lg-8">
            <?php
                // Example of fetching data from the database
                $sql = "SELECT u.profilepic, c.id, c.email, c.fullname, c.description, c.file, c.date,
                        (SELECT COUNT(*) FROM likes WHERE post_id = c.id) AS like_count,
                        (SELECT COUNT(*) FROM comments WHERE post_id = c.id) AS comment_count
                        FROM community AS c
                        JOIN user AS u ON u.email = c.email
                        ORDER BY c.id DESC";
                $result = $conn->query($sql);

                // Check if the result has rows
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Output the post content and links to comment and like
                        echo '<div class="post-card p-2">
                                <div class="card-body">
                                    <div class="user-info">
                                        <img src="' . $row["profilepic"] . '" alt="Avatar" class="user-avatar">
                                        <strong>' . $row["fullname"] . '</strong>
                                    </div>
                                    <p class="post-time">' . $row["date"] . '</p>
                                    <p class="post-content">' . htmlspecialchars($row["description"]) . '</p>
                                    <img src="' . $row["file"] . '" alt="Post Image" class="post-image">
                                    <p style="margin-top:7px; ">Likes: ' . $row["like_count"] . ' | 
                                    <a href="show_comments.php?post_id=' . $row['id'] . '">  Comments:</a> ' . $row["comment_count"] . '
                                    </p>
                                    <div class="like-comment-section">
                                        <form action="like_post.php" method="POST" class="like-form">
                                            <input type="hidden" name="post_id" value="' . $row["id"] . '">
                                            <button type="submit" class="btn btn-primary like-btn">
                                                <i class="fa fa-thumbs-up"></i> Like
                                            </button>
                                        </form>

                                        <!-- Comment Section -->
                                        <form action="comment_post.php" method="POST" class="comment-form">
                                            <input type="hidden" name="post_id" value="' . $row["id"] . '">
                                            <textarea name="comment_text" placeholder="Write a comment..." required></textarea>
                                            <button type="submit" class="btn btn-secondary">Comment</button>
                                        </form>
                                    </div>
                                </div>
                            </div>';
                    }
                } else {
                    echo "No posts found.";
                }
            ?>

                      
        </div>
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

