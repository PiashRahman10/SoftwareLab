
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
        /* Sample 1 Blog Page Styling */
        .blog-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 20px;
        }

        .blog-post {
            background-color: white;
            border-radius: 8px;
            margin-bottom: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .blog-post-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .blog-post img {
            max-width: 400px;
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .blog-post-title {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: left;
            flex: 1;
        }

        .blog-post-title h2 {
            margin: 0;
            font-size: 2rem;
            color: #3a3f58;
        }

        .blog-post p {
            line-height: 1.6;
            margin-top: 20px;
        }
        .back-button {
            
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #f39c12;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #e67e22;
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

<div class="container-xxl py-5">
        <div class="container blog-container">
            <article class="blog-post">
                <div class="blog-post-content">
                    <img src="img2/13a.png" alt="Blog Image">
                    <div class="blog-post-title">
                        <h2 style="color: orange;">General Documentation</h2>
                    </div>
                </div>
                <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quo, vel maiores. Expedita dolorum cum eligendi asperiores corrupti recusandae eaque nisi molestiae necessitatibus repudiandae veniam, voluptatum optio sed, tenetur ullam sapiente?
                    Iste enim deserunt blanditiis nihil similique est, voluptatem unde explicabo soluta, recusandae, cupiditate tempore sint quas aperiam harum. Possimus velit impedit in dolorem aut aperiam. Earum aliquam ea at sequi.
                    Accusamus quas tempora officia, quisquam sint fugit labore distinctio molestiae reprehenderit. Consequuntur repellat, minus ad, ratione vero itaque nesciunt exercitationem asperiores ullam obcaecati voluptates saepe cum, illo vitae? Earum, dolor?
                    Voluptatum laboriosam ex nesciunt id recusandae obcaecati dolorum quo doloremque consectetur voluptate autem praesentium quis eius, excepturi optio illo nobis, fuga veritatis. Ipsam dolores vitae aliquid eius soluta harum eos?
                    Ex, consectetur autem? Magni consequatur distinctio quod rerum repudiandae eum delectus debitis officiis corporis non labore culpa, eos saepe tempore inventore ipsam architecto sapiente perspiciatis optio? Natus neque vitae nesciunt.
                    Accusantium sapiente cupiditate culpa reiciendis ea facilis id voluptate assumenda tempore iste animi deserunt quaerat deleniti omnis voluptatum, dolorem officiis. Quae autem velit obcaecati distinctio reprehenderit pariatur accusamus ad tempore.
                    Repellendus, odit rerum. Nemo repellendus est sit a commodi atque perspiciatis dolorum ex eligendi expedita totam pariatur placeat dolores reprehenderit, voluptatum minus blanditiis itaque repellat doloremque exercitationem. Magni, iusto voluptate?
                    Dolore necessitatibus nihil ipsa beatae, temporibus sit molestiae eaque asperiores odio veritatis modi ab. Recusandae, inventore. Error, tempora! Enim explicabo itaque quae illo, libero laudantium molestias sequi sint ipsa perferendis?
                    Id consequatur aperiam exercitationem tempore, vitae dignissimos magnam facere consequuntur totam sapiente distinctio ipsa esse provident quia ad nam ut facilis a vero ratione eligendi libero necessitatibus optio. Facere, error!
                    Maiores autem natus, architecto modi quidem illo, magnam nam id aliquid voluptatibus molestias, temporibus sunt minima pariatur rerum eveniet atque reiciendis. Laboriosam eveniet illo quidem quod non consequatur voluptatem porro!
                    Saepe inventore voluptatum dolorum, quidem possimus soluta tenetur aliquam nihil expedita consectetur laudantium quia voluptates dicta rem ab modi impedit quaerat placeat quo incidunt sit tempora veniam odio quos. Optio.
                    Laboriosam amet omnis et ea, tempora quia similique hic debitis. Ex, distinctio illo in perferendis eos corporis! Hic quis, et beatae ullam maiores numquam natus, similique facere labore iste sequi.
                    Sapiente numquam corrupti aliquid culpa, quidem asperiores fugit quos nihil tempore ex veritatis a sed natus dicta ut doloremque totam possimus sint. Aperiam vero nostrum aspernatur doloremque voluptatem omnis est.
                    Totam nisi nam consequatur ut! Qui, iste vitae ex deleniti quaerat ullam nobis earum, eligendi aspernatur libero sunt! Vitae cumque odio illo nihil, aliquid molestias saepe quidem officiis praesentium placeat?
                    Ipsum accusamus fugiat ducimus voluptas ab, cum impedit laborum aspernatur fuga id harum? Sed magnam voluptatibus, hic veniam porro eligendi molestias quia fugit nulla optio, enim impedit quas, tempora cum.
                    Fuga officia est doloribus eum! Ab aperiam sequi itaque mollitia omnis debitis alias iure architecto possimus provident adipisci aspernatur deleniti vel unde impedit repellendus quaerat numquam, vero sed ipsa distinctio?
                    Nobis voluptatem sequi quae nemo ab voluptas enim doloremque est voluptates illo, vitae fuga provident natus iste ipsum vero recusandae repellat ea reprehenderit labore autem consequatur excepturi sit eum! Itaque.
                    Alias consequuntur nobis repellendus adipisci nihil numquam esse! Saepe, ipsam velit nihil nam ut incidunt qui itaque. Enim impedit sequi eaque eveniet, architecto temporibus quibusdam iste in. Fugit, harum dignissimos?
                    Expedita facilis aspernatur, facere corporis voluptatum praesentium voluptates quam amet nemo magnam doloremque temporibus dignissimos debitis ducimus. Porro rem nobis illo provident, possimus totam ut? Temporibus architecto blanditiis quo eligendi.
                    Similique quas assumenda ut, vero eum quo consectetur magnam ex saepe ducimus fugit doloremque illum laborum earum architecto necessitatibus odio illo corporis ratione, ad placeat repellendus porro atque distinctio? Numquam.
                </p>
                <a href="others.php" class="back-button">Back to Services</a>
            </article>

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