<?php
// Include required PHPMailer files
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Define namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mediation Verification</title>

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

        input[type="text"],
        textarea {
            padding: 8px;
            width: 80%;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #0077cc;
            outline: none;
        }

        @media (max-width: 768px) {
            .table-box table th,
            .table-box table td {
                font-size: 16px;
                padding: 10px;
            }

            input[type="text"],
            textarea {
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
        function validateForm(event) {
            const action = event.submitter.name; // Determines which button was clicked
            const form = event.target;
            const feedback = form["feedback"].value;

            if (action === 'accept') {
                const mediatorId = form["mediator_id"].value;
                const link = form["link"].value;
                if (!mediatorId || !link || !feedback) {
                    alert("Mediator ID, Meet link, and Feedback are required for acceptance.");
                    return false;
                }
            } else if (action === 'reject' && !feedback) {
                alert("Feedback is required for rejection.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
<section class="header">
    <?php include("admin_navbar.php"); ?>
    
    <div class="text-box">
        <h1>Mediation Case File Proposal</h1>
    </div>
</section>
<div class="container">
    <h2>Mediation Verification</h2>
    <div class="table-box">
        <table>
            <tr>
                <th>Case Number</th>
                <th>Person One</th>
                <th>Person Two</th>
                <th>Issue</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            <?php
            include("db.php");

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['accept'])) {
                    $email1 = $_POST['accept'];
                    $mediator_id = $_POST['mediator_id'];
                    $link = $_POST['link'];
                    $feedback = $_POST['feedback'];

                    $update_sql = "UPDATE mediation_proposal 
                                   SET status='done', link='$link', mediator_id='$mediator_id', feedback='$feedback' 
                                   WHERE email1='$email1'";
                    $conn->query($update_sql);

                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
                    $mail->Username = 'dbmsprojectalfha@gmail.com';
                    $mail->Password = 'zofk eqxk oqvy xnpu';
                    $mail->setFrom('dbmsprojectalfha@gmail.com', 'Alliance');
                    $mail->isHTML(true);
                    $mail->Subject = 'Mediation Consultancy Link';
                    $mail->Body = 'Mediation Link: ' . $link . '<br>Mediator ID: ' . $mediator_id;
                    $mail->addCC($email1);
                    $mail->send();
                }

                if (isset($_POST['reject'])) {
                    $email1 = $_POST['reject'];
                    $feedback = $_POST['feedback'];

                    $update_sql = "UPDATE mediation_proposal 
                                   SET status='no', feedback='$feedback' 
                                   WHERE email1='$email1'";
                    $conn->query($update_sql);
                }
            }

            // $sql = "SELECT mec.casenumber, mep.email1, mep.email2, mep.date, mep.issues 
            //         FROM mediation_proposal AS mep 
            //         JOIN mediation_case AS mec ON mec.casenumber = mep.casenumber 
            //         WHERE mep.status ='pending'";
            // $result = $conn->query($sql);
            $sql = "SELECT * FROM mediation_proposal WHERE status ='pending'";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['casenumber'] . "</td>";
                echo "<td>" . $row['email1'] . "</td>";
                echo "<td>" . $row['email2'] . "</td>";
                echo "<td>" . $row['issues'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>
                        <form method='post' onsubmit='return validateForm(event)'>
                            <textarea name='feedback' placeholder='Enter feedback...' required></textarea>
                            <input type='text' name='mediator_id' placeholder='Mediator ID'>
                            <input type='text' name='link' placeholder='Meet link'>
                            <button type='submit' class='accept-btn' name='accept' value='" . $row['casenumber'] . "'>Accept</button>
                            <button type='submit' class='reject-btn' name='reject' value='" . $row['casenumber'] . "'>Reject</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</div>
</body>
</html>
