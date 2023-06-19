<!DOCTYPE html>
<html>
<head>
    <title>Money Transfer - Customer Details</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>View Customer Details <img src=" images/cus.png"></h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="customers.php">View All Customers</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="transaction_history.php">Transaction History</a></li>
        </ul>
    </nav>
    <main>
        <?php
        if (isset($_GET["id"])) {
            $customer_id = $_GET["id"];
            
            // Database connection
            $conn = new mysqli('localhost', 'root', '', 'money_transfer');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            // Fetch customer details from the database
            $sql = "SELECT * FROM customers WHERE id = $customer_id";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<h2>Customer Details</h2>";
                echo "<p><strong>Name:</strong> " . $row["name"] . "</p>";
                echo "<p><strong>Email:</strong> " . $row["email"] . "</p>";
                echo "<p><strong>Balance:</strong> $" . $row["balance"] . "</p>";
                echo "<a href='transfer.php?id=" . $row["id"] . "'>Transfer Money</a>";
            } else {
                echo "Customer not found.";
            }
            
            // Close the database connection
            $conn->close();
        } else {
            echo "Invalid customer ID.";
        }
        ?>
    </main>
    <footer>
        <p>&copy; 2023 Sparks Bank by Amarjeet Kaur.<br> All rights reserved.<br> Powered by Sparks Foundation.</p>
    </footer>
</body>
</html>
