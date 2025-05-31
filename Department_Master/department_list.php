<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Search filter
$search = $_GET['search'] ?? '';

$where = "WHERE 1";
if ($search !== '') {
    $search = $conn->real_escape_string($search);
    $where .= " AND (DepartmentCode LIKE '%$search%' OR DepartmentName LIKE '%$search%')";
}

$query = "SELECT * FROM department_master $where ORDER BY DepartmentCode";
$result = $conn->query($query);

// Handle delete if requested
if (isset($_GET['delete'])) {
    $delCode = $conn->real_escape_string($_GET['delete']);
    $conn->query("DELETE FROM department_master WHERE DepartmentCode='$delCode'");
    header("Location: department_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Department List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
        }
        .container {
            margin-top: 40px;
            margin-bottom: 40px;
        }
        .table thead {
            background-color: #212529;
            color: #fff;
        }
    </style>
    <script>
        function confirmDelete(code) {
            if (confirm("Are you sure you want to delete Department: " + code + "?")) {
                window.location.href = "department_list.php?delete=" + code;
            }
        }
    </script>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Department Master</span>
        <span class="text-light">
            <a href="add_department.php" class="text-light text-decoration-none me-3">➕ Add Department</a>
            <a href="department_list.php" class="text-light text-decoration-none">📋 Department List</a>
        </span>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Department List</h2>

    <form method="get" class="row g-2 mb-3">
        <div class="col-md-6">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Search by Department Code or Name">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Department Code</th>
                <th>Department Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['DepartmentCode']) ?></td>
                    <td><?= htmlspecialchars($row['DepartmentName']) ?></td>
                    <td>
                        <a href="edit_department.php?code=<?= urlencode($row['DepartmentCode']) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <button onclick="confirmDelete('<?= htmlspecialchars($row['DepartmentCode']) ?>')" class="btn btn-sm btn-outline-danger">Delete</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3" class="text-center">No departments found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
