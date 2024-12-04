<?php
include 'db_connection.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Employees</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Employee List</h2>
    <table border="1">
        <tr>
            <th>SSN</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Phone</th>
            <th>Start Date</th>
            <th>Branch ID</th>
        </tr>
        <?php
        $sql = "SELECT * FROM EMPLOYEES";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row["SSN"]."</td>
                        <td>".$row["E_FName"]."</td>
                        <td>".$row["E_MName"]."</td>
                        <td>".$row["E_LName"]."</td>
                        <td>".$row["Phone"]."</td>
                        <td>".$row["Start_Date"]."</td>
                        <td>".$row["BRANCH_ID"]."</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No employees found</td></tr>";
        }

        $conn->close();
        ?>
    </table>
    <br>
    <a href="index.php">Back to Home</a>
</body>
</html>
