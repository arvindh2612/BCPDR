<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_code = $_POST['asset_id_code'];
    $class_code = $_POST['asset_class_code'];
    $is_new_old = $_POST['is_new_old'];
    $purchase_date = $_POST['purchase_date'];
    $invoice_no = $_POST['invoice_no'];
    $vendor_code = $_POST['vendor_code'];
    $location_code = $_POST['location_code'];
    $department_code = $_POST['department_code'];
    $asset_owner = $_POST['asset_owner'];
    $asset_value = $_POST['asset_value'];

    $stmt = $conn->prepare("INSERT INTO asset_master (
        asset_id_code, asset_class_code, is_new_old, purchase_date, invoice_no,
        vendor_code, location_code, department_code, asset_owner, asset_value
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssd", $id_code, $class_code, $is_new_old, $purchase_date, $invoice_no, $vendor_code, $location_code, $department_code, $asset_owner, $asset_value);
    $stmt->execute();

    header("Location: asset_master_list.php");
    exit();
}

// Fetch dropdown values
$vendors = $conn->query("SELECT vendor_code FROM vendors");
$locations = $conn->query("SELECT location_code FROM locations");
$departments = $conn->query("SELECT DepartmentCode FROM department_master");
$employees = $conn->query("SELECT first_name FROM employees");
$asset_classes = $conn->query("SELECT asset_class_code, asset_class_name FROM asset_class");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Asset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Asset Master</span>
        <a href="asset_master_list.php" class="text-light text-decoration-none">📄 Asset List</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Add Asset</h2>
    <form method="post">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Asset ID Code</label>
                <input type="text" name="asset_id_code" class="form-control" required maxlength="10">
            </div>
            <div class="col-md-4 mb-3">
                <label>Asset Class Code</label>
                <select name="asset_class_code" class="form-control" required>
                    <option value="">-- Select Asset Class --</option>
                    <?php while($row = $asset_classes->fetch_assoc()): ?>
                        <option value="<?= $row['asset_class_code'] ?>">
                            <?= $row['asset_class_code'] ?> - <?= $row['asset_class_name'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label>New / Old</label>
                <select name="is_new_old" class="form-control" required>
                    <option value="New">New</option>
                    <option value="Old">Old</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label>Purchase Date</label>
                <input type="date" name="purchase_date" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>Invoice No.</label>
                <input type="text" name="invoice_no" class="form-control" required maxlength="20">
            </div>
            <div class="col-md-4 mb-3">
                <label>Vendor Code</label>
                <select name="vendor_code" class="form-control" required>
                    <option value="">-- Select Vendor --</option>
                    <?php while($row = $vendors->fetch_assoc()): ?>
                        <option value="<?= $row['vendor_code'] ?>"><?= $row['vendor_code'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label>Location Code</label>
                <select name="location_code" class="form-control" required>
                    <option value="">-- Select Location --</option>
                    <?php while($row = $locations->fetch_assoc()): ?>
                        <option value="<?= $row['location_code'] ?>"><?= $row['location_code'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label>Department Code</label>
                <select name="department_code" class="form-control" required>
                    <option value="">-- Select Department --</option>
                    <?php while($row = $departments->fetch_assoc()): ?>
                        <option value="<?= $row['DepartmentCode'] ?>"><?= $row['DepartmentCode'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label>Asset Owner</label>
                <select name="asset_owner" class="form-control" required>
                    <option value="">-- Select Owner --</option>
                    <?php while($row = $employees->fetch_assoc()): ?>
                        <option value="<?= $row['first_name'] ?>"><?= $row['first_name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label>Asset Value</label>
                <input type="number" name="asset_value" class="form-control" step="0.01" required>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Save Asset</button>
    </form>
</div>

<br>
<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
