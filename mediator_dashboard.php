<?php
session_start();
include("db.php");

if (isset($_SESSION['useremail'])) {
    $useremail = $_SESSION['useremail'];

    // Get the mediator id from the mediator table using the user's email
    $mediatorQuery = "
        SELECT mediator.id 
        FROM user 
        INNER JOIN mediator ON user.email = mediator.email 
        WHERE user.email = ?
    ";
    $mediatorStmt = $conn->prepare($mediatorQuery);
    $mediatorStmt->bind_param("s", $useremail);
    $mediatorStmt->execute();
    $mediatorResult = $mediatorStmt->get_result();
    $mediator = $mediatorResult->fetch_assoc();
    $mediator_id = $mediator['id'];

    // Fetch count of waiting and done cases
    $waitingQuery = "
        SELECT COUNT(*) AS waiting_cases 
        FROM mediation_proposal 
        WHERE mediator_id = ? AND status = 'waiting'
    ";
    $waitingStmt = $conn->prepare($waitingQuery);
    $waitingStmt->bind_param("i", $mediator_id);
    $waitingStmt->execute();
    $waitingResult = $waitingStmt->get_result();
    $waitingCases = $waitingResult->fetch_assoc()['waiting_cases'] ?? 0;

    $doneQuery = "
        SELECT COUNT(*) AS done_cases 
        FROM mediation_proposal 
        WHERE mediator_id = ? AND status = 'done'
    ";
    $doneStmt = $conn->prepare($doneQuery);
    $doneStmt->bind_param("i", $mediator_id);
    $doneStmt->execute();
    $doneResult = $doneStmt->get_result();
    $doneCases = $doneResult->fetch_assoc()['done_cases'] ?? 0;

    // Search and fetch case history
    $searchTerm = $_GET['search'] ?? '';
    $searchQuery = "
        SELECT mediation_proposal.* 
        FROM mediation_proposal 
        WHERE mediator_id = ? 
        AND (casenumber LIKE ? OR person1 LIKE ? OR person2 LIKE ? OR issues LIKE ? OR date LIKE ?)
        ORDER BY casenumber DESC
    ";
    $searchStmt = $conn->prepare($searchQuery);
    $searchParam = "%" . $searchTerm . "%";
    $searchStmt->bind_param("isssss", $mediator_id, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam);
    $searchStmt->execute();
    $searchResult = $searchStmt->get_result();

    $cases = [];
    while ($row = $searchResult->fetch_assoc()) {
        $cases[] = $row;
    }
} else {
    $error = "User email not set in session.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mediator Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #1E2A47;
            color: #fff;
            padding: 30px 0;
            text-align: center;
        }

        .header h1 {
            font-size: 40px;
            margin: 0;
            font-weight: 600;
        }

        .content {
            margin: 20px auto;
            max-width: 1200px;
            padding: 40px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .status-counts {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        /* Count box styles for a professional look */
        .status-counts .count-box {
            font-size: 24px;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            width: 49%;
            /* flex: 1; */
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            background-color: #f0f4f8;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .status-counts .done {
            background-color: #5cb85c;
            color: black;
        }

        .status-counts .done:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(92, 184, 92, 0.4);
        }

        .status-counts .waiting {
            background-color: #d9534f;
            color: black;
        }

        .status-counts .waiting:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(217, 83, 79, 0.4);
        }

        .search-bar {
            margin-bottom: 30px;
            text-align: right;
        }

        .search-bar input {
            width: 450px;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-bar button {
            margin-left: 10px;
            padding: 12px 20px;
            background-color: #1E2A47;
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .search-bar button:hover {
            background-color: #3b4c74;
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table th, .table td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #1E2A47;
            color: white;
            font-size: 16px;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table td {
            font-size: 14px;
        }

        .table .no-data {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }

        .dash-title {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        .footer p {
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>

    <div class="header">
        <?php include("mediator_nav.php"); ?>
        <h1>Mediator Dashboard</h1>
    </div>

    <div class="content">
        <div class="dash-title">
            <h2>My Cases Overview</h2>
            <hr>
        </div>

        <!-- Status Counts (Waiting and Done Cases) -->
        <div class="status-counts">
            <div class="count-box done">
                <strong>Total Done Cases:</strong>
                <p style='color:black; font-size : 30px; font-weight:700;'><b><?php echo $doneCases; ?></b></p>
            </div>
            <div class="count-box waiting">
                <strong>Total Waiting Cases:</strong>
                <p style='color:black; font-size : 30px; font-weight:700;'><?php echo $waitingCases; ?></p>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" id="searchInput" onkeyup="searchCases()" placeholder="Search by case number, plaintiff, defendant, issue, or date">
            <button class="btn btn-primary" onclick="searchCases()">Search</button>
        </div>

        <!-- Case History Table -->
        <div class="table-container">
            <table class="table table-striped table-hover case-history-table">
                <thead>
                    <tr>
                        <th>Case Number</th>
                        <th>Plaintiff Name</th>
                        <th>Defendant Name</th>
                        <th>Issue</th>
                        <th>Date</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cases)) : ?>
                        <?php foreach ($cases as $case) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($case['casenumber']); ?></td>
                                <td><?php echo htmlspecialchars($case['person1']); ?></td>
                                <td><?php echo htmlspecialchars($case['person2']); ?></td>
                                <td><?php echo htmlspecialchars($case['issues']); ?></td>
                                <td><?php echo htmlspecialchars($case['date']); ?></td>
                                <td><?php echo htmlspecialchars($case['result']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="no-data">No case history found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2025 Alliance Consultancy Firm. All rights reserved.</p>
    </div>

</body>
</html>
