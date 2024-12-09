<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ? AND user_type = ?");
    $stmt->bind_param("sss", $username, $password, $user_type);
    
    // Execute and check results
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Login successful, store user info in session
        $_SESSION['username'] = $username;
        $_SESSION['user_type'] = $user_type;
        
        // Redirect based on user type
        if ($user_type == 'customer') {
            header("Location: customer_dashboard.php");
        } elseif ($user_type == 'employee') {
            header("Location: employee_dashboard.php");
        } elseif ($user_type == 'administrator') {
            header("Location: admin_dashboard.php");
        }
        exit();
    } else {
        $error = "Invalid username, password, or user type";
    }
    
    $stmt->close();
}
$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Banking System - Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            background-color: #4a90e2; /* Blue color to match the logo */
            font-family: Arial, sans-serif;
        }
        .logo {
            width: 300px;
            margin: 20px auto;
            text-align: center;
        }
        input[type="text"], input[type="password"], select {
            width: 300px;
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
<body>
    <h1>Bankify, modern money, reimagined</h1>
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <label for="user_type">User Type:</label>
        <select id="user_type" name="user_type" required>
            <option value="customer">Customer</option>
            <option value="employee">Employee</option>
            <option value="administrator">Administrator</option>
        </select><br><br>
        
        <input type="submit" value="Login">
    </form>
    
    <?php
    if (isset($error)) {
        echo "<p style='color:red;'>$error</p>";
    }
    
    ?>
        <div class="logo">
        <img src="bankify.png" alt="Bankify Logo" width="300">
    </div>

    <br>
    <a href="index.php">Home</a>
</body>
</html>
