<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $expense_date = $_POST['expense_date'];

    $stmt = $conn->prepare("INSERT INTO expenses (user_id, category, amount, description, expense_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isdss", $user_id, $category, $amount, $description, $expense_date);

    if ($stmt->execute()) {
        echo "Expense added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$expenses = $conn->query("SELECT * FROM expenses WHERE user_id = $user_id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <h2>Dashboard</h2>
    <form method="POST" action="">
        <label>Category:</label>
        <input type="text" name="category" required>
        <br>
        <label>Amount:</label>
        <input type="number" step="0.01" name="amount" required>
        <br>
        <label>Description:</label>
        <textarea name="description" required></textarea>
        <br>
        <label>Date:</label>
        <input type="date" name="expense_date" required>
        <br>
        <button type="submit">Add Expense</button>
    </form>
    <h2>Your Expenses</h2>
    <table border="1">
        <tr>
            <th>Category</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Date</th>
        </tr>
        <?php while ($row = $expenses->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['category']; ?></td>
                <td><?php echo $row['amount']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['expense_date']; ?></td>
            </tr>
        <?php } ?>
    </table>
    <form action="logout.php" method="POST">
        <button type="submit">Logout</button>
    </form>
</body>
</html>
