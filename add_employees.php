<?php include 'db_connection.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Employee</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }
        form {
            max-width: 500px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .button {
            background-color: #4a90e2;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #357ab7;
        }
        .message {
            margin-top: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h1>Add New Employee</h1>
    <a href="index.php" class="button">Home</a> <!-- Return to Home Button -->
    <form method="post" action="">
        <label for="ssn">Social Security Number (SSN):</label>
        <input type="text" id="ssn" name="ssn" maxlength="11" required>

        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" required>

        <label for="mname">Middle Name:</label>
        <input type="text" id="mname" name="mname">

        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname" required>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" maxlength="15" required>

        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>

        <label for="branch_id">Branch ID:</label>
        <input type="text" id="branch_id" name="branch_id">

        <button type="submit" class="button">Add Employee</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $ssn = $_POST['ssn'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $phone = $_POST['phone'];
        $start_date = $_POST['start_date'];
        $branch_id = empty($_POST['branch_id']) ? null : $_POST['branch_id'];

        $sql = "INSERT INTO EMPLOYEES (SSN, E_FName, E_MName, E_LName, Phone, Start_Date, BRANCH_ID) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $ssn, $fname, $mname, $lname, $phone, $start_date, $branch_id);

        if ($stmt->execute()) {
            echo '<p class="message" style="color: green;">Employee added successfully!</p>';
        } else {
            echo '<p class="message" style="color: red;">Error: ' . $conn->error . '</p>';
        }

        $stmt->close();
    }

    $conn->close();
    ?>
</body>
</html>
