<?php include 'db_connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>View Branches and Locations</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
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
    <h1>Branches and Their Locations</h1>
    <a href="index.php" class="button">Home</a>

    <?php
    // Query to join BRANCH and BRANCH_LOCATION tables
    $sql = "SELECT 
                B.Branch_ID,
                B.Branch_Name,
                B.Assets,
                L.B_Street,
                L.B_City,
                L.B_State,
                L.B_Zip
            FROM BRANCH B
            JOIN BRANCH_LOCATION L ON B.Branch_ID = L.Branch_ID";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo '<table>';
        echo '<tr>
                <th>Branch ID</th>
                <th>Branch Name</th>
                <th>Assets</th>
                <th>Street</th>
                <th>City</th>
                <th>State</th>
                <th>ZIP Code</th>
              </tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['Branch_ID']) . '</td>';
            echo '<td>' . htmlspecialchars($row['Branch_Name']) . '</td>';
            echo '<td>$' . htmlspecialchars(number_format($row['Assets'], 2)) . '</td>';
            echo '<td>' . htmlspecialchars($row['B_Street']) . '</td>';
            echo '<td>' . htmlspecialchars($row['B_City']) . '</td>';
            echo '<td>' . htmlspecialchars($row['B_State']) . '</td>';
            echo '<td>' . htmlspecialchars($row['B_Zip']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No branches found.</p>';
    }

    $conn->close();
    ?>
</body>
</html>
