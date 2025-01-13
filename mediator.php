<?php

$host = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'adr';
$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);

// Initialize search term variable
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch mediators from the database based on the search term
$query = "SELECT * FROM mediator";

// Add search term filter if it's set
if ($searchTerm != '') {
    $query .= " WHERE (name LIKE '%$searchTerm%' OR CONCAT(name, email) LIKE '%$searchTerm%')";
}

// Execute query
$result = mysqli_query($conn, $query);
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
        .lawyer-card {
            position: relative;
            overflow: hidden;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }
        .lawyer-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        /* Increase circle size, border, and padding for images */
        .lawyer-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border: 5px solid #007bff;
            padding: 7px;
        }
    </style>
</head>

<body>
    
   

    <!-- Search Bar Start -->
    <div class="container mb-5">
        <form method="GET" action="">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search for a mediator by name" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
    </div>
    <!-- Search Bar End -->

    <!-- Team Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <?php
                // Check if any mediators found
                if (mysqli_num_rows($result) > 0) {
                    // Fetch mediators and display their info
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Retrieve mediator information
                        $name = $row['name'];
                        $email = $row['email'];
                        $phone = $row['phone'];
                        $image = 'medpic/' . $row['pic']; // Adjusted image path
                        ?>
                        <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="lawyer-card team-item text-center rounded overflow-hidden">
                                <div class="team-img position-relative">
                                    <img class="lawyer-image img-fluid" src="<?php echo $image; ?>" alt="<?php echo $name; ?>">
                                </div>
                                <div class="p-4">
                                    <h5 class="mb-0"><?php echo $name; ?></h5>
                                    <small><?php echo $email; ?></small><br>
                                    <small><?php echo $phone; ?></small>
                                    
                                </div>
                                <a href="mediator_view.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-primary rounded-pill">View Profile</a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p>No mediators found.</p>';
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Team End -->
    