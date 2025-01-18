<?php
session_start();
include("db.php");

if (isset($_SESSION['useremail'])) {
    $userprofile = $_SESSION['useremail'];

    $note = $fullname = $email = $phone = $folder2 = $error = $success = "";

    // Fetch user details from the database
    $sql = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $sql->bind_param("s", $userprofile);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $fullname = $data["fullname"];
        $note = $data["note"];
        $email = $data["email"];
        $phone = $data["phone"];
        $existing_photo = isset($data["profilepic"]) ? $data["profilepic"] : ''; // Safely get the existing photo

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
            $fullname = $_POST["fullname"];
            $note = $_POST["note"];
            $phone = $_POST["phone"];

            $filename2 = $_FILES['photo']["name"];
            $tempname2 = $_FILES['photo']["tmp_name"];

            // Ensure images2 directory exists
            if (!file_exists('images2')) {
                mkdir('images2', 0777, true);
            }

            // Check if a new photo was uploaded
            if (!empty($filename2)) {
                $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
                $file_extension = strtolower(pathinfo($filename2, PATHINFO_EXTENSION));
                
                if (in_array($file_extension, $allowed_extensions) && $_FILES['photo']['size'] < 2000000) {
                    $folder2 = "images2/" . $filename2;
                    if (!move_uploaded_file($tempname2, $folder2)) {
                        $error = "Failed to upload the image.";
                    }
                } else {
                    $error = "Invalid file type or file too large.";
                }
            } else {
                // If no new photo is uploaded, retain the existing photo
                $folder2 = $existing_photo;
            }

            if (empty($error)) {
                $sql2 = $conn->prepare("UPDATE user SET fullname=?, phone=?, profilepic=?, note=? WHERE email=?");
                $sql2->bind_param("sssss", $fullname, $phone, $folder2, $note, $userprofile);

                if ($sql2->execute()) {
                    header("Location: mediator_profile.php?msg=Data updated successfully");
                    exit();
                } else {
                    $error = "There was an issue updating your profile. Please try again later.";
                }
            }
        }
    } else {
        $error = "No user data found.";
    }
} else {
    $error = "User email not set in session.";
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
    
    <script>
        function previewPhoto(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.createElement('img');
                output.src = reader.result;
                output.style.maxWidth = '200px';
                document.getElementById('photo-preview').innerHTML = '';
                document.getElementById('photo-preview').appendChild(output);
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" class="fw-bold">
    <div class="container-fluid">
        <a class="navbar-brand" href="mediator_dashboard.php">Alliance</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="mediator_dashboard.php">Home</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="col-lg-6 m-auto">
    <form action="#" method="post" enctype="multipart/form-data">
        <br><br><div class="card">
            <div class="card-header bg-warning">
                <h1 class="text-white text-center"> Update profile </h1>
            </div><br>
            <?php if ($error) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
            <label> NAME: </label>
            <input type="text" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" class="form-control"> <br>
            <label> PHONE: </label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>" class="form-control"> <br>
            
            <div>
                <label for="photo">Upload Photo:</label>
                <input type="file" id="photo" name="photo" accept="image/*" onchange="previewPhoto(event)">
                <div id="photo-preview" style="margin-top: 10px;">
                    <?php if (!empty($existing_photo)): ?>
                        <img src="<?php echo htmlspecialchars($existing_photo); ?>" style="max-width: 200px;">
                    <?php endif; ?>
                </div>
            </div>
            <button class="btn btn-success" type="submit" name="submit"> Submit </button><br>
            <a class="btn btn-info" type="submit" name="cancel" href="mediator_profile.php"> Cancel </a><br>
        </div>
    </form>
</div>
</body>
</html>
