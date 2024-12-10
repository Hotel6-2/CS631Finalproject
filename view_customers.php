<?php include 'db_connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>View Customers</title>
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
    <h1>View Customers</h1>
    <a href="index.php" class="button">Home</a>

    <?php
    // Query to fetch customer details
    $sql = "SELECT 
                CSSN, 
                C_Fname, 
                C_MName, 
                C_LName, 
                C_Street, 
                C_Apt, 
                C_City, 
                C_State, 
                C_Zip, 
                C_Branch_ID, 
                Per_Bkr_SSN 
            FROM CUSTOMER";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo '<table>';
        echo '<tr>
                <th>CSSN</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Street</th>
                <th>Apt</th>
                <th>City</th>
                <th>State</th>
                <th>ZIP</th>
                <th>Branch ID</th>
                <th>Personal Banker SSN</th>
              </tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['CSSN'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['C_Fname'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['C_MName'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['C_LName'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['C_Street'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['C_Apt'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['C_City'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['C_State'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['C_Zip'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['C_Branch_ID'] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row['Per_Bkr_SSN'] ?? '') . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No customers found.</p>';
    }

    $conn->close();
    ?>
</body>
</html>
