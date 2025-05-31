<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");
$result = $conn->query("SELECT * FROM corrective_preventive_action_report ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Corrective/Preventive Action Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Optional: word wrap for long text in Problems column */
        td.problems { max-width: 300px; white-space: pre-wrap; word-wrap: break-word; }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Corrective/Preventive Action Reports</span>
        <a href="add_cpar.php" class="btn btn-success">➕ Add Report</a>
    </div>
</nav>

<div class="container mt-4">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Employee Code</th>
                <th>Employee Name</th>
                <th>Designation</th>
                <th>Department</th>
                <th>Date</th>
                <th>System Code</th>
                <th>System Name</th>
                <th>Ref/Transaction/Batch No.</th>
                <th>Problems Identified</th>
                <th>Target Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['employee_code']) ?></td>
                <td><?= htmlspecialchars($row['employee_name']) ?></td>
                <td><?= htmlspecialchars($row['designation']) ?></td>
                <td><?= htmlspecialchars($row['department']) ?></td>
                <td><?= htmlspecialchars($row['action_date']) ?></td>
                <td><?= htmlspecialchars($row['system_code']) ?></td>
                <td><?= htmlspecialchars($row['system_name']) ?></td>
                <td><?= htmlspecialchars($row['ref_transaction_batch_no']) ?></td>
                <td class="problems"><?= nl2br(htmlspecialchars($row['problems_identified'])) ?></td>
                <td><?= htmlspecialchars($row['target_date']) ?></td>
                <td>
                    <a href="edit_cpar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="delete_cpar.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this report?');">Delete</a>
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
