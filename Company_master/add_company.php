<?php 
// DB connection 
$conn = new mysqli("localhost", "root", "", "BCPDR");  
if ($conn->connect_error) {     
    die("Connection failed: " . $conn->connect_error); 
}  

// Fetch city codes for dropdown
$cityOptions = [];
$cityResult = $conn->query("SELECT city_code, city_name FROM city_master ORDER BY city_name ASC");
if ($cityResult) {
    while ($row = $cityResult->fetch_assoc()) {
        $cityOptions[] = $row;
    }
    $cityResult->free();
}

// Handle form submission 
if ($_SERVER["REQUEST_METHOD"] == "POST") {     
    $company_code = $_POST['company_code'];     
    $company_name = $_POST['company_name'];     
    $address1 = $_POST['address1'];     
    $address2 = $_POST['address2'];     
    $address3 = $_POST['address3'];     
    $city_code = $_POST['city_code'];     
    $pincode = $_POST['pincode'];     
    $primary_contact_name = $_POST['primary_contact_name'];     
    $office_phone_number = $_POST['office_phone_number'];     
    $emergency_phone_number = $_POST['emergency_phone_number'];     
    $secondary_contact_name = $_POST['secondary_contact_name'];     
    $email_address = $_POST['email_address'];     
    $special_instructions = $_POST['special_instructions'];      

    // Prepare and bind to avoid SQL injection     
    $stmt = $conn->prepare("INSERT INTO CompanyMaster (CompanyCode, CompanyName, Address1, Address2, Address3, CityCode, Pincode, PrimaryContactName, OfficePhoneNumber, EmergencyPhoneNumber, SecondaryContactName, EmailAddress, SpecialInstructions) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");     
    $stmt->bind_param("sssssssssssss", $company_code, $company_name, $address1, $address2, $address3, $city_code, $pincode, $primary_contact_name, $office_phone_number, $emergency_phone_number, $secondary_contact_name, $email_address, $special_instructions);      

    if ($stmt->execute()) {         
        echo "<script>alert('Company added successfully'); window.location='add_company.php';</script>";     
    } else {         
        echo "Error: " . $stmt->error;     
    }     
    $stmt->close(); 
} 
?>

<!DOCTYPE html> 
<html> 
<head>     
    <title>Add Company</title>     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">     
    <style>         
        body {             
            background-color: #f9f9f9;         
        }         
        .form-container {             
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
        <span class="navbar-brand mb-0 h1">Company Master</span>         
        <span class="text-light">             
            <a href="add_company.php" class="text-light text-decoration-none me-3">🏢 Add Company</a>             
            <a href="list_company.php" class="text-light text-decoration-none">📋 Company List</a>         
        </span>     
    </div> 
</nav>  

<div class="container">     
    <div class="form-container">         
        <h2 class="mb-4">Add Company</h2>         
        <form method="post" autocomplete="off">             
            <div class="row mb-3">                 
                <div class="col-md-4">                     
                    <label>Company Code *</label>                     
                    <input type="text" name="company_code" class="form-control" required maxlength="50">                 
                </div>                 
                <div class="col-md-8">                     
                    <label>Company Name *</label>                     
                    <input type="text" name="company_name" class="form-control" required maxlength="100">                 
                </div>             
            </div>              

            <div class="mb-3">                 
                <label>Address 1 *</label>                 
                <input type="text" name="address1" class="form-control" required maxlength="255">             
            </div>             
            <div class="mb-3">                 
                <label>Address 2</label>                 
                <input type="text" name="address2" class="form-control" maxlength="255">             
            </div>             
            <div class="mb-3">                 
                <label>Address 3</label>                 
                <input type="text" name="address3" class="form-control" maxlength="255">             
            </div>              

            <div class="row mb-3">                 
                <div class="col-md-4">                     
                    <label>City Code *</label>                     
                    <select name="city_code" class="form-select" required>
                        <option value="" disabled selected>Select City</option>
                        <?php foreach ($cityOptions as $city): ?>
                            <option value="<?= htmlspecialchars($city['city_code']) ?>">
                                <?= htmlspecialchars($city['city_name']) ?> (<?= htmlspecialchars($city['city_code']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>                 
                <div class="col-md-4">                     
                    <label>Pincode *</label>                     
                    <input type="text" name="pincode" class="form-control" required maxlength="10">                 
                </div>                 
                <div class="col-md-4">                     
                    <label>Primary Contact Name *</label>                     
                    <input type="text" name="primary_contact_name" class="form-control" required maxlength="100">                 
                </div>             
            </div>              

            <div class="row mb-3">                 
                <div class="col-md-4">                     
                    <label>Office Phone Number *</label>                     
                    <input type="text" name="office_phone_number" class="form-control" required maxlength="15">                 
                </div>                 
                <div class="col-md-4">                     
                    <label>Emergency Phone Number</label>                     
                    <input type="text" name="emergency_phone_number" class="form-control" maxlength="15">                 
                </div>                 
                <div class="col-md-4">                     
                    <label>Secondary Contact Name</label>                     
                    <input type="text" name="secondary_contact_name" class="form-control" maxlength="100">                 
                </div>             
            </div>              

            <div class="mb-3">                 
                <label>Email Address *</label>                 
                <input type="email" name="email_address" class="form-control" required maxlength="100">             
            </div>              

            <div class="mb-3">                 
                <label>Special Instructions</label>                 
                <textarea name="special_instructions" class="form-control" rows="3"></textarea>             
            </div>              

            <div class="d-flex gap-2">                 
                <button type="submit" class="btn btn-primary">Add Company</button>                 
                <a href="company_list.php" class="btn btn-secondary">Cancel</a>             
            </div>         
        </form>     
    </div> 
</div>  

<footer class="bg-dark text-white text-center py-3">     
    © 2025 BCPDR System. All rights reserved. 
</footer> 
</body> 
</html>
