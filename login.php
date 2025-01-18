<?php 
session_start();
//include("Header.php"); 
$host = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'ADR';
$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);
if(isset($_POST['Login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT* From user WHERE email='$email' AND password='$password'"; 
    $result = $conn->query($sql);

    
    $sql2 = "SELECT* From user WHERE email='$email' AND password='$password' and status = 'mediator'"; 
    $result2 = $conn->query($sql2);

    $sql3 = "SELECT* From user WHERE email='$email' AND password='$password' and status = 'arbitrator'"; 
    $result3 = $conn->query($sql3);

   if($email=='admin@gmail.com' && $password=='admin'){
    header("Location: Admin.php");
   }
   else if ($result2->num_rows > 0) {
    $_SESSION['useremail']= $email;
    header("Location: mediator_dashboard.php");
    exit();
    
    } 

    else if ($result3->num_rows > 0) {
        $_SESSION['useremail']= $email;
        header("Location: arbitrator_dashboard.php");
        exit();
        
        } 
   
   else if ($result->num_rows > 0) {
    $_SESSION['useremail']= $email;
    header("Location: HomePage.php");
    
} else {
    echo '<script>
    window.location.href="Login.php"; 
    alert(" invalid username or password")
    </script>'; 
}
/*
    $result= mysqli_query($conn, $sql);
    $row= mysqli_fetch_array($result,MYSQLI_ASSOC); 
    $count = mysqli_num_rows($result);

    $sql2 = "SELECT* From lawyer WHERE email='$email' AND password='$password'"; 
    $result2= mysqli_query($conn, $sql2);
    $row2= mysqli_fetch_array($result2,MYSQLI_ASSOC); 
    $count2 = mysqli_num_rows($result2);
    if($count==1){
        
    }else if($count2==1){
        header("Location: Lawyer.php");
    }else{
        echo '<script>
        window.location.href="Login.php"; 
        alert("invalid username or password")
        </script>'; 
    }
  */ 
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="Login.css">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css' rel='stylesheet'>
    
</head>
<body>
    <div class="wrapper">
    <form action="" method="POST">
    <h1>Login</h1>
    <div class="input-box">
    <input type="text" placeholder="Email" name="email" required>
    <i class="fa-regular fa-user"></i>
    </div>
    <div class="input-box">
    <input type="password" placeholder="Password"  name="password" required>
    <i class="fa-solid fa-lock"></i>
    </div>
    <div class="remember-forgot">
    <label><input type="checkbox">Remember Me</label>
    <a href="#">Forgot Password</a>
    </div>
    <button type="submit" class="btn" name="Login">Login</button>
    <div class="register-link">
    <p>Don't have an account?<a href="Client_Register.php"> Register </a></p>

    </div>
    </form>
    </div>

</body>
</html>