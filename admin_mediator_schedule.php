<?php

include('db.php');

// Initialize search terms
$searchTime = isset($_GET['search_time']) ? $_GET['search_time'] : '';
$searchProfession = isset($_GET['search_profession']) ? $_GET['search_profession'] : '';

// Base query to fetch mediators
$query = "SELECT * FROM mediator WHERE 1=1";

// Add filters based on user input
if ($searchTime != '') {
    $query .= " AND free LIKE '%$searchTime%'";
}
if ($searchProfession != '') {
    $query .= " AND profession LIKE '%$searchProfession%'";
}

// Execute query
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <title>Alliance</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/favicon.ico" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        /* Custom animation for mediator cards */
        .lawyer-card {
            position: relative;
            overflow: hidden;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }
        .lawyer-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        /* Circle styling for images */
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
<section class="header">
    <?php
    include("admin_navbar.php");
    ?>
    
    <div class="text-box">
        <h1 style ='color:white;'>Mediator Schedule</h1>
    </div>
</section>

    <!-- Search Bars Start -->
    <div class="container mb-5">
        <form method="GET" action="">
            <div class="row">
                <!-- Search by Free Time -->
                <div class="col-md-6 mb-3">
                    <input type="text" name="search_time" class="form-control" placeholder="Search by free date (e.g., 1 January 2025)" value="<?php echo htmlspecialchars($searchTime); ?>">
                </div>
                <!-- Search by Profession -->
                <div class="col-md-6 mb-3">
                    <input type="text" name="search_profession" class="form-control" placeholder="Search by profession (e.g., Lawyer)" value="<?php echo htmlspecialchars($searchProfession); ?>">
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
    </div>
    <!-- Search Bars End -->

    <!-- Team Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $name = $row['name'];
                        $email = $row['email'];
                        $phone = $row['phone'];
                        $image = 'medpic/' . $row['pic'];
                        $profession = $row['profession'];
                        $freeTime = $row['free'];
                        ?>
                        <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="lawyer-card team-item text-center rounded overflow-hidden">
                                <div class="team-img position-relative">
                                    <img class="lawyer-image img-fluid" src="<?php echo $image; ?>" alt="<?php echo $name; ?>">
                                </div>
                                <div class="p-4">
                                    <h5 class="mb-0"><?php echo $name; ?></h5>
                                    <small><?php echo $email; ?></small><br>
                                    <small><?php echo $phone; ?></small><br>
                                    <small>Profession: <?php echo $profession; ?></small><br>
                                    <small>Available: <?php echo $freeTime; ?></small>
                                </div>
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
</body>

</html>
