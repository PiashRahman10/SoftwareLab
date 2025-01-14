<?php


?>

<!doctype html>
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

  <!-- Extra custom styles -->
  <style>
    .list-group-item:hover {
      background: skyblue !important;
    }
    .list-group-item {
      width: 320px !important;
    }
  </style>
</head>
<body>

  <div class="container light-style flex-grow-1 container-p-y">
    <h4 class="" style="margin-top: 100px;"></h4>
    <div class="row">
      <div id="list-example" class="list-group col-lg-3 side">
        <a class="list-group-item list-group-item-action" href="profile.php">Account</a>
        <a class="list-group-item list-group-item-action" href="chat.php">Chat</a>
        <a class="list-group-item list-group-item-action" href="my_post.php">Your Post</a>
        <a class="list-group-item list-group-item-action" href="change_password.php">Change password</a>
        <a class="list-group-item list-group-item-action" href="arbitration_history.php">Arbitration History</a>
        <a class="list-group-item list-group-item-action" href="mediation_history.php">Mediation History</a>

        <?php
          $host = 'localhost';
          $dbuser = 'root';
          $dbpass = '';
          $dbname = 'adr';
          $conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);
         
if (!isset($_SESSION['useremail'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}
// Check if session variable is set
if (isset($_SESSION['useremail'])) {
    $userprofile = $_SESSION['useremail'];

    // Attempt to query the database
    $sql = "SELECT * FROM user WHERE email='$userprofile'"; 
    $result = $conn->query($sql);
    
    // Check if the query executed successfully
    if ($result) {
        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Fetch user data
            $data = mysqli_fetch_assoc($result);
        } else {
            echo "No user data found.";
        }
    } else {
        // If there was an error with the query
        echo "Error: " . $conn->error;
    }
} else {
    // If session variable is not set
    echo "User email not set in session.";
}

          // SQL query to fetch user status
          $sql = "SELECT * FROM user WHERE status='user' AND email='$userprofile ' ";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            
            // Output "Personal Lawyer" link if the result is found
            echo '<a class="list-group-item list-group-item-action" href="personal_lawyer.php">Personal Lawyer</a>';
          } else {
            // Output "Personal Client" link if no result is found
            echo '<a class="list-group-item list-group-item-action" href="personal_client.php">Personal Client</a>';
          }

         
        ?>

        <a class="list-group-item list-group-item-action" href="logout.php">Logout</a>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

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
