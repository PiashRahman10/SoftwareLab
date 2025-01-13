

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alliance</title>

    <style>
        /* Resetting styles */
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .table-box {
            width: 100%;
            padding: 20px;
        }

        .table-box table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-box table th,
        .table-box table td {
            border: 1px solid #e0e0e0;
            padding: 15px;
            font-size: 18px;
            text-align: center;
        }

        .table-box table th {
            background-color: #0077cc;
            color: white;
            font-size: 20px;
        }

        .table-box table td {
            background-color: #fafafa;
        }

        .accept-btn,
        .reject-btn {
            padding: 10px 15px;
            margin-right: 5px;
            background-color: #4CAF50;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .accept-btn:hover {
            background-color: #45a049;
        }

        .reject-btn {
            background-color: #f44336;
        }

        .reject-btn:hover {
            background-color: #e03131;
        }

        /* Styling the input field for the link */
        input[type="text"] {
            padding: 8px;
            width: 80%;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #0077cc;
            outline: none;
        }

        /* Add some responsive design */
        @media (max-width: 768px) {
            .table-box table th,
            .table-box table td {
                font-size: 16px;
                padding: 10px;
            }

            input[type="text"] {
                width: 100%;
            }

            .accept-btn,
            .reject-btn {
                padding: 8px 10px;
                font-size: 14px;
            }
        }
    </style>

    <script>
        // JavaScript to ensure 'mediator_id' and 'link' fields are required only for 'accept' button
        function validateForm(event) {
            const action = event.submitter.name; // Check which button was clicked
            if (action === 'accept') {
                const arbitratorId = document.forms["arbitrationForm"]["arbitrator_id"].value;
                const link = document.forms["arbitrationForm"]["link"].value;

                if (arbitratorId === "" || link === "") {
                    alert("Arbitrator ID and Meet link are required.");
                    return false;
                }
            }
            return true;
        }
    </script>
</head>
<body>
<section class="header">
    <?php include("admin_navbar.php"); ?>
    
    <div class="text-box">
        <h1>Arbitration case file proposal</h1>
    </div>
</section>
<div class="container">
    <h2>Arbitration Verification</h2>
    <div class="table-box">
        <table border="1">
            <tr>
                <th>Case Number</th>
                <th>Issues</th>
                <th>Plaintiff</th>
                <th>Defendant</th>
                <!-- <th>Mediator ID</th> -->
                <th>Action</th>
            </tr>
            <!-- PHP code to fetch data from the database -->
            <?php
            // Connect to your database
            $host = 'localhost';
            $dbuser = 'root';
            $dbpass = '';
            $dbname = 'adr';
            $conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // If accept button is clicked
            if (isset($_POST['accept'])) {
                if (!empty($_POST['arbitrator_id']) && !empty($_POST['link'])) {
                    $email1 = $_POST['accept'];
                    $link = $_POST['link'];
                    $arbitrator_id = $_POST['arbitrator_id']; // Fetch mediator ID

                    // Update the status in the database to 'done'
                    $update_sql = "UPDATE arbitration_proposal SET status='done', link='$link', arbitrator_id='$arbitrator_id' WHERE email1='$email1'";
                    if ($conn->query($update_sql) === TRUE) {
                        echo "Record updated successfully";
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }

                } 
            }

            // If reject button is clicked
            if (isset($_POST['reject'])) {
                $email1 = $_POST['reject'];
                $update_sql = "UPDATE arbitration_proposal SET status='no' WHERE email1='$email1'";
                if ($conn->query($update_sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            }

            //SQL query to select data from the table
            $sql = "SELECT ac.casenumber, ap.email1, ap.email2,ap.issues 
                    FROM arbitration_proposal AS ap
                    JOIN arbitration_case AS ac 
                    ON ac.casenumber = ap.casenumber
                    WHERE ap.status ='pending'";
            $result = $conn->query($sql);
            // $sql = "SELECT * FROM mediation_proposal WHERE status ='pending'";
            // $result = $conn->query($sql);
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['casenumber'] . "</td>";
                echo "<td>" . $row['issues'] . "</td>";
                echo "<td>" . $row['email1'] . "</td>";
                echo "<td>" . $row['email2'] . "</td>";
                // echo "<td>
                // <form name='mediationForm' method='post' onsubmit='return validateForm(event)'>
                //         <input type='text' name='mediator_id' placeholder='Mediator ID'>
                //         </form>
                //       </td>";
                echo "<td>
                        <form name='arbitrationForm' method='post' onsubmit='return validateForm(event)'>
                        <input type='text' name='arbitrator_id' placeholder='Arbitrator ID'>
                            <input type='text' name='link' placeholder='Meet link'><br>
                            <button type='submit' class='accept-btn' name='accept' value='" . $row['email1'] . "'>Accept</button>
                            <button type='submit' class='reject-btn' name='reject' value='" . $row['email1'] . "'>Reject</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            $conn->close();
            ?>
            <!-- End of PHP code -->
        </table>
    </div>
</div>
</body>
</html>
