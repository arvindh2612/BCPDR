<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM vendors WHERE id=$id");
    $vendor = $result->fetch_assoc();
}

// Fetch company and category data
$companies = $conn->query("SELECT CompanyCode, CompanyName FROM CompanyMaster");
$categories = $conn->query("SELECT category_code, category_name FROM vendor_category");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $vendor_code = $_POST['vendor_code'];
    $company_code = $_POST['company_code'];
    $category_code = $_POST['category_code'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE vendors SET vendor_code=?, company_code=?, category_code=?, start_date=?, end_date=?, status=? WHERE id=?");
    $stmt->bind_param("ssssssi", $vendor_code, $company_code, $category_code, $start_date, $end_date, $status, $id);
    $stmt->execute();

    header("Location: vendor_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Vendor</title>
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
    <h2>Edit Vendor</h2>
    <form method="post" class="row g-3">
        <input type="hidden" name="id" value="<?= $vendor['id'] ?>">
        <div class="col-md-6">
            <label class="form-label">Vendor Code</label>
            <input type="text" name="vendor_code" class="form-control" required maxlength="10" value="<?= htmlspecialchars($vendor['vendor_code']) ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Company Code</label>
            <select name="company_code" class="form-select" required>
                <option value="">-- Select Company --</option>
                <?php while ($row = $companies->fetch_assoc()): ?>
                    <option value="<?= $row['CompanyCode'] ?>" <?= $row['CompanyCode'] == $vendor['company_code'] ? 'selected' : '' ?>>
                        <?= $row['CompanyCode'] ?> - <?= $row['CompanyName'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Category Code</label>
            <select name="category_code" class="form-select" required>
                <option value="">-- Select Category --</option>
                <?php while ($row = $categories->fetch_assoc()): ?>
                    <option value="<?= $row['category_code'] ?>" <?= $row['category_code'] == $vendor['category_code'] ? 'selected' : '' ?>>
                        <?= $row['category_code'] ?> - <?= $row['category_name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" required value="<?= $vendor['start_date'] ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control" value="<?= $vendor['end_date'] ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="1" <?= $vendor['status'] == '1' ? 'selected' : '' ?>>Active</option>
                <option value="2" <?= $vendor['status'] == '2' ? 'selected' : '' ?>>Suspended</option>
                <option value="3" <?= $vendor['status'] == '3' ? 'selected' : '' ?>>Terminated</option>
            </select>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Update Vendor</button>
        </div>
    </form>
</div>

<footer class="bg-dark text-white text-center py-3 mt-4">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
