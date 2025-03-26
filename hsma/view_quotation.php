<?php
session_start();
include 'db.php'; // Include your database connection file

// Check if the user is logged in and is a manager
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'manager') {
    header("Location: homepage.php");
    exit;
}

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    die("Invalid quotation ID.");
}

// Query to fetch the quotation details
$sql = "SELECT * FROM quotations WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$quotation = $result->fetch_assoc();

if (!$quotation) {
    die("Quotation not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view_quotation.css">
    <title>View Quotation</title>
</head>
<body>
    <div class="container">
    <h1>Quotation Details</h1>
    <hr>
    <table>
        <?php foreach ($quotation as $key => $value): ?>
        <tr>
            <th><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $key))); ?></th>
            <td><?php echo htmlspecialchars($value); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="manager_quotation.php">Back to Quotations</a>
    </div>
</body>
</html>