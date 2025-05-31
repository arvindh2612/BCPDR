<?php
$conn = new mysqli("localhost", "root", "", "BCPDR");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$code = $_GET['code'] ?? '';
$code = $conn->real_escape_string($code);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $companyName = $_POST['CompanyName'];
    $cityCode = $_POST['CityCode'];
    $pincode = $_POST['Pincode'];
    $primaryContact = $_POST['PrimaryContactName'];
    $officePhone = $_POST['OfficePhoneNumber'];
    $email = $_POST['EmailAddress'];

    $stmt = $conn->prepare("UPDATE CompanyMaster SET CompanyName=?, CityCode=?, Pincode=?, PrimaryContactName=?, OfficePhoneNumber=?, EmailAddress=? WHERE CompanyCode=?");
    $stmt->bind_param("sssssss", $companyName, $cityCode, $pincode, $primaryContact, $officePhone, $email, $code);
    $stmt->execute();

    header("Location: list_company.php");
    exit;
}

// Fetch company data
$query = "SELECT * FROM CompanyMaster WHERE CompanyCode = '$code'";
$result = $conn->query($query);
$company = $result->fetch_assoc();

// Fetch cities for dropdown - Note the column names in your city_master table are lowercase
$cityResult = $conn->query("SELECT city_code, city_name FROM city_master ORDER BY city_name");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Company</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Company - <?= htmlspecialchars($company['CompanyName']) ?></h2>
    <form method="post">
        <div class="mb-3">
            <label>Company Name</label>
            <input type="text" name="CompanyName" class="form-control" value="<?= htmlspecialchars($company['CompanyName']) ?>" required>
        </div>
        <div class="mb-3">
            <label>City Code</label>
            <select name="CityCode" class="form-select" required>
                <option value="">-- Select City --</option>
                <?php
                if ($cityResult->num_rows > 0) {
                    while ($city = $cityResult->fetch_assoc()) {
                        // Use lowercase keys according to your city_master table design
                        $selected = ($city['city_code'] === $company['CityCode']) ? 'selected' : '';
                        echo "<option value=\"" . htmlspecialchars($city['city_code']) . "\" $selected>" 
                            . htmlspecialchars($city['city_name']) . " (" . htmlspecialchars($city['city_code']) . ")</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Pincode</label>
            <input type="text" name="Pincode" class="form-control" value="<?= htmlspecialchars($company['Pincode']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Primary Contact</label>
            <input type="text" name="PrimaryContactName" class="form-control" value="<?= htmlspecialchars($company['PrimaryContactName']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Office Phone</label>
            <input type="text" name="OfficePhoneNumber" class="form-control" value="<?= htmlspecialchars($company['OfficePhoneNumber']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Email Address</label>
            <input type="email" name="EmailAddress" class="form-control" value="<?= htmlspecialchars($company['EmailAddress']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Company</button>
        <a href="list_company.php" class="btn btn-secondary">Back</a>
    </form>

<footer class="bg-dark text-white text-center py-3 mt-5">
    © 2025 BCPDR System. All rights reserved.
</footer>
</div>
</body>
</html>
