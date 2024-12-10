<?php include 'db_connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Banking System Administration</title>
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
        <a href="view_employees.php" class="button">View Employees</a>
        <a href="add_employees.php" class="button">Manage Employees</a>
        <a href="view_customers.php" class="button">View Customers</a>
        <a href="add_customer.php" class="button">Manage Customers</a>
        <a href="view_branches.php" class="button">View Branches</a>
        <a href="add_branch.php" class="button">Manage Branches</a>
        <a href="view_accounts.php" class="button">View Accounts</a>
        <a href="add_account.php" class="button">Manage Accounts</a>
        <a href="index.php" id="home-button" class="button">Home</a>
    </div>

    <div class="content">
        <h1>Banking System Administration</h1>
        <form method="post" action="">
            <label for="employee_name">Enter Employee First Name:</label>
            <input type="text" id="employee_name" name="employee_name" required>
            <button type="submit" name="view_dependents" class="button">View Dependents</button>
        </form>

        <?php
        if (isset($_POST['view_dependents'])) {
            $employee_name = $_POST['employee_name'];

            // Query to retrieve dependents for the entered employee name
            $sql = "SELECT D_FName AS 'Dependent First Name', D_LName AS 'Dependent Last Name'
                    FROM DEPENDENT
                    WHERE ESSN IN (
                        SELECT SSN
                        FROM EMPLOYEES
                        WHERE E_FName = ?
                    )";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $employee_name);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                echo '<table>';
                echo '<tr><th>Dependent First Name</th><th>Dependent Last Name</th></tr>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['Dependent First Name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['Dependent Last Name']) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p>No dependents found for ' . htmlspecialchars($employee_name) . '.</p>';
            }

            $stmt->close();
        }
        ?>
    </div>
</body>
</html>
