<?php
session_start();
include("db.php");

// Check if session variable is set
if (isset($_SESSION['useremail'])) {
    $userprofile = $_SESSION['useremail'];

    // Query for user information
    $sql = "SELECT * FROM mediator WHERE email='$userprofile'";
    // $result = $conn->query($sql);
    // $queryx = "SELECT * FROM mediator WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);

}
// Close the database connection
//$conn->close();
?>

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
        <h1>Storing personal and Professional Note</h1>
    </div>
</section>
<div class="main-content">
    <div class="row">
        <div class="col-lg-8 " >
            <table>
                <th>
                    <h1>Personal Note</h1>
                    <hr>
                    <h4 style ='color : blue;'>Check your personal note if needed</h4>
                </th>
                <tr>
                    <td>
                        <?php echo $data['note']; ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-lg-4">
    <table>
        <th>
            <h1>Available Time</h1>
            <hr>
            <h4 style ='color : blue;'>see your Available time for work</h4>
        </th>
        <tr>
            <td>
                <?php 
                // Replace commas with line breaks
                echo nl2br(str_replace(',', "\n", htmlspecialchars($data['free']))); 
                ?>
            </td>
        </tr>
    </table>
</div>

    </div>
</div>


</body>