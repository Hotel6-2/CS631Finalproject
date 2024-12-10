<?php include 'db_connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Portal</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: row;
            margin: 20px;
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
        form {
            margin-top: 20px;
        }
        #home-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="view_employees.php" class="button">View Employees</a>
        <a href="add_employees.php" class="button">Manage Employees</a>
        <a href="view_customers.php" class="button">View Customers</a>
        <a href="add_customer.php" class="button">Manage Customers</a>
        <a href="view_branches.php" class="button">View Branches</a>
       <!-- <a href="add_branch.php" class="button">Manage Branches</a> -->
        <a href="view_accounts.php" class="button">View Accounts</a>
        <!-- <a href="add_account.php" class="button">Manage Accounts</a> -->
        <a href="index.php" id="home-button" class="button">Home</a>
    </div>

    <div class="content">
        <h1>Employee Portal</h1>
        <h2>High Balance Customers Query</h2>
        <form method="post" action="">
            <label for="balance">Minimum Account Balance:</label>
            <input type="number" id="balance" name="balance" value="500" required step="0.01"><br><br>

            <label for="num_accounts">Minimum Number of Accounts:</label>
            <input type="number" id="num_accounts" name="num_accounts" value="2" required><br><br>

            <button type="submit" class="button">View High Balance Customers</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $balance = floatval($_POST['balance']);
            $num_accounts = intval($_POST['num_accounts']);

            //echo "<p>Debug: Minimum Balance = $balance, Minimum Accounts = $num_accounts</p>";

            // SQL Query
            $sql = "SELECT COUNT(*) AS NUM_ACCTS, H.CSSN, SUM(A.Acc_Bal) AS TOTAL_BALANCE
                    FROM HELD_BY H
                    JOIN ACCOUNT A ON H.Acc_Num = A.Acc_Num
                    WHERE A.Acc_Bal > ?
                    GROUP BY H.CSSN
                    HAVING COUNT(*) > ?";

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("SQL preparation failed: " . $conn->error);
            }

            $stmt->bind_param("di", $balance, $num_accounts);

            if (!$stmt->execute()) {
                die("SQL execution failed: " . $stmt->error);
            }

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<table><tr><th>Customer SSN</th><th>Number of Accounts</th><th>Total Balance</th></tr>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['CSSN']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['NUM_ACCTS']) . '</td>';
                    echo '<td>$' . number_format($row['TOTAL_BALANCE'], 2) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p>No customers meet the criteria.</p>';
            }

            $stmt->close();
        }
        ?>
    </div>
</body>
</html>

