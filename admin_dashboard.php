<?php include 'db_connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Banking System Administration</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
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
    <h1>Banking System Administration</h1>
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

    <br>
    <a href="index.php">Home</a>
</body>
</html>
