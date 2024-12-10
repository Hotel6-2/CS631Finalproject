<?php include 'db_connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: row;
            margin: 20px;
            background-color: #f4f4f9;
        }
        .sidebar {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-right: 20px;
        }
        .button {
            display: block;
            background-color: #4a90e2;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            width: 200px;
        }
        .button:hover {
            background-color: #357ab7;
        }
        .content {
            flex: 1;
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
        #home-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="add_customer.php" class="button">Manage Customer</a>
        <a href="view_branches.php" class="button">View Branches</a>
        <a href="view_accounts.php" class="button">View Accounts</a>
        <a href="add_account.php" class="button">Manage Accounts</a>
        <a href="index.php" id="home-button" class="button">Home</a>
    </div>

    <div class="content">
        <h1>Customer Dashboard</h1>
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
    </div>
</body>
</html>
