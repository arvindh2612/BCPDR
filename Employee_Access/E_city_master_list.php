<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");
$result = $conn->query("SELECT * FROM city_master ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>City Master List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">City Master</span>
    </div>
</nav>

<div class="container mt-4">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>City Code</th>
                <th>City Name</th>
                <th>State Code</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['city_code']) ?></td>
                <td><?= htmlspecialchars($row['city_name']) ?></td>
                <td><?= htmlspecialchars($row['state_code']) ?></td>
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
