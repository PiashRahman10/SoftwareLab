<?php
$host = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'adr';
$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    // Fetch the post based on the post_id (assuming 'community' table contains posts)
    $sql_post = "SELECT * FROM community WHERE id = ?";
    $stmt_post = $conn->prepare($sql_post);
    $stmt_post->bind_param("i", $post_id); // Bind the post_id parameter
    $stmt_post->execute();
    $result_post = $stmt_post->get_result();

    if ($result_post->num_rows > 0) {
        $post = $result_post->fetch_assoc();
        
        // Fetch all comments for this post
        $sql_comments = "SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC";
        $stmt_comments = $conn->prepare($sql_comments);
        $stmt_comments->bind_param("i", $post_id); // Bind the post_id parameter
        $stmt_comments->execute();
        $result_comments = $stmt_comments->get_result();

        // Check if there are any comments for this post
        if ($result_comments->num_rows > 0) {
            echo "<h2>Comments:</h2>";
            while ($comment = $result_comments->fetch_assoc()) {
                $email = $comment['email']; 

                // Use prepared statement for the user query
                $sql2 = "SELECT * FROM user WHERE email = ?";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->bind_param("s", $email); // Bind the email parameter as string
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                $row2 = $result2->fetch_assoc(); 
                
                // Display each comment in a box
                echo "<div style='border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;'>";
                echo "<p><strong>" . htmlspecialchars($row2['fullname']) . ":</strong> " . htmlspecialchars($comment['comment_text']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No comments yet.</p>";
        }

    } else {
        echo "Post not found.";
    }
} else {
    echo "No post ID specified.";
}

mysqli_close($conn);
?>
