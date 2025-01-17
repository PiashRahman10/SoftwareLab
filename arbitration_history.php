<?php 
    session_start();
    include("db.php");

    $userprofile = $_SESSION['useremail'];

    $sql = "SELECT * FROM user WHERE email='$userprofile'"; 
    $result = $conn->query($sql);
    $data = mysqli_fetch_assoc($result);

    // Initialize SQL query for searching arbitration proposals
    $sql2 = "SELECT * FROM arbitration_proposal "; 
    $result2 = $conn->query($sql2);

    // Check if the search button is clicked
    if (isset($_POST['search'])) {
        $caseNumber = $_POST['caseNumber'] ?? '';
        $defendent = $_POST['defendent'] ?? ''; // Correct form field name
        $type = $_POST['type'] ?? '';

        // Build SQL query with conditions only if values are provided
        $conditions = [];

        if (!empty($type)) {
            $conditions[] = "status LIKE ?";
        }
        if (!empty($caseNumber)) {
            $conditions[] = "casenumber = ?";
        }
        if (!empty($defendent)) {
            $conditions[] = "person2 LIKE ?";
        }

        // Prepare the final SQL query with dynamic WHERE conditions
        if (count($conditions) > 0) {
            $sql = "SELECT * FROM arbitration_proposal WHERE  " . implode(' OR ', $conditions);
        } else {
            $sql = "SELECT * FROM arbitration_proposal WHERE status='pending'";
        }

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the values dynamically
        $bindTypes = '';
        $bindValues = [];

        if (!empty($type)) {
            $bindTypes .= 's'; // Add string type for status
            $bindValues[] = "%" . $type . "%"; // Add the type with wildcards
        }
        if (!empty($defendent)) {
            $bindTypes .= 's'; // Add string type for defendant
            $bindValues[] = "%" . $defendent . "%"; // Add the defendant with wildcards
        }
        if (!empty($caseNumber)) {
            $bindTypes .= 's'; // Add string type for case number
            $bindValues[] = $caseNumber; // Add the case number directly
        }

        if (count($bindValues) > 0) {
            $stmt->bind_param($bindTypes, ...$bindValues);  // Bind dynamically
        }

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();
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
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f3f6fa;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .main-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 20px;
    }

    .container1 {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        margin-top: 50px;
    }

    h1 {
        text-align: center;
        font-size: 2.5rem;
        color: #333;
        padding: 15px;
        border-radius: 50px;
        margin-bottom: 50px;
        font-weight: bold;
    }

    .arbitration, .mediation, .lawyer {
        margin-top: 40px;
    }

    .arbitration h2, .mediation h2, .lawyer h2 {
        font-size: 1.75rem;
        text-align: center;
        color: #333;
        padding: 10px;
        margin-bottom: 20px;
        position: relative;
    }

    .arbitration h2::after, .mediation h2::after, .lawyer h2::after {
        content: "";
        display: block;
        height: 4px;
        background: linear-gradient(90deg, #ff6b6b, #f06595, #48c6ef, #6f86d6);
        margin: 10px auto;
        width: 100%;
        border-radius: 5px;
        animation: moveGradient 2s linear infinite;
    }

    @keyframes moveGradient {
        0% { background-position: 0 0; }
        100% { background-position: 100% 0; }
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        background-color: #f9fbfd;
    }

    th, td {
        padding: 12px 20px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #48c6ef;
        color: white;
        text-transform: uppercase;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    td {
        color: #555;
    }

    @media (max-width: 768px) {
        .container {
            padding: 20px;
        }

        th, td {
            padding: 10px;
        }

        h1 {
            font-size: 2rem;
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
            <a href="Homepage.php" class="nav-item nav-link ">Home</a>
            <a href="aboutus.php" class="nav-item nav-link ">About</a>
            
            <a href="mediator.php" class="nav-item nav-link">Mediator</a>
            <a href="arbitrator.php" class="nav-item nav-link">Arbitrator</a>
            <a href="query.php" class="nav-item nav-link">Query</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Service</a>
                <div class="dropdown-menu rounded-0 rounded-bottom m-0">
                    <a href="Arbitration_proposal.php" class="dropdown-item">Arbitration Proposal</a>
                    <a href="Arbitration.php" class="dropdown-item active">Arbitration Case File</a>
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
    <style>
    .page-header {
    background: url("header-page.jpg") top center no-repeat;
    background-size: cover;
    text-shadow: 0 0 30px rgba(0, 0, 0, .1);
}
</style>

   


    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class=""></h4>
        <div class="row">
            <div class="col-lg-3 " style="position:fixed">
                <?php include("Profile_side_nabbar.php"); ?>
            </div>

            <div class="col-lg-9 " style="margin-top: 30px; margin-left:375px; margin-bottom:120px; ">
            <div class="arbitration">
            <h2>Arbitration</h2>
            <form action="#" method="POST">
                <div style="display:flex;">
                    <div class="" style=" margin-left:25px;">
                        <label for="divisionSelect" class="form-label">Select Type</label>
                        <select class="form-select" id="typeSelect" name="type">
                            <option value="">None</option>
                            <option value="pending">Pending</option>
                            <option value="done">Complete</option> 
                        </select>
                    </div>
                    <div style=" margin-left:25px;">
                        <label for="postCode">Case Number</label>
                        <input type="text" class="form-control" name="caseNumber" style="width:100px;">
                    </div>
                    <div style=" margin-left:25px;">
                        <label for="postCode">Defendant Name</label>
                        <input type="text" class="form-control" name="defendent" style="width:100px;">
                    </div>
                    <div class=" align-self-end" style=" margin-left:25px;">
                        <button type="submit" class="btn btn-primary" name="search" style="height:40px; width:120px; margin-bottom:17px;">Search</button>
                    </div>
                </div>
            </form>

            <table style="margin-top:10px; ">
                <thead>
                    <tr>
                        <th>Plaintiff</th>
                        <th>Defendant</th>
                        <th>Issues</th>
                        <th>Case Number</th>
                        <th>Online Status</th>
                        <th> Arbitrator ID</th>
                        <th> Details </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $arbitration_sql = "SELECT * FROM arbitration_proposal 
                                        WHERE ((email1='$userprofile') OR (email2='$userprofile'))";
                    $arbitration_result = $conn->query($arbitration_sql);

                    while ($row = $arbitration_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['person1'] . "</td>";
                        echo "<td>" . $row['person2'] . "</td>";
                        echo "<td>" . $row['issues'] . "</td>";
                        echo "<td>" . $row['casenumber'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . $row['arbitrator_id'] . "</td>";
                        echo '<td><a href="arbitration_details.php?email=' . $row['email1'] . '">Click</a></td>';
                        echo "</tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
            </div>
        </div>
    </div>



   

   <!-- Footer Start -->
   <div class="container-fluid bg-dark text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Address</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Baridhara, Gulshan-2, Dhaka-1212</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+88 01780337775</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>alliance247@gmail.com</p>
                    
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Services</h5>
                    <a class="btn btn-link" href="">Arbitration</a>
                    <a class="btn btn-link" href="">Mediation</a>
                    <a class="btn btn-link" href="">Lawyers</a>
                    <a class="btn btn-link" href="">Arbitration case file</a>
                    <a class="btn btn-link" href="">Mediation Case File</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Quick Links</h5>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Our Services</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Support</a>
                </div>
                <!-- most right text area-->
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Follow Us</h5>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social rounded-circle" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social rounded-circle" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <!-- end of most right text area-->
            </div>
        </div>
        
    </div>
    <!-- Footer End -->



    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>