<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $asset_id_code = $conn->real_escape_string($_POST["asset_id_code"]);
    $asset_class_code = $conn->real_escape_string($_POST["asset_class_code"]);
    $new_old = $conn->real_escape_string($_POST["new_old"]);
    $purchase_date = $conn->real_escape_string($_POST["purchase_date"]);
    $invoice_no = $conn->real_escape_string($_POST["invoice_no"]);
    $vendor_code = $conn->real_escape_string($_POST["vendor_code"]);
    $location_code = $conn->real_escape_string($_POST["location_code"]);
    $department_code = $conn->real_escape_string($_POST["department_code"]);
    $asset_owner = $conn->real_escape_string($_POST["asset_owner"]);
    $asset_value = $conn->real_escape_string($_POST["asset_value"]);

    $conn->query("INSERT INTO asset_master 
        (asset_id_code, asset_class_code, new_old, purchase_date, invoice_no, vendor_code, location_code, department_code, asset_owner, asset_value) 
        VALUES 
        ('$asset_id_code', '$asset_class_code', '$new_old', '$purchase_date', '$invoice_no', '$vendor_code', '$location_code', '$department_code', '$asset_owner', '$asset_value')");

    header("Location: asset_master_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Asset Master</title>
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
        <div class="mb-3">
            <label>Asset ID Code</label>
            <input type="text" name="asset_id_code" class="form-control" required maxlength="10">
        </div>
        <div class="mb-3">
            <label>Asset Class Code</label>
            <input type="text" name="asset_class_code" class="form-control" required maxlength="10">
        </div>
        <div class="mb-3">
            <label>New / Old</label>
            <select name="new_old" class="form-select" required>
                <option value="">Select</option>
                <option value="NEW">NEW</option>
                <option value="OLD">OLD</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Purchase Date</label>
            <input type="date" name="purchase_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Invoice No.</label>
            <input type="text" name="invoice_no" class="form-control" required maxlength="20">
        </div>
        <div class="mb-3">
            <label>Vendor Code</label>
            <input type="text" name="vendor_code" class="form-control" required maxlength="10">
        </div>
        <div class="mb-3">
            <label>Location Code</label>
            <input type="text" name="location_code" class="form-control" required maxlength="10">
        </div>
        <div class="mb-3">
            <label>Department Code</label>
            <input type="text" name="department_code" class="form-control" required maxlength="10">
        </div>
        <div class="mb-3">
            <label>Asset Owner</label>
            <input type="text" name="asset_owner" class="form-control" required maxlength="10">
        </div>
        <div class="mb-3">
            <label>Asset Value</label>
            <input type="number" step="0.01" min="0" name="asset_value" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
    
</div>
<br>
<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
