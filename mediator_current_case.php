<?php
session_start();
include("db.php");

if (isset($_SESSION['useremail'])) {
    $useremail = $_SESSION['useremail'];

    // Fetch mediation proposals with status "waiting" based on the mediator's email
    $query = "
        SELECT 
            mediation_proposal.*
        FROM 
            user 
        INNER JOIN 
            mediator ON user.email = mediator.email 
        INNER JOIN 
            mediation_proposal ON mediator.id = mediation_proposal.mediator_id 
        WHERE 
            user.email = ? AND mediation_proposal.status = 'waiting'
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $useremail);
    $stmt->execute();
    $result = $stmt->get_result();

    // Prepare data for display
    $proposals = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $proposals[] = $row;
        }
    } else {
        $error = "No mediation proposals found where you are assigned";
    }

    // Handle "Done" button action
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['done'])) {
        $casenumber = $_POST['casenumber'];
        $verdict = $_POST['verdict'];

        if (!empty($verdict)) {
            $updateQuery = "UPDATE mediation_proposal SET status = 'done', result = ? WHERE casenumber = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ss", $verdict, $casenumber);

            if ($updateStmt->execute()) {
                header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page
                exit();
            } else {
                $error = "Failed to update the proposal. Please try again.";
            }
        } else {
            $error = "Please enter a verdict before marking as done.";
        }
    }
} else {
    $error = "User email not set in session.";
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mediation Proposals</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        textarea {
            height: 200px;
            width: 350px;
        }
    </style>
    <link rel="stylesheet" href="index2.css">
</head>
<body>
<section class="header">
    <?php
    include("mediator_nav.php");
    ?>
    
    <div class="text-box">
        <h1>My Current Pending Case</h1>
    </div>
</section>
<div class="container mt-4">
    <h1 class="text-center text-primary">Your Pending Mediation Case</h1>
    <?php if (isset($error)) : ?>
        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php else : ?>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Case Number</th>
                    <th>Plaintiff Name</th>
                    <th>Defendant Name</th>
                    <th>Issue</th>
                    <th>Date</th>
                    <th>Link</th>
                    <th>Verdict</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proposals as $proposal) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($proposal['casenumber']); ?></td>
                        <td><?php echo htmlspecialchars($proposal['person1']); ?></td>
                        <td><?php echo htmlspecialchars($proposal['person2']); ?></td>
                        <td><?php echo htmlspecialchars($proposal['issues']); ?></td>
                        <td><?php echo htmlspecialchars($proposal['date']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($proposal['link']); ?>" target="_blank">View Link</a></td>
                        <td>
                            <form method="post" action="">
                                <textarea name="verdict" class="form-control" placeholder="Enter verdict" required></textarea>
                        </td>
                        <td>
                                <input type="hidden" name="casenumber" value="<?php echo htmlspecialchars($proposal['casenumber']); ?>">
                                <button type="submit" name="done" class="btn btn-success btn-sm">Done</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
