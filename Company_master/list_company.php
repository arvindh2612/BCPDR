<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Search handling
$search = $_GET['search'] ?? '';

$where = "WHERE 1";
if ($search !== '') {
    $search = $conn->real_escape_string($search);
    $where .= " AND (CompanyCode LIKE '%$search%' OR CompanyName LIKE '%$search%')";
}

$query = "SELECT * FROM CompanyMaster $where ORDER BY CompanyName ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Company List</title>
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
        <span class="navbar-brand mb-0 h1">Company Master</span>
        <span class="text-light">
            <a href="add_company.php" class="text-light text-decoration-none me-3">🏢 Add Company</a>
            <a href="list_company.php" class="text-light text-decoration-none">📋 Company List</a>
        </span>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Company List</h2>

    <form method="get" class="row g-2 mb-3">
        <div class="col-md-6">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Search by Company Code or Name">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Company Code</th>
                <th>Company Name</th>
                <th>City</th>
                <th>Pincode</th>
                <th>Primary Contact</th>
                <th>Office Phone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['CompanyCode']) ?></td>
                    <td><?= htmlspecialchars($row['CompanyName']) ?></td>
                    <td><?= htmlspecialchars($row['CityCode']) ?></td>
                    <td><?= htmlspecialchars($row['Pincode']) ?></td>
                    <td><?= htmlspecialchars($row['PrimaryContactName']) ?></td>
                    <td><?= htmlspecialchars($row['OfficePhoneNumber']) ?></td>
                    <td><?= htmlspecialchars($row['EmailAddress']) ?></td>
                    <td>
                        <a href="edit_company.php?code=<?= urlencode($row['CompanyCode']) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <a href="delete_company.php?code=<?= urlencode($row['CompanyCode']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this company?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8" class="text-center">No companies found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
