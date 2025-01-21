<?php
    // Database connection
    $host = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'adr';
    $conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $Lid= $_GET['lawyer_id'];
    session_start();
    if (isset($_SESSION['useremail'])) {
        $userprofile = $_SESSION['useremail'];
    } else {
        // If session doesn't exist, redirect to login
        header("Location: login.php");
        exit();
    }

    // Fetch logged-in user data
    $sql1 = "SELECT * FROM user WHERE email='$userprofile'";
    $result1 = mysqli_query($conn, $sql1);

    if ($result1 && mysqli_num_rows($result1) > 0) {
        $data = mysqli_fetch_assoc($result1);
    } else {
        echo "Error: User data not found.";
        exit();
    }

    // Initialize variables for error handling
    $appointmentdateErr = $appointmenttimeErr = $reasonErr = $phoneErr = $opphoneErr = "";
    $appointmentdate = $appointmenttime = $reason = $num1 = $num2 = "";
    $lawyer_id = "";

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        $valid = true;

        // Validate form fields
        if (empty($_POST['appointmentdate'])) {
            $appointmentdateErr = "Appointment date is required.";
            $valid = false;
        } else {
            $appointmentdate = $_POST['appointmentdate'];
        }

        if (empty($_POST['appointmenttime'])) {
            $appointmenttimeErr = "Appointment time is required.";
            $valid = false;
        } else {
            $appointmenttime = $_POST['appointmenttime'];
        }

        if (empty($_POST['reason'])) {
            $reasonErr = "Reason is required.";
            $valid = false;
        } else {
            $reason = $_POST['reason'];
        }

        if (empty($_POST['phone'])) {
            $phoneErr = "Phone number is required.";
            $valid = false;
        } else {
            $num1 = $_POST['phone'];
        }

        if (empty($_POST['opphone'])) {
            $opphoneErr = "Guardian's phone number is required.";
            $valid = false;
        } else {
            $num2 = $_POST['opphone'];
        }

        if (!empty($_GET['lawyer_id'])) {
            $lawyer_id = $_GET['lawyer_id'];
        }

        if ($valid) {
            $email = $data['email'];

            // Insert appointment into the database
            $query = "INSERT INTO appointment (user_email,  appointment_date, appointment_time, status, reason, num, opnum) 
                      VALUES ('$email', '$appointmentdate', '$appointmenttime', 'pending', '$reason', '$num1', '$num2')";

            if (mysqli_query($conn, $query)) {
                header("Location: HomePage.php");
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }

    // Fetch lawyer details
    if (isset($_GET['lawyer_id'])) {
        $lawyer_id = $_GET['lawyer_id'];
        $queryx = "SELECT u.email as email, l.fee, l.free_time, l.date, l.lawyer_id, l.full_name as full_name, 
                   l.catagory AS specialization, l.court as court, l.qualification, u.profilepic as profilepic 
                   FROM user AS u 
                   JOIN lawyer AS l ON u.email = l.email 
                   WHERE u.status = 'lawyer' AND l.lawyer_id = '$lawyer_id'";

        $resultx = mysqli_query($conn, $queryx);
        $datax = mysqli_fetch_assoc($resultx);
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Alliance</title>
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
            <a href="querry.php" class="nav-item nav-link">Query</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Service</a>
                <div class="dropdown-menu rounded-0 rounded-bottom m-0">
                    <a href="Arbitration_proposal.php" class="dropdown-item">Arbitration Proposal</a>
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

    <style>
    .page-header {
    background: url("header-page.jpg") top center no-repeat;
    background-size: cover;
    text-shadow: 0 0 30px rgba(0, 0, 0, .1);
}
</style>

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Lawyer Appointment</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Lawyer Appointment</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Appointment Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
            
<div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
    <div class="bg-light rounded p-5 d-flex">
        <!-- Profile Picture on the Left -->
        <div class="me-4">
            <?php echo "<img class='img-fluid rounded' src='".$datax['profilepic']."' width='270' height='150'>"; ?>
        </div>
        
        <!-- Information on the Right -->
        <div>
            <div class="card-body">
            <!-- Lawyer's Name -->
<h5 class="card-title text-primary"><?php echo $datax['full_name']; ?></h5>

<!-- Lawyer ID -->
<p class="card-text"><strong>Lawyer ID:</strong> <?php echo $datax['lawyer_id']; ?></p>

<!-- Specialization -->
<p class="card-text"><strong>Specialization:</strong> <?php echo $datax['specialization']; ?></p>

<!-- Court -->
<p class="card-text"><strong>Court:</strong> <?php echo $datax['court']; ?></p>

<!-- Qualification -->
<p class="card-text"><strong>Qualification:</strong> <?php echo $datax['qualification']; ?></p>

<!-- Available Time -->
<p class="card-text"><strong>Available Time:</strong> <?php echo $datax['free_time']; ?></p>

<!-- Fees -->
<p class="card-text"><strong>Fees:</strong> <?php echo $datax['fee']; ?></p>

            </div>
        </div>
    </div>
</div>
<!-- Left side code end -->


                <!-- Right side code start -->
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="bg-light rounded h-100 d-flex align-items-center p-5">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="row g-3">
        <div class="col-12 col-sm-6">
            <input type="text" class="form-control border-0" name="fullname" value="<?php echo $data['fullname']; ?>" style="height: 55px;" readonly>
        </div>
        <div class="col-12 col-sm-6">
            <input type="email" class="form-control border-0" name="email" value="<?php echo $data['email']; ?>" style="height: 55px;" readonly>
        </div>
        <div class="col-12 col-sm-6">
            <input type="text" class="form-control border-0" name="phone" placeholder="Your Mobile" style="height: 55px;">
            <span class="error"><?php echo $phoneErr;?></span>
        </div>
        <div class="col-12 col-sm-6">
            <input type="text" class="form-control border-0" name="opphone" placeholder="Guardian Mobile" style="height: 55px;">
            <span class="error"><?php echo $opphoneErr;?></span>
        </div>
        <div class="col-12 col-sm-6">
            <div class="date" id="date" data-target-input="nearest">
                <input type="text"
                    class="form-control border-0 datetimepicker-input"
                    placeholder="Choose Date" data-target="#date" data-toggle="datetimepicker" name="appointmentdate" style="height: 55px;">
                <span class="error"><?php echo $appointmentdateErr;?></span>
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="time" id="time" data-target-input="nearest">
                <input type="text"
                    class="form-control border-0 datetimepicker-input"
                    placeholder="Choose Time" data-target="#time" data-toggle="datetimepicker" name="appointmenttime" style="height: 55px;">
                <span class="error"><?php echo $appointmenttimeErr;?></span>
            </div>
        </div>
        <div class="col-12">
            <div class="form-floating">
                <textarea class="form-control" placeholder="Reason" id="reason" name="reason" style="height: 100px"></textarea>
                <label for="reason">Appointment Reason</label>
                <span class="error"><?php echo $reasonErr;?></span>
            </div>
        </div>
        <div class="col-12">
            <button class="btn btn-primary w-100 py-3" name="submit" type="submit">Book Appointment</button>
        </div>
    </div>
</form>

                    </div>
                </div>
                <!-- Right side code end -->
            </div>
            
        </div>
            
    </div>
    <!-- Appointment End -->


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