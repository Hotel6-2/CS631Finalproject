<?php include 'db_connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
        }
        .button {
            background-color: #4a90e2;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #357ab7;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #4a90e2;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Customer Dashboard</h1>
    <a href="add_customer.php">Manage Customer</a><br>
    <a href="view_Branches.php">View Branches</a><br>
    <a href="view_Accounts.php">View Accounts</a><br>
    <a href="add_account.php">Manage Accounts</a><br>
    <br>

    <form method="post" action="">
        <button type="submit" name="view_transactions" class="button">View Transaction Counts by Account</button>
    </form>

    <?php
    if (isset($_POST['view_transactions'])) {
        // Query to fetch transaction counts by account
        $sql = "SELECT Acc_Num, COUNT(Transact_Code) AS Transaction_Count 
                FROM TRANSACT
                GROUP BY Acc_Num
                ORDER BY Acc_Num";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Account Number</th><th>Transaction Count</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['Acc_Num']) . '</td>';
                echo '<td>' . htmlspecialchars($row['Transaction_Count']) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No transactions found or query failed.</p>';
        }
    }
    ?>

    <br>
    <a href="index.php">Home</a>
</body>
</html>
