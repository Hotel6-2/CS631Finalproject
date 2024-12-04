<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $CSSN = $_POST['CSSN'];
    $C_Fname = $_POST['C_Fname'];
    $C_Mname = $_POST['C_Mname'];
    $C_Lname = $_POST['C_Lname'];
    $C_Street = $_POST['C_Street'];
    $C_City = $_POST['C_City'];
    $C_State = $_POST['C_State'];
    $C_Zip = $_POST['C_Zip'];
    $C_Branch_ID = $_POST['C_Branch_ID'];

    $sql = "INSERT INTO CUSTOMER (CSSN, C_Fname, C_Mname, C_Lname, C_Street, C_City, C_State, C_Zip, C_Branch_ID)
            VALUES ('$CSSN', '$C_Fname', '$C_Mname', '$C_Lname', '$C_Street', '$C_City', '$C_State', '$C_Zip', '$C_Branch_ID')";

    if ($conn->query($sql) === TRUE) {
        echo "New customer added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Customer</title>
    <link rel="stylesheet" type="text/css" href="styles.css">\

    <script src="scripts.js"></script> <!-- Link to external JS file -->
</head>
<body>
    <h2>Add New Customer</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        SSN: <input type="text" name="CSSN" required><br><br>
        First Name: <input type="text" name="C_Fname" required><br><br>
        Middle Name: <input type="text" name="C_Mname"><br><br>
        Last Name: <input type="text" name="C_Lname" required><br><br>
        Street: <input type="text" name="C_Street" required><br><br>
        City: <input type="text" name="C_City" required><br><br>
        State: <input type="text" name="C_State" required><br><br>
        Zip: <input type="text" name="C_Zip" required><br><br>
        Branch ID: <input type="number" name="C_Branch_ID" required><br><br>
        <input type="submit" value="Add Customer">
    </form>
    <br>
    <a href="index.php">Back to Home</a>
</body>
</html>
