<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: location_list.php");
    exit;
}

$errors = [];

// Fetch existing data
$result = $conn->query("SELECT * FROM locations WHERE id = $id");
if ($result->num_rows === 0) {
    header("Location: location_list.php");
    exit;
}
$location = $result->fetch_assoc();

// Fetch distinct cities from CompanyMaster for dropdown
$cities_result = $conn->query("SELECT DISTINCT CityCode FROM CompanyMaster ORDER BY CityCode");
$cities = [];
while ($row = $cities_result->fetch_assoc()) {
    $cities[] = $row['CityCode'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location_code = $conn->real_escape_string(trim($_POST['location_code']));
    $location_name = $conn->real_escape_string(trim($_POST['location_name']));
    $building_name = $conn->real_escape_string(trim($_POST['building_name']));
    $address1 = $conn->real_escape_string(trim($_POST['address1']));
    $address2 = $conn->real_escape_string(trim($_POST['address2']));
    $address3 = $conn->real_escape_string(trim($_POST['address3']));
    $city = $conn->real_escape_string(trim($_POST['city']));
    $pincode = (int)$_POST['pincode'];

    if ($location_code == '') $errors[] = "Location Code is required";
    if ($location_name == '') $errors[] = "Location Name is required";
    if ($city == '') $errors[] = "City is required";

    if (empty($errors)) {
        // Check if location_code is unique (exclude current record)
        $check = $conn->query("SELECT id FROM locations WHERE location_code = '$location_code' AND id != $id");
        if ($check->num_rows > 0) {
            $errors[] = "Location Code already exists.";
        } else {
            $sql = "UPDATE locations SET
                location_code = '$location_code',
                location_name = '$location_name',
                building_name = '$building_name',
                address1 = '$address1',
                address2 = '$address2',
                address3 = '$address3',
                city = '$city',
                pincode = $pincode
                WHERE id = $id";

            if ($conn->query($sql)) {
                header("Location: location_list.php");
                exit;
            } else {
                $errors[] = "Database error: " . $conn->error;
            }
        }
    }
} else {
    // Pre-fill form with current data
    $location_code = $location['location_code'];
    $location_name = $location['location_name'];
    $building_name = $location['building_name'];
    $address1 = $location['address1'];
    $address2 = $location['address2'];
    $address3 = $location['address3'];
    $city = $location['city'];
    $pincode = $location['pincode'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> body { background-color: #f9f9f9; } .container { margin-top: 40px; margin-bottom: 40px; } </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">Edit Location</span>
        <a href="location_list.php" class="btn btn-outline-light btn-sm">← Back to List</a>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Edit Location</h2>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul><?php foreach ($errors as $error) echo "<li>" . htmlspecialchars($error) . "</li>"; ?></ul>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Location Code *</label>
            <input type="text" name="location_code" class="form-control" maxlength="10" value="<?= htmlspecialchars($location_code) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Location Name *</label>
            <input type="text" name="location_name" class="form-control" maxlength="100" value="<?= htmlspecialchars($location_name) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Building Number / Name</label>
            <input type="text" name="building_name" class="form-control" maxlength="100" value="<?= htmlspecialchars($building_name) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Address 1</label>
            <input type="text" name="address1" class="form-control" maxlength="100" value="<?= htmlspecialchars($address1) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Address 2</label>
            <input type="text" name="address2" class="form-control" maxlength="101" value="<?= htmlspecialchars($address2) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Address 3</label>
            <input type="text" name="address3" class="form-control" maxlength="102" value="<?= htmlspecialchars($address3) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">City *</label>
            <select name="city" class="form-control" required>
                <option value="">-- Select City --</option>
                <?php foreach ($cities as $city_code_option): ?>
                    <option value="<?= htmlspecialchars($city_code_option) ?>" <?= ($city_code_option === $city) ? "selected" : "" ?>>
                        <?= htmlspecialchars($city_code_option) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Pincode</label>
            <input type="number" name="pincode" class="form-control" maxlength="6" value="<?= htmlspecialchars($pincode) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Location</button>
    </form>
</div>

<footer class="bg-dark text-white text-center py-3 mt-5">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
