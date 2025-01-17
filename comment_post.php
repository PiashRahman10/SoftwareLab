<?php
session_start();

// Establish connection to the database at the beginning
$conn = mysqli_connect('localhost', 'root', '', 'adr');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if necessary POST variables are set
if (isset($_SESSION['useremail']) && isset($_POST['post_id']) && isset($_POST['comment_text'])) {
    // Get the data from the session and the form
    $user_email = $_SESSION['useremail'];
    $post_id = $_POST['post_id'];
    $comment_text = $_POST['comment_text'];

    // Sanitize the comment text to prevent SQL injection
    $comment_text = mysqli_real_escape_string($conn, $comment_text);

    // Prepare the SQL statement to insert the comment
    $sql = "INSERT INTO comments (post_id, email, comment_text) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iss", $post_id, $user_email, $comment_text);
        
        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the query page after success
            header("Location: query.php");
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Failed to prepare the statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();
} else {
    echo "Some required fields are missing.";
}
?>
