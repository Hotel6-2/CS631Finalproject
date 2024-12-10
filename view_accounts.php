<?php include 'db_connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>View Accounts</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
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
        .button {
            background-color: #4a90e2;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .button:hover {
            background-color: #357ab7;
        }
    </style>
</head>
<body>
    <h1>View Accounts</h1>
    <a href="index.php" class="button">Home</a>

    <?php
    // Query to fetch account details
    $sql = "
        SELECT 
            A.Acc_Num, 
            A.Acc_Type, 
            A.Acc_Bal, 
            A.Last_Access_Date,
            S.Fix_Sav_Rate,
            C.Overdraft_Fee,
            MM.Var_MM_Rate,
            L.Fix_Loan_Rate,
            L.Monthly_Loan_Payment,
            L.Loaned_Amount
        FROM 
            ACCOUNT A
        LEFT JOIN SAVINGS S ON A.Acc_Num = S.Acc_Num
        LEFT JOIN CHECKING C ON A.Acc_Num = C.Acc_Num
        LEFT JOIN MONEY_MARKET MM ON A.Acc_Num = MM.Acc_Num
        LEFT JOIN LOAN L ON A.Acc_Num = L.Acc_Num
        ORDER BY A.Acc_Num;
    ";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo '<table>';
        echo '<tr>
                <th>Account Number</th>
                <th>Account Type</th>
                <th>Balance</th>
                <th>Last Access Date</th>
                <th>Savings Rate</th>
                <th>Overdraft Fee</th>
                <th>Money Market Rate</th>
                <th>Loan Rate</th>
                <th>Monthly Loan Payment</th>
                <th>Loan Amount</th>
              </tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['Acc_Num'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['Acc_Type'] ?? '') . '</td>';
            echo '<td>$' . htmlspecialchars(number_format($row['Acc_Bal'] ?? 0, 2)) . '</td>';
            echo '<td>' . htmlspecialchars($row['Last_Access_Date'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['Fix_Sav_Rate'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['Overdraft_Fee'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['Var_MM_Rate'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['Fix_Loan_Rate'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['Monthly_Loan_Payment'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['Loaned_Amount'] ?? '') . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No accounts found.</p>';
    }

    $conn->close();
    ?>
</body>
</html>
