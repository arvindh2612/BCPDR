<?php
// add_vendor.php
$conn = new mysqli("localhost", "root", "", "BCPDR");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = [];

// Fetch companies for dropdown
$companyResult = $conn->query("SELECT CompanyCode, CompanyName FROM CompanyMaster ORDER BY CompanyName");
$companies = [];
while ($row = $companyResult->fetch_assoc()) {
    $companies[] = $row;
}

// Fetch categories for dropdown
$categoryResult = $conn->query("SELECT category_code, category_name FROM vendor_category ORDER BY category_name");
$categories = [];
while ($row = $categoryResult->fetch_assoc()) {
    $categories[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vendor_code = trim($_POST['vendor_code']);
    $company_code = trim($_POST['company_code']);
    $category_code = trim($_POST['category_code']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];

    if ($vendor_code == '' || $company_code == '' || $category_code == '') {
        $errors[] = "Vendor, Company, and Category Code are required.";
    }

    if (empty($errors)) {
        $check = $conn->query("SELECT id FROM vendors WHERE vendor_code = '" . $conn->real_escape_string($vendor_code) . "'");
        if ($check->num_rows > 0) {
            $errors[] = "Vendor Code already exists.";
        } else {
            $sql = "INSERT INTO vendors (vendor_code, company_code, category_code, start_date, end_date, status) 
                    VALUES ('" . $conn->real_escape_string($vendor_code) . "', '" . $conn->real_escape_string($company_code) . "', '" . $conn->real_escape_string($category_code) . "', '" . $conn->real_escape_string($start_date) . "', '" . $conn->real_escape_string($end_date) . "', '" . $conn->real_escape_string($status) . "')";
            if ($conn->query($sql)) {
                header("Location: vendor_list.php");
                exit;
            } else {
                $errors[] = "Database error: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Vendor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> 
        body { background-color: #f9f9f9; } 
        .container {   
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-top: 40px;
            margin-bottom: 40px; 
        } 
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Add Vendor</span>
        <a href="vendor_list.php" class="btn btn-outline-light btn-sm">← Back to List</a>
    </div>
</nav>
<div class="container">
    <h2 class="mb-4">Vendor Master</h2>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul><?php foreach ($errors as $error) echo "<li>" . htmlspecialchars($error) . "</li>"; ?></ul>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Vendor Code *</label>
            <input type="text" name="vendor_code" class="form-control" maxlength="10" required value="<?= htmlspecialchars($_POST['vendor_code'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Company Code *</label>
            <select name="company_code" class="form-control" required>
                <option value="">-- Select Company --</option>
                <?php foreach ($companies as $company): ?>
                    <option value="<?= htmlspecialchars($company['CompanyCode']) ?>" <?= (isset($_POST['company_code']) && $_POST['company_code'] === $company['CompanyCode']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($company['CompanyName'] . " (" . $company['CompanyCode'] . ")") ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Category Code *</label>
            <select name="category_code" class="form-control" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category['category_code']) ?>" <?= (isset($_POST['category_code']) && $_POST['category_code'] === $category['category_code']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['category_name'] . " (" . $category['category_code'] . ")") ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($_POST['start_date'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($_POST['end_date'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="1" <?= (isset($_POST['status']) && $_POST['status'] === '1') ? 'selected' : '' ?>>Active</option>
                <option value="2" <?= (isset($_POST['status']) && $_POST['status'] === '2') ? 'selected' : '' ?>>Suspended</option>
                <option value="3" <?= (isset($_POST['status']) && $_POST['status'] === '3') ? 'selected' : '' ?>>Terminated</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Vendor</button>
    </form>
</div>
<footer class="bg-dark text-white text-center py-3 mt-5">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
