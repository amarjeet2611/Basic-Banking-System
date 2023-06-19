<!DOCTYPE html>
<html>
<head>
    <title>Money Transfer - Transfer Money</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .transfer-section {
            margin-bottom: 20px;
        }
        .gif-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 300px; /* Adjust the height as needed */
        }

        .gif-container img {
            max-width: 100%;
            max-height: 100%;
        }

    </style>
</head>
<body>
    <header>
        <h1>Transfer Money <img src="images/transfermoney.jpg "></h1>
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
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sender_id = $_POST["sender_id"];
            $receiver_id = $_POST["receiver_id"];
            $amount = $_POST["amount"];

            // Database connection
            $conn = new mysqli('localhost', 'root', '', 'money_transfer');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch sender details from the database
            $sender_sql = "SELECT * FROM customers WHERE id = $sender_id";
            $sender_result = $conn->query($sender_sql);

            if ($sender_result->num_rows > 0) {
                $sender_row = $sender_result->fetch_assoc();
                $sender_name = $sender_row["name"];
                $sender_balance = $sender_row["balance"];

                // Fetch receiver details from the database
                $receiver_sql = "SELECT * FROM customers WHERE id = $receiver_id";
                $receiver_result = $conn->query($receiver_sql);

                if ($receiver_result->num_rows > 0) {
                    $receiver_row = $receiver_result->fetch_assoc();
                    $receiver_name = $receiver_row["name"];
                    $receiver_balance = $receiver_row["balance"];

                    if ($amount <= $sender_balance) {
                        // Update sender's balance
                        $sender_new_balance = $sender_balance - $amount;
                        $update_sender_sql = "UPDATE customers SET balance = $sender_new_balance WHERE id = $sender_id";
                        $conn->query($update_sender_sql);

                        // Update receiver's balance
                        $receiver_new_balance = $receiver_balance + $amount;
                        $update_receiver_sql = "UPDATE customers SET balance = $receiver_new_balance WHERE id = $receiver_id";
                        $conn->query($update_receiver_sql);

                        echo "<h2>Money Transferred Successfully!</h2>";
                        echo "<p>Amount: $" . $amount . "</p>";
                        echo "<p>From: " . $sender_name . "</p>";
                        echo "<p>To: " . $receiver_name . "</p>";
                    } else {
                        echo "Insufficient balance.";
                    }
                } else {
                    echo "Receiver not found.";
                }
            } else {
                echo "Sender not found.";
            }

            // Close the database connection
            $conn->close();
        } else {
            // Check if the 'id' parameter is present in the URL
            if (isset($_GET['id'])) {
                $sender_id = $_GET['id'];

                // Database connection
                $conn = new mysqli('localhost', 'root', '', 'money_transfer');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch all customers except the sender
                $sql = "SELECT * FROM customers WHERE id != $sender_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    ?>
                    <form action="transfer.php" method="post">
                        <div class="transfer-section">
                            <h2>Select Receiver</h2>
                            <select name="receiver_id">
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="transfer-section">
                            <h2>Enter Amount</h2>
                            <input type="number" name="amount" required>
                        </div>
                        <input type="hidden" name="sender_id" value="<?php echo $sender_id; ?>">
                        <button type="submit">Transfer</button>
                    </form>
                    <?php
                } else {
                    echo "No customers found.";
                }

                // Close the database connection
                $conn->close();
            } else {
                echo "Invalid request.";
            }
        }
        ?>

<div class="gif-container">
            <img src="images/6df8570f-45ae-4686-b024-30411795da26_626x432.gif" >
        </div>
    </main>
    <footer>
        <p>&copy; 2023 Sparks Bank by Amarjeet Kaur.<br> All rights reserved.<br> Powered by Sparks Foundation.</p>
    </footer>
</body>
</html>
