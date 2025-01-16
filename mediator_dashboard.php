<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alliance Consultancy Firm</title>
    <link rel="stylesheet" href="index2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<section class="header">
    <?php
    include("mediator_nav.php");
    ?>
    
    <div class="text-box">
        <h1>Mediator Dashboard</h1>
    </div>
</section>
<!-- MEDIATION SECTION---->
    <section class="facilities">
        <h1> Our Mediator Dashboard</h1>
        <p>description if needed</p>
        <div class="row">
            <div class="facilities-col">
                <a href="mediator_profile.php">
                    <img src="mediationForm.jpg" alt="">
                    <h3>My Profile</h3>
                    <p>serve as mediator</p>
                </a>
                
            </div>
            <div class="facilities-col">
                <a href="mediator_activity.php">
                    <img src="mediationProposal.jpg" alt="">
                <h3>My Service</h3>
                <p>My all activity or case list</p>
                </a>
                
            </div>

            
        </div>
    </section>
    
    <?php //include("footer.php"); ?>
</body>
</html>