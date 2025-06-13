<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM audit_report ORDER BY audit_no DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Audit Report List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Audit Report List</span>
        <a href="add_audit_report.php" class="btn btn-success">+ Add New Report</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Audit Reports</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>AUDIT No.</th>
                <th>REPORT No.</th>
                <th>DEPARTMENT CODE</th>
                <th>DEPARTMENT NAME</th>
                <th>EMPLOYEE CODE (Auditor)</th>
                <th>EMPLOYEE NAME (Auditor)</th>
                <th>EMPLOYEE CODE (Auditee)</th>
                <th>EMPLOYEE NAME (Auditee)</th>
                <th>Std/Doc Ref</th>
                <th>Problems Identified / Potential Concerns</th>
                <th>Proposed Action to Prevent Recurrence of Root Cause</th>
                <th>Target Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['audit_no']) ?></td>
                <td><?= htmlspecialchars($row['report_no']) ?></td>
                <td><?= htmlspecialchars($row['department_code']) ?></td>
                <td><?= htmlspecialchars($row['department_name']) ?></td>
                <td><?= htmlspecialchars($row['auditor_employee_code']) ?></td>
                <td><?= htmlspecialchars($row['auditor_employee_name']) ?></td>
                <td><?= htmlspecialchars($row['auditee_employee_code']) ?></td>
                <td><?= htmlspecialchars($row['auditee_employee_name']) ?></td>
                <td><?= htmlspecialchars($row['std_doc_ref']) ?></td>
                <td><?= htmlspecialchars($row['problems_identified']) ?></td>
                <td><?= htmlspecialchars($row['proposed_action']) ?></td>
                <td><?= htmlspecialchars($row['target_date']) ?></td>
                <td>
                    <a href="edit_audit_report.php?audit_no=<?= $row['audit_no'] ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="delete_audit_report.php?audit_no=<?= $row['audit_no'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this report?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
