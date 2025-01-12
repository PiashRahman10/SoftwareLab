<?php 
// include("header.php"); 
session_start();
include("db.php");
if(isset($_POST['cl_button']))
{
    $fullname = $_POST['cl_fullname'];
    $email = $_POST['cl_email'];
    $password = $_POST['cl_password'];
    $PhoneNumber=$_POST['cl_phone_number'];
    
    $sql = "SELECT* From user WHERE email='$email' "; 
    $result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<script>
    window.location.href="Client_Register.php"; 
    alert("This user already exist. Enter another email")
    </script>'; 
} else {
    $sqlwrite = "INSERT INTO user(fullname, email,password,phone,profilepic,status) values ('$fullname', '$email', '$password','$PhoneNumber','default_user.png','user')";
       mysqli_query($conn, $sqlwrite);
       $_SESSION['useremail'] = $email;
        header("Location: HomePage.php");

}
   
    // $sql= "SELECT* From client WHERE Email='$email' "; 
    // $result = $conn->query($sql);
    // if ($result->num_rows > 0) {
    //     echo '<script>
    //     window.location.href="Client_Register.php"; 
    //     alert("This Email already exist. Plese use another Email ID")
    //     </script>'; 
    // }else{
    //     $sql2 = "INSERT INTO client(UserName, Email,Password,Phone) values ('$username', '$email', '$password','$PhoneNumber')";
    //     mysqli_query($conn, $sql2);
    //     header("Location: HomePage.php");
    // }
   
   
    
    
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="Client_Register.css">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css' rel='stylesheet'>

</head>
<body>
    <div class="wrapper">
        <form action="#" method="POST">
            <h1>Register AS Client</h1>
           
            <div class="input-box">
                <input name="cl_fullname"  type="text" placeholder="Fullname" required>
                <i class="fa-regular fa-user"></i>
            </div>
            <div class="input-box">
                <input  name="cl_email"  type="email" placeholder="Email" required>
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div  class="input-box">
                <input  name="cl_password" type="password" placeholder="Password" required>
                <i class="fa-solid fa-lock"></i>
            </div>
            <div class="input-box">
                <input name="cl_phone_number"  type="tel" placeholder="Phone number" required>
                <i class="fa-solid fa-phone"></i>
            </div>
                <button name="cl_button" type="submit" class="btn">Register</button>
                <div class="register-link">
            </div>
            <div class="register-link">
                <p>Already have an account? <a href="Login.php">Login</a></p>
                </div>
        </form>
    </div>

</body>
</html>