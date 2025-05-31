<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = [];

// Fetch distinct city codes and corresponding names from CompanyMaster
$cityOptions = [];
$cityResult = $conn->query("SELECT DISTINCT CityCode FROM CompanyMaster ORDER BY CityCode");
if ($cityResult) {
    while ($row = $cityResult->fetch_assoc()) {
        $cityOptions[] = $row['CityCode'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location_code = $conn->real_escape_string(trim($_POST['location_code']));
    $location_name = $conn->real_escape_string(trim($_POST['location_name']));
    $building_name = $conn->real_escape_string(trim($_POST['building_name']));
    $address1 = $conn->real_escape_string(trim($_POST['address1']));
    $address2 = $conn->real_escape_string(trim($_POST['address2']));
    $address3 = $conn->real_escape_string(trim($_POST['address3']));
    $city = $conn->real_escape_string(trim($_POST['city_code']));
    $pincode = (int)$_POST['pincode'];

    if ($location_code == '') $errors[] = "Location Code is required";
    if ($location_name == '') $errors[] = "Location Name is required";
    if ($city == '') $errors[] = "City is required";

    if (empty($errors)) {
        $sql = "INSERT INTO locations (location_code, location_name, building_name, address1, address2, address3, city, pincode) VALUES (
            '$location_code', '$location_name', '$building_name', '$address1', '$address2', '$address3', '$city', $pincode
        )";
        if ($conn->query($sql)) {
            header("Location: location_list.php");
            exit;
        } else {
            $errors[] = "Database error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Location</title>
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
        <span class="navbar-brand mb-0 h1">Add Location</span>
        <a href="location_list.php" class="btn btn-outline-light btn-sm">← Back to List</a>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Add Location</h2>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <ul><?php foreach ($errors as $error) echo "<li>" . htmlspecialchars($error) . "</li>"; ?></ul>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Location Code *</label>
            <input type="text" name="location_code" class="form-control" maxlength="10" value="<?= htmlspecialchars($_POST['location_code'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Location Name *</label>
            <input type="text" name="location_name" class="form-control" maxlength="100" value="<?= htmlspecialchars($_POST['location_name'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Building Number / Name</label>
            <input type="text" name="building_name" class="form-control" maxlength="100" value="<?= htmlspecialchars($_POST['building_name'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Address 1</label>
            <input type="text" name="address1" class="form-control" maxlength="100" value="<?= htmlspecialchars($_POST['address1'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Address 2</label>
            <input type="text" name="address2" class="form-control" maxlength="101" value="<?= htmlspecialchars($_POST['address2'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Address 3</label>
            <input type="text" name="address3" class="form-control" maxlength="102" value="<?= htmlspecialchars($_POST['address3'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">City *</label>
            <select name="city_code" class="form-select" required>
                <option value="">Select City</option>
                <?php foreach ($cityOptions as $cityCode): ?>
                    <option value="<?= htmlspecialchars($cityCode) ?>" <?= (isset($_POST['city_code']) && $_POST['city_code'] === $cityCode) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cityCode) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Pincode</label>
            <input type="number" name="pincode" class="form-control" maxlength="6" value="<?= htmlspecialchars($_POST['pincode'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-primary">Add Location</button>
    </form>
</div>

<footer class="bg-dark text-white text-center py-3 mt-5">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
