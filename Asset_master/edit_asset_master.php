<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch asset data by ID
$stmt = $conn->prepare("SELECT * FROM asset_master WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows === 0) {
    die("Asset not found.");
}
$row = $result->fetch_assoc();

// Fetch data for dropdowns
$vendors = $conn->query("SELECT vendor_code FROM vendors WHERE status = '1'");
$locations = $conn->query("SELECT location_code FROM locations");
$departments = $conn->query("SELECT DepartmentCode FROM department_master");
$owners = $conn->query("SELECT first_name FROM employees");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $asset_id_code = $_POST["asset_id_code"];
    $asset_class_code = $_POST["asset_class_code"];
    $new_old = $_POST["new_old"];
    $purchase_date = $_POST["purchase_date"];
    $invoice_no = $_POST["invoice_no"];
    $vendor_code = $_POST["vendor_code"];
    $location_code = $_POST["location_code"];
    $department_code = $_POST["department_code"];
    $asset_owner = $_POST["asset_owner"];
    $asset_value = $_POST["asset_value"];

    // Update with prepared statement
    $update_stmt = $conn->prepare("UPDATE asset_master SET 
        asset_id_code = ?, 
        asset_class_code = ?, 
        new_old = ?, 
        purchase_date = ?, 
        invoice_no = ?, 
        vendor_code = ?, 
        location_code = ?, 
        department_code = ?, 
        asset_owner = ?, 
        asset_value = ? 
        WHERE id = ?");

    $update_stmt->bind_param(
        "ssssssssssi",
        $asset_id_code,
        $asset_class_code,
        $new_old,
        $purchase_date,
        $invoice_no,
        $vendor_code,
        $location_code,
        $department_code,
        $asset_owner,
        $asset_value,
        $id
    );

    if ($update_stmt->execute()) {
        header("Location: asset_master_list.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Asset Master</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Edit Asset</span>
        <a href="asset_master_list.php" class="text-light text-decoration-none">📄 Back to List</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Edit Asset</h2>
    <form method="post">
        <div class="mb-3">
            <label>Asset ID Code</label>
            <input type="text" name="asset_id_code" class="form-control" value="<?= htmlspecialchars($row['asset_id_code']) ?>" required maxlength="10">
        </div>
        <div class="mb-3">
            <label>Asset Class Code</label>
            <input type="text" name="asset_class_code" class="form-control" value="<?= htmlspecialchars($row['asset_class_code']) ?>" required maxlength="10">
        </div>
        <div class="mb-3">
            <label>New / Old</label>
            <select name="new_old" class="form-select" required>
                <option value="">Select</option>
                <option value="NEW" <?= ($row['new_old'] == 'NEW') ? 'selected' : '' ?>>NEW</option>
                <option value="OLD" <?= ($row['new_old'] == 'OLD') ? 'selected' : '' ?>>OLD</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Purchase Date</label>
            <input type="date" name="purchase_date" class="form-control" value="<?= htmlspecialchars($row['purchase_date']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Invoice No.</label>
            <input type="text" name="invoice_no" class="form-control" value="<?= htmlspecialchars($row['invoice_no']) ?>" required maxlength="20">
        </div>

        <div class="mb-3">
            <label>Vendor Code</label>
            <select name="vendor_code" class="form-select" required>
                <option value="">Select Vendor</option>
                <?php while ($v = $vendors->fetch_assoc()) { ?>
                    <option value="<?= htmlspecialchars($v['vendor_code']) ?>" <?= ($row['vendor_code'] == $v['vendor_code']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($v['vendor_code']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Location Code</label>
            <select name="location_code" class="form-select" required>
                <option value="">Select Location</option>
                <?php while ($l = $locations->fetch_assoc()) { ?>
                    <option value="<?= htmlspecialchars($l['location_code']) ?>" <?= ($row['location_code'] == $l['location_code']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($l['location_code']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Department Code</label>
            <select name="department_code" class="form-select" required>
                <option value="">Select Department</option>
                <?php while ($d = $departments->fetch_assoc()) { ?>
                    <option value="<?= htmlspecialchars($d['DepartmentCode']) ?>" <?= ($row['department_code'] == $d['DepartmentCode']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($d['DepartmentCode']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Asset Owner (Employee First Name)</label>
            <select name="asset_owner" class="form-select" required>
                <option value="">Select Owner</option>
                <?php while ($e = $owners->fetch_assoc()) { ?>
                    <option value="<?= htmlspecialchars($e['first_name']) ?>" <?= ($row['asset_owner'] == $e['first_name']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($e['first_name']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Asset Value</label>
            <input type="number" step="0.01" min="0" name="asset_value" class="form-control" value="<?= htmlspecialchars($row['asset_value']) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
<br>
<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
