<!DOCTYPE html>
<html>
<head>
    <title>Money Transfer - View All Customers</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
<style>
    .background-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }


.background-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


.customer-container {
            margin: 20px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
</style>


</head>
<body>
    <header>
        <h1>View All Customers  <img src ="images/download.png"></h1>
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
<div class="background-container">
<img src=" images/OrdinaryWellinformedGosling-max-1mb.gif">

</div>



        <div class="customer-container"><?php
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'money_transfer');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Fetch all customers from the database
        $sql = "SELECT * FROM customers";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Balance</th><th>Action</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["balance"] . "</td>";
                echo "<td><a href='customer.php?id=" . $row["id"] . "'>View</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No customers found.";
        }
        
        // Close the database connection
        $conn->close();
        ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2023 Sparks Bank by Amarjeet Kaur.<br> All rights reserved.<br> Powered by Sparks Foundation.</p>
    </footer>
</body>
</html>
