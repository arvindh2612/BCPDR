<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Search + Filter handling
$search = $_GET['search'] ?? '';
$company = $_GET['company'] ?? '';
$department = $_GET['department'] ?? '';

$where = "WHERE 1";
if ($search !== '') {
    $search = $conn->real_escape_string($search);
    $where .= " AND (employee_code LIKE '%$search%' OR first_name LIKE '%$search%' OR last_name LIKE '%$search%')";
}
if ($company !== '') {
    $company = $conn->real_escape_string($company);
    $where .= " AND company = '$company'";
}
if ($department !== '') {
    $department = $conn->real_escape_string($department);
    $where .= " AND department = '$department'";
}

$query = "SELECT * FROM employees $where ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee List</title>
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
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Employee Master</span>
        <span class="text-light">
            <a href="add_employee.php" class="text-light text-decoration-none me-3">👤 Add Employee</a>
            <a href="employee_list.php" class="text-light text-decoration-none">👥 Employee List</a>
        </span>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Employee List</h2>

    <form method="get" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Search by Employee Name or Code">
        </div>
        <div class="col-md-3">
            <select name="company" class="form-select">
                <option value="">All Companies</option>
                <option value="Company A" <?= $company == 'Company A' ? 'selected' : '' ?>>Company A</option>
                <option value="Company B" <?= $company == 'Company B' ? 'selected' : '' ?>>Company B</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="department" class="form-select">
                <option value="">All Departments</option>
                <option value="HR" <?= $department == 'HR' ? 'selected' : '' ?>>HR</option>
                <option value="IT" <?= $department == 'IT' ? 'selected' : '' ?>>IT</option>
                <option value="Sales" <?= $department == 'Sales' ? 'selected' : '' ?>>Sales</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Employee Code</th>
                <th>Full Name</th>
                <th>Company</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Location</th>
                <th>Phone(s)</th>
                <th>Email(s)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['employee_code']) ?></td>
                    <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']) ?></td>
                    <td><?= htmlspecialchars($row['company']) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td><?= htmlspecialchars($row['designation']) ?></td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td><?= htmlspecialchars($row['phone1']) ?><?= $row['phone2'] ? ', ' . htmlspecialchars($row['phone2']) : '' ?></td>
                    <td><?= htmlspecialchars($row['email1']) ?><?= $row['email2'] ? ', ' . htmlspecialchars($row['email2']) : '' ?></td>
                    <td>
    <a href="edit_employee.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
    <a href="delete_employee.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this employee?')">Delete</a>
</td>

                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="9" class="text-center">No employees found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
