<?php include 'db_connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Portal</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Include a CSS file for styling -->
    <style>
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
    <h1>Employee Portal</h1>
    <a href="view_employees.php">View Employees</a><br>
    <a href="add_employees.php">Manage Employees</a><br>
    <a href="view_customers.php">View Customers</a><br>
    <a href="add_customer.php">Manage Customers</a><br>
    <a href="view_Branches.php">View Branches</a><br>
    <a href="add_branch.php">Manage Branches</a><br>
    <a href="view_Accounts.php">View Accounts</a><br>
    <a href="add_account.php">Manage Accounts</a><br>
    <br>

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

        $sql = "SELECT COUNT(*) AS NUM_ACCTS, H.CSSN, SUM(AC.ACC_BAL) AS TOTAL_BALANCE
                FROM HELD_BY H 
                JOIN ACCOUNT AC ON H.ACC_NUM = AC.ACC_NUM
                WHERE AC.ACC_BAL > ?
                GROUP BY H.CSSN
                HAVING COUNT(*) > ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $balance, $num_accounts);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<table><tr><th>CSSN</th><th>Number of Accounts</th><th>Total Balance</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr><td>' . htmlspecialchars($row['CSSN']) . '</td>';
                echo '<td>' . htmlspecialchars($row['NUM_ACCTS']) . '</td>';
                echo '<td>$' . htmlspecialchars(number_format($row['TOTAL_BALANCE'], 2)) . '</td></tr>';
            }
            echo '</table>';
        } else {
            echo '<p>No customers meet the criteria.</p>';
        }
        $stmt->close();
    }
    ?>

    <br>
    <a href="index.php">Home</a> <!-- Added Home button -->
</body>
</html>

