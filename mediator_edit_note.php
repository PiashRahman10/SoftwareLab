<?php
session_start();
include("db.php");

$error = "";

if (isset($_SESSION['useremail'])) {
    $userprofile = $_SESSION['useremail'];

    $note = $free = "";

    // Fetch user details from the database
    $sql = $conn->prepare("SELECT note, free FROM mediator WHERE email = ?");
    $sql->bind_param("s", $userprofile);
    $sql->execute();
    $result = $sql->get_result();

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $note = $data["note"];
        $free = $data["free"];

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
            $note = trim($_POST["note"]);
            $free = trim($_POST["free"]);

            // Validate inputs
            if (empty($note) || empty($free)) {
                $error = "Both Note and Available Time are required.";
            } else {
                $sql2 = $conn->prepare("UPDATE mediator SET free = ?, note = ? WHERE email = ?");
                $sql2->bind_param("sss", $free, $note, $userprofile);

                if ($sql2->execute()) {
                    header("Location: mediator_note.php?msg=Data updated successfully");
                    exit();
                } else {
                    $error = "Error updating your profile. Please try again later.";
                }
            }
        }
    } else {
        $error = "No user data found for the email: $userprofile";
    }
} else {
    $error = "User email is not set in the session. Please log in again.";
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<section class="header">
    <?php
    include("mediator_nav.php");
    ?>
    <div class="text-box">
        <h1>Edit personal and Professional Note</h1>
    </div>
</section>
<div class="col-lg-6 m-auto">
    <form action="" method="post">
        <br><br><div class="card">
            <div class="card-header bg-warning">
                <h1 class="text-white text-center">Update your Note</h1>
                
            </div><br>
            <?php if ($error) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
            <div class="form-group">
                <label>Note:</label>
                <textarea class="form-control border-1" rows="5" name="note"><?php echo htmlspecialchars($note); ?></textarea>
            </div>
            <div class="form-group">
                <label>Available Time for Work: <br><h6 style ='color : blue;'>Put your date in this given format (date month year)
                . example : <u><i >1 january 2025</i></u></h6></label>
                <textarea class="form-control border-1" rows="5" name="free"><?php echo htmlspecialchars($free); ?></textarea>
            </div>
            <button class="btn btn-success" type="submit" name="submit">Submit</button><br>
            <a class="btn btn-info" href="mediator_note.php">Cancel</a><br>
        </div>
    </form>
</div>
</body>
</html>
