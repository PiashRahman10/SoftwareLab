<?php
session_start();
if (isset($_SESSION['useremail']) && isset($_POST['post_id'])) {
    $user_email = $_SESSION['useremail'];
    $post_id = $_POST['post_id'];

    // Establish connection to the database
    $conn = mysqli_connect('localhost', 'root', '', 'adr');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Insert like if it doesn't already exist
    $sql = "SELECT * FROM likes WHERE post_id = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $post_id, $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // No previous like, insert new like
        $insert_sql = "INSERT INTO likes (post_id, email) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("is", $post_id, $user_email);
        $insert_stmt->execute();
    }

    $conn->close();
    header("Location: query.php"); // Redirect back to the posts page
}
?>
