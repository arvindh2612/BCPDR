<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");
$result = $conn->query("SELECT * FROM asset_master ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Asset List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Asset Master</span>
        <a href="add_asset_master.php" class="text-light text-decoration-none">➕ Add Asset</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Asset List</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Asset ID Code</th>
                <th>Asset Class Code</th>
                <th>New / Old</th>
                <th>Purchase Date</th>
                <th>Invoice No.</th>
                <th>Vendor Code</th>
                <th>Location Code</th>
                <th>Department Code</th>
                <th>Asset Owner</th>
                <th>Asset Value</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['asset_id_code']) ?></td>
                <td><?= htmlspecialchars($row['asset_class_code']) ?></td>
                <td><?= isset($row['new_old']) ? htmlspecialchars($row['new_old']) : '' ?></td>

                <td><?= htmlspecialchars($row['purchase_date']) ?></td>
                <td><?= htmlspecialchars($row['invoice_no']) ?></td>
                <td><?= htmlspecialchars($row['vendor_code']) ?></td>
                <td><?= htmlspecialchars($row['location_code']) ?></td>
                <td><?= htmlspecialchars($row['department_code']) ?></td>
                <td><?= htmlspecialchars($row['asset_owner']) ?></td>
                <td><?= number_format($row['asset_value'], 2) ?></td>
                <td>
                    <a href="edit_asset_master.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                    <a href="delete_asset_master.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this asset?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<br>
<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
