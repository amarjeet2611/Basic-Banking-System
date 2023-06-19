<!DOCTYPE html>
<html>
<head>
    <title>Money Transfer - Transaction History</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Transaction History</h1>
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
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'money_transfer');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch transaction history from the database
        $sql = "SELECT * FROM transfers";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>ID</th><th>Sender ID</th><th>Receiver ID</th><th>Amount</th><th>Timestamp</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['sender_id'] . '</td>';
                echo '<td>' . $row['receiver_id'] . '</td>';
                echo '<td>' . $row['amount'] . '</td>';
                echo '<td>' . $row['timestamp'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo "No transaction history found.";
        }

        // Close the database connection
        $conn->close();
        ?>
    </main>
    <footer>
        <p>&copy; 2023 Sparks Bank by Amarjeet Kaur.<br> All rights reserved.<br>Powered by Sparks Foundation.</p>
    </footer>
</body>
</html>

