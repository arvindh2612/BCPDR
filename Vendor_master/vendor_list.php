<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $stmt = $conn->prepare("DELETE FROM vendors WHERE id = ?");
    $stmt->bind_param("i", $_GET['delete_id']);
    $stmt->execute();
    $stmt->close();
    header("Location: vendor_list.php");
    exit;
}

$result = $conn->query("SELECT * FROM vendors");
$status_map = ['1' => 'Active', '2' => 'Suspended', '3' => 'Terminated'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vendor List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Vendor Master</span>
        <span class="text-light">
            <a href="add_vendor.php" class="text-light text-decoration-none me-3">➕ Add Vendor</a>
            <a href="vendor_list.php" class="text-light text-decoration-none">📋 Vendor List</a>
        </span>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="mb-3">Vendor List</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Vendor Code</th>
                <th>Company Code</th>
                <th>Category Code</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['vendor_code']) ?></td>
                    <td><?= htmlspecialchars($row['company_code']) ?></td>
                    <td><?= htmlspecialchars($row['category_code']) ?></td>
                    <td><?= htmlspecialchars($row['start_date']) ?></td>
                    <td><?= htmlspecialchars($row['end_date']) ?></td>
                    <td><?= $status_map[$row['status']] ?? 'Unknown' ?></td>
                    <td>
                        <a href="edit_vendor.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="vendor_list.php?delete_id=<?= $row['id'] ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Are you sure you want to delete this vendor?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<footer class="bg-dark text-white text-center py-3 mt-4">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
