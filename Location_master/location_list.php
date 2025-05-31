<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $conn->query("DELETE FROM locations WHERE id = $delete_id");
    header("Location: location_list.php");
    exit;
}

// Filters
$search = $_GET['search'] ?? '';
$where = "WHERE 1";

if ($search !== '') {
    $search = $conn->real_escape_string($search);
    $where .= " AND (location_code LIKE '%$search%' OR location_name LIKE '%$search%' OR city LIKE '%$search%')";
}

$query = "SELECT * FROM locations $where ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Location Master</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f9f9f9; }
        .container { margin-top: 40px; margin-bottom: 40px; }
        .table thead { background-color: #212529; color: #fff; }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Location Master</span>
        <span class="text-light">
            <a href="add_location.php" class="text-light text-decoration-none me-3">➕ Add Location</a>
            <a href="location_list.php" class="text-light text-decoration-none">📋 Location List</a>
        </span>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Location List</h2>

    <form method="get" class="row g-2 mb-3">
        <div class="col-md-6">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Search by Code, Name or City">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Location Code</th>
                <th>Location Name</th>
                <th>Building Name/Num</th>
                <th>Address 1</th>
                <th>Address 2</th>
                <th>Address 3</th>
                <th>City</th>
                <th>Pincode</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['location_code']) ?></td>
                        <td><?= htmlspecialchars($row['location_name']) ?></td>
                        <td><?= htmlspecialchars($row['building_name']) ?></td>
                        <td><?= htmlspecialchars($row['address1']) ?></td>
                        <td><?= htmlspecialchars($row['address2']) ?></td>
                        <td><?= htmlspecialchars($row['address3']) ?></td>
                        <td><?= htmlspecialchars($row['city']) ?></td>
                        <td><?= htmlspecialchars($row['pincode']) ?></td>
                        <td>
                            <a href="edit_location.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                            <a href="location_list.php?delete_id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this location?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="9" class="text-center">No locations found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
